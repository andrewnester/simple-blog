<?php

namespace Nester\DI;

/**
 * Class Container
 *
 * Basic dependency injection class.
 *
 * @package Nester\DI
 */
class Container
{
    private $dependencies = [];

    /**
     * Container constructor.
     * @param array $dependencies
     */
    public function __construct(array $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    /**
     * Register some service ($source) which will be loaded instead of $destination.
     *
     * @param $destination
     * @param $source
     */
    public function register($destination, $source)
    {
        $this->dependencies[$destination] = $source;
    }

    /**
     * Creates instance of class with all of its dependencies.
     *
     * @param $className
     * @return object
     * @throws \InvalidArgumentException
     */
    public function create($className)
    {
        $reflectionClass = new \ReflectionClass($className);
        $constructor = $reflectionClass->getConstructor();

        // If no overriden constructor, just create instance
        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }
        $parameters = $constructor->getParameters();
        $constructorArgs = [];

        // trying to process all constructor parameters and load proper dependencies.
        foreach ($parameters as $parameter) {
            $parameterClass = $parameter->getClass();
            if ($parameterClass === null) {
                throw new \InvalidArgumentException('Constructor parameters must be valid classes');
            }
            $parameterClassName = $parameterClass->getName();

            // check if we have dependency with this name configured.
            if (array_key_exists($parameterClassName, $this->dependencies)) {
                // if yes, load it based on registered configuration
                if (is_object($this->dependencies[$parameterClassName])) {
                    $constructorArgs[] = $this->dependencies[$parameterClassName];
                } else {
                    $constructorArgs[] = $this->create($this->dependencies[$parameterClassName]);
                }
            } else {
                // otherwise just trying to create it.
                $constructorArgs[] = $this->create($parameterClassName);
            }
        }

        return $reflectionClass->newInstanceArgs($constructorArgs);
    }
}
