<?php

namespace SpotOnLive\Navigation\Facades\Helpers;

use Illuminate\Support\Facades\Facade;

class NavigationHelperFacade extends Facade
{
    /**
     * Name of the binding container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SpotOnLive\Navigation\Helpers\NavigationHelper';
    }
}
