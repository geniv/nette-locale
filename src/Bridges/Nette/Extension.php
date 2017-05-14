<?php

namespace Locale\Bridges\Nette;

use Nette;
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

    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->getConfig();

        switch ($config['source']) {
            case 'DevNull':
                $locale = $builder->addDefinition($this->prefix('default'))
                    ->setClass('Locale\Drivers\DevNullDriver')
                    ->setInject(false);
                break;

            case 'Database':
                $locale = $builder->addDefinition($this->prefix('default'))
                    ->setClass('Locale\Drivers\DatabaseDriver', [$config['parameters']])
                    ->setInject(false);
                break;

            case 'Neon':
                $locale = $builder->addDefinition($this->prefix('default'))
                    ->setClass('Locale\Drivers\NeonDriver', [$config['parameters']])
                    ->setInject(false);
                break;
        }

        // pokud je debugmod a existuje rozhranni tak aktivuje panel
        if ($builder->parameters['debugMode'] && interface_exists('Tracy\IBarPanel')) {
            $builder->addDefinition($this->prefix('panel'))
                ->setClass('Locale\Bridges\Tracy\Panel');

            $locale->addSetup('?->register(?)', [$this->prefix('@panel'), '@self']);
        }
    }


    /**
     * Before Compile.
     */
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();

        $applicationService = $builder->getByType('Nette\Application\Application') ?: 'application';
        if ($builder->hasDefinition($applicationService)) {
            $builder->getDefinition($applicationService)
                ->addSetup('$service->onRequest[] = ?', [[$this->prefix('@default'), 'onRequest']]);
        }
    }
}
