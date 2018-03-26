<?php declare(strict_types=1);

namespace Locale\Drivers;

use Locale\Locale;


/**
 * Class DevNullDriver
 *
 * Disable locale driver.
 *
 * @author  geniv
 * @package Locale\Drivers
 */
class DevNullDriver extends Locale
{

    /**
     * DevNullDriver constructor.
     *
     * @param int $defaultIdLocale
     */
    public function __construct(int $defaultIdLocale = 1)
    {
        $defaultLocale = '';
        $arrayLocales = [
            $defaultLocale => [
                'id'     => $defaultIdLocale,  // always define any integer ID!
                'name'   => null,
                'code'   => null,
                'plural' => null,
            ],
        ];
        parent::__construct($defaultLocale, $arrayLocales);
    }
}
