<?php

namespace Locale\Bridges\Nette;

use Exception;
use Locale\Bridges\Tracy\Panel;
use Locale\Drivers\DatabaseDriver;
use Locale\Drivers\DevNullDriver;
use Locale\Drivers\NeonDriver;
use Nette\Application\Application;
use Nette\DI\CompilerExtension;
use Tracy\IBarPanel;


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

    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->getConfig();

        if (!isset($config['parameters'])) {
            throw new Exception('Parameters is not defined! (' . $this->name . ':{parameters: {...}})');
        }

        // definice driveru
        switch ($config['source']) {
            case 'DevNull':
                $builder->addDefinition($this->prefix('default'))
                    ->setClass(DevNullDriver::class);
                break;

            case 'Database':
                $builder->addDefinition($this->prefix('default'))
                    ->setClass(DatabaseDriver::class, [$config['parameters']]);
                break;

            case 'Neon':
                $builder->addDefinition($this->prefix('default'))
                    ->setClass(NeonDriver::class, [$config['parameters']]);
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

        // pripojeni modelu do application
        $builder->getDefinition('application.application')
            ->addSetup('$service->onRequest[] = ?', [[$this->prefix('@default'), 'onRequest']]);

        // pripojeni panelu do tracy
        $builder->getDefinition($this->prefix('default'))
            ->addSetup('?->register(?)', [$this->prefix('@panel'), '@self']);
    }
}
