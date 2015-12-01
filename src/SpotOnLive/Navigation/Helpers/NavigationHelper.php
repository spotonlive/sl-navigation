<?php

namespace SpotOnLive\Navigation\Helpers;

use SpotOnLive\Navigation\Services\NavigationService;
use SpotOnLive\Navigation\Services\NavigationServiceInterface;

class NavigationHelper
{
    /** @var NavigationService */
    protected $navigationService;

    public function __construct(NavigationServiceInterface $navigationService)
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
