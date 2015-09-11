<?php

namespace SpotOnLive\Navigation\Helpers;

use SpotOnLive\Navigation\Services\NavigationServiceInterface;

class NavigationHelper
{
    /** @var \SpotOnLive\Navigation\Services\NavigationServiceInterface */
    protected $navigationService;

    public function __construct(NavigationServiceInterface $navigationService)
    {
        $this->navigationService = $navigationService;
    }
}