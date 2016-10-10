<?php

namespace Nester;

use Nester\DI\Container;
use Nester\Http\Response;

class Controller
{
    /**
     * DI container.
     *
     * @var Container
     */
    protected $di;

    /**
     * Web application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * @var ViewRenderer
     */
    private $renderer;

    /**
     * Controller constructor.
     */
    public function __construct(Application $app, Container $di)
    {
        $this->app = $app;
        $this->di = $di;
        $config = $this->app->getConfig();
        if (!array_key_exists('templatePath', $config)) {
            throw new \InvalidArgumentException('templatePath in config must be set');
        }
        $this->renderer = new ViewRenderer($config['templatePath']);
    }

    /**
     * Render view template.
     *
     * @param string $template
     * @param array $data
     * @return Response
     */
    public function render($template, array $data = [])
    {
        $content = $this->renderer->render($template, $data);
        return new Response($content, 200);
    }
}
