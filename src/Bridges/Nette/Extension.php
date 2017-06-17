<?php

namespace Locale\Bridges\Nette;

use Locale\Bridges\Tracy\Panel;
use Locale\Drivers\DatabaseDriver;
use Locale\Drivers\DevNullDriver;
use Locale\Drivers\NeonDriver;
use Nette\DI\CompilerExtension;


/**
 * Class Extension
 *
 * nette extension pro zavadeni jazykove sluzby jako rozsireni
 *
 * @author  geniv
 * @package Locale\Bridges\Nette
 */
class Extension extends CompilerExtension
{
    /** @var array vychozi hodnoty */
    private $defaults = [
        'debugger' => true,
        'source'   => 'DevNull',
        'table'    => null,
        'default'  => null,
        'locales'  => [],
        'plurals'  => [],
        'alias'    => [],
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        // definice driveru
        switch ($config['source']) {
            case 'DevNull':
                $builder->addDefinition($this->prefix('default'))
                    ->setClass(DevNullDriver::class);
                break;

            case 'Database':
                $builder->addDefinition($this->prefix('default'))
                    ->setClass(DatabaseDriver::class, [$config]);
                break;

            case 'Neon':
                $builder->addDefinition($this->prefix('default'))
                    ->setClass(NeonDriver::class, [$config]);
                break;
        }

        // definice panelu
        $builder->addDefinition($this->prefix('panel'))
            ->setClass(Panel::class);
    }


    /**
     * Before Compile.
     */
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        // pripojeni modelu do application
        $builder->getDefinition('application.application')
            ->addSetup('$service->onRequest[] = ?', [[$this->prefix('@default'), 'onRequest']]);

        // pripojeni panelu do tracy
        if ($config['debugger']) {
            $builder->getDefinition($this->prefix('default'))
                ->addSetup('?->register(?)', [$this->prefix('@panel'), '@self']);
        }
    }
}
