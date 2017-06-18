<?php

namespace Locale\Bridges\Tracy;

use Latte\Engine;
use Locale\Locale;
use Nette\DI\Container;
use Nette\SmartObject;
use Tracy\Debugger;
use Tracy\IBarPanel;


/**
 * Class Panel
 *
 * @author  geniv
 * @package Locale\Bridges\Tracy
 */
class Panel implements IBarPanel
{
    use SmartObject;

    /** @var Locale locale from DI */
    private $locale;
    /** @var Container container from DI */
    private $container;


    /**
     * Panel constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * Register to Tracy.
     *
     * @param Locale $locale
     */
    public function register(Locale $locale)
    {
        $this->locale = $locale;
        Debugger::getBar()->addPanel($this);
    }


    /**
     * Renders HTML code for custom tab.
     *
     * @return string
     */
    public function getTab()
    {
        return '<span title="Locale"><img width="16px" height="16px" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDUxMiA1MTIiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48Zz48cGF0aCBkPSJNMjU2LjEsNTEyYy03LjcsMC0xNC45LTMuOC0xOS4yLTEwTDEwNi4zLDMxNC40Yy0yOC4yLTMzLjgtNDMuNy03Ny00My43LTEyMS44QzYyLjYsODYuNCwxNDkuNCwwLDI1NiwwICAgYzEwNi42LDAsMTkzLjMsODYuNCwxOTMuMywxOTIuNmMwLDMyLjYtOC40LDY0LjktMjQuMyw5My41Yy0wLjYsMS41LTEuNCwyLjktMi4zLDQuM2MtNS4yLDguNC0xMC4xLDE1LjQtMTUuMywyMS45TDI3NS40LDUwMS45ICAgQzI3MSw1MDguMiwyNjMuOCw1MTIsMjU2LjEsNTEyeiBNMjU2LDIxLjFDMTYxLDIxLjEsODMuNyw5OCw4My43LDE5Mi42YzAsNDAsMTMuOSw3OC41LDM5LDEwOC42YzAuMiwwLjIsMC40LDAuNSwwLjYsMC43ICAgbDEzMC45LDE4OGMwLjQsMC42LDEuMiwxLDEuOSwxYzAuOCwwLDEuNS0wLjQsMi0xbDEzMi4zLTE5MGMwLjEtMC4yLDAuMy0wLjQsMC40LTAuNmM0LjgtNiw5LjMtMTIuNCwxNC4yLTIwLjMgICBjMC4xLTAuMiwwLjItMC40LDAuMy0wLjVjMC4xLTAuMSwwLjEtMC4yLDAuMi0wLjNjMC4yLTAuNiwwLjUtMS4yLDAuOC0xLjhjMTQuNC0yNS42LDIyLTU0LjUsMjItODMuOEM0MjguMyw5OCwzNTEsMjEuMSwyNTYsMjEuMXogICAiIGZpbGw9IiM2QTZFN0MiLz48cGF0aCBkPSJNMjUyLjgsMzAwLjZjLTU5LjgsMC0xMDguNC00OC41LTEwOC40LTEwOGMwLTU5LjYsNDguNi0xMDgsMTA4LjQtMTA4YzU5LjgsMCwxMDguNCw0OC41LDEwOC40LDEwOCAgIEMzNjEuMiwyNTIuMSwzMTIuNiwzMDAuNiwyNTIuOCwzMDAuNnogTTI1Mi44LDEwNS43Yy00OC4yLDAtODcuMywzOS04Ny4zLDg2LjljMCw0Ny45LDM5LjIsODYuOSw4Ny4zLDg2LjkgICBjNDguMiwwLDg3LjMtMzksODcuMy04Ni45QzM0MC4xLDE0NC43LDMwMSwxMDUuNywyNTIuOCwxMDUuN3oiIGZpbGw9IiM2QTZFN0MiLz48L2c+PC9zdmc+" />' .
            'Locale - <strong>' . ($this->locale->getCode() ?: 'NULL') . '</strong>' .
            '</span>';
    }


    /**
     * Renders HTML code for custom panel.
     *
     * @return string
     */
    public function getPanel()
    {
        $params = [
            'locales'         => $this->locale->getLocales(),
            'localeClass'     => get_class($this->locale),
            'localeIdDefault' => $this->locale->getIdDefault(),
            'localeId'        => $this->locale->getId(),
        ];

        $latte = new Engine;
        return $latte->renderToString(__DIR__ . '/PanelTemplate.latte', $params);
    }
}
