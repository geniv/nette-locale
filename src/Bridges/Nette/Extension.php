<?php declare(strict_types=1);

namespace Locale\Bridges\Nette;

use Locale\Bridges\Tracy\Panel;
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
        'debugger'  => true,
        'autowired' => true,
        'onRequest' => 'application.application',
        'driver'    => null,
    ];


    /**
     * Load configuration.
     */
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $config = $this->validateConfig($this->defaults);

        // define driver
        $default = $builder->addDefinition($this->prefix('default'))
            ->setFactory($config['driver'])
            ->setAutowired($config['autowired']);

        // define panel
        if (isset($config['debugger']) && $config['debugger']) {
            $panel = $builder->addDefinition($this->prefix('panel'))
                ->setFactory(Panel::class);
            $default->addSetup([$panel, 'register']);
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
        $builder->getDefinition($config['onRequest'])
            ->addSetup('$service->onRequest[] = ?', [[$this->prefix('@default'), 'onRequest']]);
    }
}
