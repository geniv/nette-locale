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

        switch ($config['source']) {
            case 'DevNull':
                $locale = $builder->addDefinition($this->prefix('default'))
                    ->setClass(DevNullDriver::class);
                break;

            case 'Database':
                $locale = $builder->addDefinition($this->prefix('default'))
                    ->setClass(DatabaseDriver::class, [$config['parameters']]);
                break;

            case 'Neon':
                $locale = $builder->addDefinition($this->prefix('default'))
                    ->setClass(NeonDriver::class, [$config['parameters']]);
                break;
        }

        // pokud je debugmod a existuje rozhranni tak aktivuje panel
        if ($builder->parameters['debugMode'] && interface_exists(IBarPanel::class)) {
            $builder->addDefinition($this->prefix('panel'))
                ->setClass(Panel::class);

            $locale->addSetup('?->register(?)', [$this->prefix('@panel'), '@self']);
        }
    }


    /**
     * Before Compile.
     */
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();

        $applicationService = $builder->getByType(Application::class) ?: 'application';
        if ($builder->hasDefinition($applicationService)) {
            $builder->getDefinition($applicationService)
                ->addSetup('$service->onRequest[] = ?', [[$this->prefix('@default'), 'onRequest']]);
        }
    }
}
