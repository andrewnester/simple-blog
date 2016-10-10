<?php

namespace Nester;
use Nester\DI\Container;
use Nester\Http\RedirectResponse;
use Nester\Http\Request;
use Nester\Http\Response;

/**
 * Class Application
 *
 * Basic class representing web application
 *
 * @package Nester
 */
class Application
{
    /**
     * Application configuration
     *
     * @var array
     */
    private $config;

    /**
     * Simple router class.
     *
     * @var Router
     */
    private $router;

    /**
     * DI container.
     *
     * @var Container
     */
    private $di;

    /**
     * Application constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        if (!array_key_exists('routes', $this->config)) {
            throw new \InvalidArgumentException('Routes must be configured');
        }

        $routes = $this->config['routes'];
        $this->router = new Router($routes);

        $services = [];
        if (array_key_exists('services', $this->config)) {
            $services = $this->config['services'];
        }
        $this->di = new Container($services);

        $this->di->register(Application::class, $this);
        $this->di->register(Container::class, $this->di);
    }

    /**
     * Method that runs application.
     * Handles route and runs proper route handler (controller).
     */
    public function run()
    {
        try {
            $request = Request::createFromGlobals();
            $handler = $this->router->match($request);
            list($handlerClass, $handlerMethod) = $handler;

            $handlerObject = $this->di->create($handlerClass);
            $response = $handlerObject->$handlerMethod($request);
        } catch (\Exception $e) {
            $response = new Response($e->getMessage(), 500);
        }

        http_response_code($response->getStatusCode());
        if ($response instanceof RedirectResponse) {
            header('Location: ' . $response->getContent());
            die();
        }
        echo $response->getContent();
    }

    /**
     * Returns application configuration.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
}
