<?php declare(strict_types=1);

namespace Locale;


/**
 * Interface ILocale
 *
 * @author  geniv
 * @package Locale
 */
interface ILocale
{

    /**
     * Get list name locales.
     *
     * @return array
     */
    public function getListName();


    /**
     * Get list id locales.
     *
     * @return array
     */
    public function getListId();


    /**
     * Get list locales.
     *
     * @return array
     */
    public function getLocales();


    /**
     * Get current code locale.
     *
     * @param bool $upper
     * @return mixed
     */
    public function getCode($upper = false);


    /**
     * Set current code locale.
     *
     * @param $code
     */
    public function setCode($code);


    /**
     * Get current id locale.
     *
     * @return mixed
     */
    public function getId();


    /**
     * Get default id locale.
     *
     * @return null
     */
    public function getIdDefault();


    /**
     * Get default code locale.
     *
     * @param bool $upper
     * @return string
     */
    public function getCodeDefault($upper = false);


    /**
     * Is default locale?
     *
     * @return bool
     */
    public function isDefaultLocale();


    /**
     * Get plural locale.
     *
     * @return mixed
     */
    public function getPlural();


    /**
     * Get id locale id by code locale.
     *
     * @param $code
     * @return mixed
     */
    public function getIdByCode($code);
}
