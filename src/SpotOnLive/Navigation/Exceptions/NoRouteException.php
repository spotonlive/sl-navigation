<?php

namespace SpotOnLive\Navigation\Exceptions;

use Exception;

class NoRouteException extends Exception
{
    public function __construct()
    {
        return parent::__construct('Please provide a route or url');
    }
}
