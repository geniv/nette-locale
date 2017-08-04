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
 * @author  geniv
 * @package Locale\Bridges\Nette
 */
class Extension extends CompilerExtension
{
    /** @var array default values */
    private $defaults = [
        'debugger'    => true,
        'autowired'   => null,
        'source'      => 'DevNull',
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

        // if define autowired then set value
        if (isset($config['autowired'])) {
            $builder->getDefinition($this->prefix('default'))
                ->setAutowired($config['autowired']);
        }

        // define panel
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

        // linked model to application
        $builder->getDefinition('application.application')
            ->addSetup('$service->onRequest[] = ?', [[$this->prefix('@default'), 'onRequest']]);

        // linked panel to tracy
        if ($config['debugger']) {
            $builder->getDefinition($this->prefix('default'))
                ->addSetup('?->register(?)', [$this->prefix('@panel'), '@self']);
        }
    }
}
