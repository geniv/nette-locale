<?php declare(strict_types=1);

namespace Locale\Drivers;

use Dibi\Connection;
use Exception;
use Locale\Locale;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Throwable;


/**
 * Class DibiDriver
 *
 * Dibi locale driver.
 *
 * @author  geniv
 * @package Locale\Drivers
 */
class DibiDriver extends Locale
{
    // define constant table names
    const
        TABLE = 'locale',
        TABLE_ALIAS = 'locale_alias';


    /**
     * DibiDriver constructor.
     *
     * @param string     $prefix
     * @param Connection $connection
     * @param IStorage   $storage
     * @throws Exception
     * @throws Throwable
     */
    public function __construct(string $prefix, Connection $connection, IStorage $storage)
    {
        $cache = new Cache($storage, 'Locale-Drivers-DibiDriver');

        // define table names
        $tableLocale = $prefix . self::TABLE;
        $tableLocaleAlias = $prefix . self::TABLE_ALIAS;

        // ulozeni locales do cache
        $locales = $cache->load('locales');
        if ($locales === null) {
            // nacteni vsech jazyku do pole
            /** @noinspection PhpUndefinedMethodInspection */
            $locales = $connection->select('id, code, name, plural, main')
                ->from($tableLocale)
                ->where(['active' => true])
                ->orderBy('id')->asc()
                ->fetchAssoc('code');

            $cache->save('locales', $locales);  // cachovani bez expirace
        }

        // ulozeni a nacteni defaultniho locale do cache
        $defaultLocale = $cache->load('defaultLocale');
        if ($defaultLocale === null) {
            // nacteni hlavniho jazyku, pokud neni definovano vezme prvi v rade
            $main = array_keys(array_filter($locales, function ($item) {
                return ($item->main == 1);
            }));
            $defaultLocale = isset($main[0]) ? $main[0] : array_keys($locales)[0];

            $cache->save('defaultLocale', $defaultLocale);  // cachovani bez expirace
        }

        // ulozeni a nacteni locale aliasu do cache
        $aliasLocale = $cache->load('aliasLocale');
        if ($aliasLocale === null) {
            // nacitani aliasu
            $aliasLocale = $connection->select('a.alias, l.code')
                ->from($tableLocaleAlias)->as('a')
                ->join($tableLocale)->as('l')->on('l.id=a.id_locale')
                ->fetchPairs('alias', 'code');

            $cache->save('aliasLocale', $aliasLocale);  // cachovani bez expirace
        }
        parent::__construct($defaultLocale, $locales, $aliasLocale);
    }
}
