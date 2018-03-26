<?php declare(strict_types=1);

namespace Locale\Drivers;

use Locale\Locale;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;


/**
 * Class ArrayDriver
 *
 * Static locale driver.
 *
 * @author  geniv
 * @package Locale\Drivers
 */
class ArrayDriver extends Locale
{

    /**
     * ArrayDriver constructor.
     *
     * @param string   $defaultLocale
     * @param array    $locales
     * @param array    $plurals
     * @param array    $aliasLocale
     * @param IStorage $storage
     * @throws \Exception
     * @throws \Throwable
     */
    public function __construct(string $defaultLocale, array $locales, array $plurals = [], array $aliasLocale = [], IStorage $storage)
    {
        $cache = new Cache($storage, 'cache-LocaleDrivers-ArrayDriver');
        // save locales to cache
        $arrayLocales = $cache->load('locales');
        if ($arrayLocales === null) {
            $poc = 1;   // pocatecni simulace id jazyka
            $arrayLocales = array_map(function ($row) use ($locales, $plurals, &$poc) {
                // nacitani kodu jazyka
                $code = array_flip($locales)[$row];
                // skladani pole jazyka
                return [
                    'id'     => $poc++,
                    'name'   => $row,
                    'code'   => $code,
                    'plural' => ($plurals[$code] ?? ''),
                ];
            }, $locales);
            $cache->save('locales', $arrayLocales);  // cachovani bez expirace
        }
        // nacteni defaultniho locale
        $arrayDefaultLocale = ($defaultLocale ?? array_keys($arrayLocales)[0]);
        parent::__construct($arrayDefaultLocale, $arrayLocales, $aliasLocale);
    }
}
