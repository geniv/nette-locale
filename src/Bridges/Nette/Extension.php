<?php

namespace Locale\Bridges\Nette;

use Locale\Bridges\Tracy\Panel;
use Locale\Drivers\DibiDriver;
use Locale\Drivers\DevNullDriver;
use Locale\Drivers\ArrayDriver;
use Nette\DI\CompilerExtension;


/**
 * Class Extension
 *
 * @author  geniv
 * @package Locale\Bridges\Nette
 */
class Extension extends CompilerExtension
{
    /** @var array default values */
    private $defaults = [
        'debugger'    => true,
        'autowired'   => null,
        'onRequest'   => 'application.application',
        'source'      => 'DevNull', // DevNull|Dibi|Array
        'tablePrefix' => null,
        'default'     => null,
        'locales'     => [],
        'plurals'     => [],
        'alias'       => [],
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        // define driver
        switch ($config['source']) {
            case 'DevNull':
                $builder->addDefinition($this->prefix('default'))
                    ->setFactory(DevNullDriver::class);
                break;

            case 'Dibi':
                $builder->addDefinition($this->prefix('default'))
                    ->setFactory(DibiDriver::class, [$config]);
                break;

            case 'Array':
                $builder->addDefinition($this->prefix('default'))
                    ->setFactory(ArrayDriver::class, [$config]);
                break;
        }

        // if define autowired then set value
        if (isset($config['autowired'])) {
            $builder->getDefinition($this->prefix('default'))
                ->setAutowired($config['autowired']);
        }

        // define panel
        if (isset($config['debugger']) && $config['debugger']) {
            $builder->addDefinition($this->prefix('panel'))
                ->setFactory(Panel::class);
        }
    }


    /**
     * Before Compile.
     */
    public function beforeCompile()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        // linked onRequest
        if (isset($config['onRequest'])) {
            $builder->getDefinition($config['onRequest'])
                ->addSetup('$service->onRequest[] = ?', [[$this->prefix('@default'), 'onRequest']]);
        }

        // linked panel to tracy
        if (isset($config['debugger']) && $config['debugger']) {
            $builder->getDefinition($this->prefix('default'))
                ->addSetup('?->register(?)', [$this->prefix('@panel'), '@self']);
        }
    }
}
