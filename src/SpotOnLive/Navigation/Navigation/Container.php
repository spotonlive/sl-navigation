<?php

namespace SpotOnLive\Navigation\Navigation;

use SpotOnLive\Navigation\Options\ContainerOptions;

class Container implements ContainerInterface
{
    /** @var ContainerOptions */
    protected $options;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->options = new ContainerOptions($config);
    }

    public function render()
    {

    }
}