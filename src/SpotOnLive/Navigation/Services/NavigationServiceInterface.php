<?php

namespace SpotOnLive\Navigation\Services;

interface NavigationServiceInterface
{
    /**
     * Get container from name
     *
     * @param $name
     * @return \SpotOnLive\Navigation\Navigation\Container
     * @throws \SpotOnLive\Navigation\Navigation\Container\Exception
     */
    public function getContainer($name);
}
