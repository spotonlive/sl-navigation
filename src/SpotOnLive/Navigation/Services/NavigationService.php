<?php

namespace SpotOnLive\Navigation\Services;

class NavigationService
{
    /** @var array */
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
