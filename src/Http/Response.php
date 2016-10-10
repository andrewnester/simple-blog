<?php

namespace Nester\Http;

/**
 * Class Response
 *
 * Basic class representing HTTP response.
 *
 * @package Nester\Http
 */
class Response
{
    /**
     * Response content
     *
     * @var string
     */
    private $content;

    /**
     * Http status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * Response constructor.
     * @param string $content
     * @param int $statusCode
     */
    public function __construct($content, $statusCode)
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
    }

    /**
     * Returns HTTP response content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns HTTP status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

}
