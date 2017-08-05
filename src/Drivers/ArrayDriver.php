<?php

namespace Locale\Drivers;

use Exception;
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
     * @param array    $parameters
     * @param IStorage $storage
     * @throws Exception
     */
    public function __construct(array $parameters, IStorage $storage)
    {
        $cache = new Cache($storage, 'cache-LocaleDrivers-ArrayDriver');

        if (!isset($parameters['locales'])) {
            throw new Exception('Locales is not defined in configure! (locales: [xy => XY])');
        }

        if (!isset($parameters['default'])) {
            throw new Exception('Default locales is not defined in configure! (default: xy)');
        }

        // ulozeni locales do cache
        $locales = $cache->load('locales');
        if ($locales === null) {
            $poc = 1;   // pocatecni simulace id jazyka
            $locales = array_map(function ($row) use ($parameters, &$poc) {
                // nacitani kodu jazyka
                $code = array_flip($parameters['locales'])[$row];
                // skladani pole jazyka
                return [
                    'id'     => $poc++,
                    'name'   => $row,
                    'code'   => $code,
                    'plural' => isset($parameters['plurals']) && isset($parameters['plurals'][$code]) ? $parameters['plurals'][$code] : null,
                ];
            }, $parameters['locales']);

            $cache->save('locales', $locales);  // cachovani bez expirace
        }

        // nacteni defaultniho locale
        $defaultLocale = isset($parameters['default']) ? $parameters['default'] : array_keys($locales)[0];

        // nacteni locale aliasu
        $localeAlias = null;
        if (isset($parameters['alias'])) {
            $localeAlias = $parameters['alias'];
        }
        parent::__construct($defaultLocale, $locales, $localeAlias);
    }
}
