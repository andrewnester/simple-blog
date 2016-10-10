<?php

namespace Nester\Http;

/**
 * Class RedirectResponse
 *
 * Represents HTTP Redirect
 *
 * @package Nester\Http
 */
class RedirectResponse extends Response
{
    public function __construct($location)
    {
        parent::__construct($location, 302);
    }
}
