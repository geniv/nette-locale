<?php declare(strict_types=1);

namespace Locale;

use Locale\Drivers\DevNullDriver;
use Nette\Application\Application;
use Nette\Application\Request;
use Nette\SmartObject;


/**
 * Class Locale
 *
 * @author  geniv
 * @package Locale
 */
abstract class Locale implements ILocale
{
    use SmartObject;

    /** @var array */
    private $locales;
    /** @var array */
    private $aliasLocale;
    /** @var string */
    private $defaultLocale;
    /** @var string */
    private $selectLocale;
    /** @var bool */
    private $ready = false;


    /**
     * Locale constructor.
     *
     * @param string $defaultLocale
     * @param array  $locales
     * @param array  $aliasLocale
     */
    protected function __construct(string $defaultLocale, array $locales, array $aliasLocale = [])
    {
        $this->defaultLocale = $defaultLocale;
        $this->locales = $locales;
        $this->aliasLocale = $aliasLocale;

        // set default locale
        $this->selectLocale = $this->defaultLocale;
    }


    /**
     * On request.
     *
     * @param Application $application
     * @param Request     $request
     * @noinspection PhpUnused
     * @noinspection PhpUnusedParameterInspection
     */
    public function onRequest(Application $application, Request $request)
    {
        $params = $request->getParameters();
        $this->setCode($params['locale'] ?? $this->defaultLocale);
    }


    /**
     * Get list name.
     *
     * @return array
     */
    public function getListName(): array
    {
        if ($this->locales) {
            return array_map(function ($item) {
                return $item['name'];
            }, $this->locales);
        }
        return [];
    }


    /**
     * Get list id.
     *
     * @return array
     */
    public function getListId(): array
    {
        if ($this->locales) {
            return array_map(function ($item) {
                return $item['id'];
            }, $this->locales);
        }
        return [];
    }


    /**
     * Get locales.
     *
     * @return array
     */
    public function getLocales(): array
    {
        return $this->locales;
    }


    /**
     * Internal check current locale with apply alias.
     *
     * @internal
     */
    private function checkLocale()
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
     * Get code.
     *
     * @param bool $upper
     * @return string
     */
    public function getCode(bool $upper = false): string
    {
        $this->checkLocale();
        if (isset($this->locales[$this->selectLocale]['code'])) {
            $code = $this->locales[$this->selectLocale]['code'];
            return ($upper ? strtoupper($code) : $code);
        }
        return '';
    }


    /**
     * Set code.
     *
     * @param string $code
     */
    public function setCode(string $code)
    {
        if ($code) {
            $this->selectLocale = strtolower($code);
            $this->ready = true;    // set ready for use locale
            $this->checkLocale();
        }
//        \Tracy\Debugger::fireLog('setCode: ' . $code);
    }


    /**
     * @return mixed
     */
    public function isReady(): bool
    {
        // in case this instance is DevNullDriver then ignore standard ready
        return ($this instanceof DevNullDriver) ?: $this->ready;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
//        \Tracy\Debugger::fireLog('getId: ' . $this->selectLocale);
        return ($this->locales[$this->selectLocale]['id'] ?? 0);
    }


    /**
     * Get id default.
     *
     * @return int
     */
    public function getIdDefault(): int
    {
        return ($this->locales[$this->defaultLocale]['id'] ?? 0);
    }


    /**
     * Get code default.
     *
     * @param bool $upper
     * @return string
     */
    public function getCodeDefault(bool $upper = false): string
    {
        return ($upper ? strtoupper($this->defaultLocale) : $this->defaultLocale);
    }


    /**
     * Is default locale.
     *
     * @return bool
     */
    public function isDefaultLocale(): bool
    {
        return $this->getIdDefault() == $this->getId();
    }


    /**
     * Get plural.
     *
     * @return string
     */
    public function getPlural(): string
    {
        return ($this->locales[$this->selectLocale]['plural'] ?? '');
    }


    /**
     * Get id by code.
     *
     * @param string $code
     * @return int
     */
    public function getIdByCode(string $code): int
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
        return ($this->locales[$this->defaultLocale]['id'] ?? 0);
    }
}
