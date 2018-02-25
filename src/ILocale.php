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
     * Get list name.
     *
     * @return array
     */
    public function getListName(): array;


    /**
     * Get list id.
     *
     * @return array
     */
    public function getListId(): array;


    /**
     * Get locales.
     *
     * @return array
     */
    public function getLocales(): array;


    /**
     * Get code.
     *
     * @param bool $upper
     * @return string
     */
    public function getCode(bool $upper = false): string;


    /**
     * Set code.
     *
     * @param string $code
     * @return mixed
     */
    public function setCode(string $code);


    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int;


    /**
     * Get id default.
     *
     * @return string
     */
    public function getIdDefault(): string;


    /**
     * Get code default.
     *
     * @param bool $upper
     * @return string
     */
    public function getCodeDefault(bool $upper = false): string;


    /**
     * Is default locale.
     *
     * @return bool
     */
    public function isDefaultLocale(): bool;


    /**
     * Get plural.
     *
     * @return string
     */
    public function getPlural(): string;


    /**
     * Get id by code.
     *
     * @param string $code
     * @return int
     */
    public function getIdByCode(string $code): int;
}
