<?php

namespace LocaleServices;

use Nette\Application\Application;
use Nette\Application\Request;
use Nette\SmartObject;


/**
 * Class LanguageService
 *
 * @author  geniv
 * @package LanguageServices
 */
class LocaleService
{
    use SmartObject;

    /** @var array pole jazyku */
    private $locales;
    /** @var array jazykove aliasy */
    private $aliasLocale;
    /** @var string vychozi jazyk */
    private $defaultLocale;
    /** @var string vybrany jazyk */
    private $selectLocale;


    /**
     * LocaleService constructor.
     *
     * @param      $defaultLocale
     * @param      $locales
     * @param null $localeAlias
     */
    protected function __construct($defaultLocale, $locales, $localeAlias = null)
    {
        $this->defaultLocale = $defaultLocale;
        $this->locales = $locales;
        $this->aliasLocale = $localeAlias;

        // implicitni nastaveni vyraneho jakyka
        $this->selectLocale = $this->defaultLocale;
    }


    /**
     * Get current locale from HttpRequest.
     *
     * @param Application $sender
     * @param Request     $request
     */
    public function onRequest(Application $sender, Request $request)
    {
        $params = $request->getParameters();
        $this->setCode($params['locale']);
    }


    /**
     * Get list name locales.
     *
     * @return array
     */
    public function getListName()
    {
        if ($this->locales) {
            return array_map(function ($item) {
                return $item['name'];
            }, $this->locales);
        }
        return [];
    }


    /**
     * Get list id locales.
     *
     * @return array
     */
    public function getListId()
    {
        if ($this->locales) {
            return array_map(function ($item) {
                return $item['id'];
            }, $this->locales);
        }
        return [];
    }


    /**
     * Get list locales.
     *
     * @return array
     */
    public function getLocales()
    {
        return $this->locales;
    }


    /**
     * Internal check curent locale with apply alias.
     */
    private function checkLanguage()
    {
        if (!isset($this->locales[$this->selectLocale])) {
            // pokud neexistuje jazky hleda v aliasech
            if (isset($this->aliasLocale[$this->selectLocale])) {
                $this->selectLocale = $this->aliasLocale[$this->selectLocale];
            } else {
                $this->selectLocale = $this->defaultLocale;
            }
        }
    }


    /**
     * Get current code locale.
     *
     * @param bool $upper
     * @return mixed
     */
    public function getCode($upper = false)
    {
        $this->checkLanguage();
        $code = $this->locales[$this->selectLocale]['code'];
        return ($upper ? strtoupper($code) : $code);
    }


    /**
     * Set current code locale.
     *
     * @param $code
     */
    public function setCode($code)
    {
        if ($code) {
            $this->selectLocale = strtolower($code);
            $this->checkLanguage();
        }
    }


    /**
     * Get current id locale.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->locales[$this->selectLocale]['id'];
    }


    /**
     * Get default id locale.
     *
     * @return null
     */
    public function getIdDefault()
    {
        return $this->locales[$this->defaultLocale]['id'];
    }


    /**
     * Get default code locale.
     *
     * @param bool $upper
     * @return string
     */
    public function getCodeDefault($upper = false)
    {
        return ($upper ? strtoupper($this->defaultLocale) : $this->defaultLocale);
    }


    /**
     * Is default locale?
     *
     * @return bool
     */
    public function isDefaultLocale()
    {
        return $this->getIdDefault() == $this->getId();
    }


    /**
     * Get prulral locale.
     *
     * @return mixed
     */
    public function getPlural()
    {
        return $this->locales[$this->selectLocale]['plural'];
    }


    /**
     * Get id locale id by code locale.
     *
     * @param $code
     * @return mixed
     */
    public function getIdByCode($code)
    {
        // pokud existuje kod v
        if (isset($this->locales[$code]['id'])) {
            return $this->locales[$code]['id'];
        }
        // pokud existuje kod v aliasu
        if (isset($this->aliasLocale[$code])) {
            $this->locales[$this->aliasLocale[$code]]['id'];
        }
        // jinak pouzije defaultni jazyk
        return $this->locales[$this->defaultLocale]['id'];
    }
}
