<?php declare(strict_types=1);

namespace Locale\Bridges\Tracy;

use Latte\Engine;
use Locale\ILocale;
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

    /** @var ILocale */
    private $locale;


    /**
     * Register.
     *
     * @param ILocale $locale
     */
    public function register(ILocale $locale)
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
        return '<span title="Locale">' .
            '<svg height="16" viewBox="0 0 512 512" width="16" xmlns="http://www.w3.org/2000/svg"><path d="M256.1,512c-7.7,0-14.9-3.8-19.2-10L106.3,314.4c-28.2-33.8-43.7-77-43.7-121.8C62.6,86.4,149.4,0,256,0   c106.6,0,193.3,86.4,193.3,192.6c0,32.6-8.4,64.9-24.3,93.5c-0.6,1.5-1.4,2.9-2.3,4.3c-5.2,8.4-10.1,15.4-15.3,21.9L275.4,501.9   C271,508.2,263.8,512,256.1,512z M256,21.1C161,21.1,83.7,98,83.7,192.6c0,40,13.9,78.5,39,108.6c0.2,0.2,0.4,0.5,0.6,0.7   l130.9,188c0.4,0.6,1.2,1,1.9,1c0.8,0,1.5-0.4,2-1l132.3-190c0.1-0.2,0.3-0.4,0.4-0.6c4.8-6,9.3-12.4,14.2-20.3   c0.1-0.2,0.2-0.4,0.3-0.5c0.1-0.1,0.1-0.2,0.2-0.3c0.2-0.6,0.5-1.2,0.8-1.8c14.4-25.6,22-54.5,22-83.8C428.3,98,351,21.1,256,21.1z   " fill="#6A6E7C"/><path d="M252.8,300.6c-59.8,0-108.4-48.5-108.4-108c0-59.6,48.6-108,108.4-108c59.8,0,108.4,48.5,108.4,108   C361.2,252.1,312.6,300.6,252.8,300.6z M252.8,105.7c-48.2,0-87.3,39-87.3,86.9c0,47.9,39.2,86.9,87.3,86.9   c48.2,0,87.3-39,87.3-86.9C340.1,144.7,301,105.7,252.8,105.7z"/></svg>' .
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
