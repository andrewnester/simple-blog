<?php

namespace Nester\Http;

/**
 * Class Request
 *
 * Simple class representing HTTP request
 *
 * @package Nester\Http
 */
class Request
{
    /**
     * HTTP Request method (GET, POST, ...)
     *
     * @var string
     */
    private $method;

    /**
     * Request path
     *
     * @var string
     */
    private $path;

    /**
     * Request data
     *
     * @var array
     */
    private $data;

    /**
     * Request constructor.
     * @param string $method
     * @param string $path
     * @param array $data
     */
    public function __construct($method, $path, array $data)
    {
        $this->method = $method;
        $this->path = $path;
        $this->data = $data;
    }

    /**
     * Creates new Http Request class from globals.
     *
     * @return Request
     */
    public static function createFromGlobals()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        return new static($method, $path, $_REQUEST);
    }

    /**
     * Returns request parameter.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    /**
     * Sets request parameter.
     *
     * @param $key string
     * @param $value string
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Returns HTTP method for this request.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns request path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
