<?php

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
     */
    public function __construct()
    {
    }
}
