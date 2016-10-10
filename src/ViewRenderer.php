<?php

namespace Nester;

/**
 * Class ViewRenderer
 *
 * Simple class to render templates
 *
 * @package Nester
 */
class ViewRenderer
{
    /**
     * Path to templates.
     *
     * @var string
     */
    private $templatePath;

    /**
     * ViewRenderer constructor.
     * @param string $templatePath
     */
    public function __construct($templatePath)
    {
        $this->templatePath = $templatePath;
    }


    /**
     * Renders template
     *
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render($template, $data = [])
    {
        extract($data);
        ob_start();
        include $this->templatePath . '/' . $template;
        return ob_get_clean();
    }
}
