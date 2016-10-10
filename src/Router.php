<?php

namespace Nester;

use Nester\Http\Request;

/**
 * Class Router
 *
 * Simple router class.
 *
 * @package Nester
 */
class Router
{
    /**
     * Array of routes.
     *
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Find proper router and returns handler for it.
     *
     * @param Request $request
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return Callable
     */
    public function match(Request $request)
    {
        $method = $request->getMethod();
        $path = $request->getPath();

        foreach ($this->routes as $route) {
            if (count($route) !== 3) {
                throw new \InvalidArgumentException('Route should be defined like ["Method", "Path", "Handler"]');
            }

            $pathRoute = $route[1];
            // trying to find all named parameters
            preg_match_all('/<([a-zA-Z]+)>/', $pathRoute, $vars);
            $parameters = [];
            if (count($vars) === 2) {
                list($placeholders, $parameters) = $vars;
                // replace named parameters with regexp value to match route.
                $pathRoute = str_replace($placeholders, '([a-zA-Z0-9]+)', $pathRoute);
            }

            // trying to match route to route regexp
            if ($method === $route[0] && preg_match_all('#^'.addslashes($pathRoute).'$#', $path, $matches) === 1) {
                $parametersCount = count($parameters);
                // if we have some named parameters, add them to request.
                if ($parametersCount !== 0) {
                    for ($i = 0; $i < $parametersCount; $i++) {
                        $request->set($parameters[$i], $matches[$i+1][0]);
                    }
                }
                return $route[2];
            }
        }

        throw new \RuntimeException('No route found for ' . $path . ' with method ' . $method);
    }
}
