<?php

namespace SpotOnLive\Navigation\Helpers;

use SpotOnLive\Navigation\Services\NavigationService;
use SpotOnLive\Navigation\Services\NavigationServiceInterface;

class NavigationHelper
{
    /** @var \SpotOnLive\Navigation\Services\NavigationServiceInterface */
    protected $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        $this->navigationService = $navigationService;
    }

    /**
     * Get container from name
     *
     * @param string $name
     * @return \SpotOnLive\Navigation\Navigation\Container
     */
    public function getContainer($name)
    {
        return $this->navigationService->getContainer($name);
    }
}