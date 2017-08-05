<?php

namespace Locale\Drivers;

use Locale\Locale;
use Dibi\Connection;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;


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
        TABLE_NAME = 'locale',
        TABLE_NAME_ALIAS = 'locale_alias';


    /**
     * DibiDriver constructor.
     *
     * @param array      $parameters
     * @param Connection $connection
     * @param IStorage   $storage
     */
    public function __construct(array $parameters, Connection $connection, IStorage $storage)
    {
        $cache = new Cache($storage, 'cache-LocaleDrivers-DibiDriver');

        // define table names
        $tableLocale = $parameters['tablePrefix'] . self::TABLE_NAME;
        $tableLocaleAlias = $parameters['tablePrefix'] . self::TABLE_NAME_ALIAS;

        // ulozeni locales do cache
        $locales = $cache->load('locales');
        if ($locales === null) {
            // nacteni vsech jazyku do pole
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
        $localeAlias = $cache->load('localeAlias');
        if ($localeAlias === null) {
            // nacitani aliasu
            $localeAlias = $connection->select('a.alias, l.code')
                ->from($tableLocaleAlias)->as('a')
                ->join($tableLocale)->as('l')->on('l.id=a.id_locale')
                ->fetchPairs('alias', 'code');

            $cache->save('localeAlias', $localeAlias);  // cachovani bez expirace
        }
        parent::__construct($defaultLocale, $locales, $localeAlias);
    }
}
