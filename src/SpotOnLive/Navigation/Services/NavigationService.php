<?php

namespace SpotOnLive\Navigation\Services;

use SpotOnLive\Navigation\Exceptions\ContainerException;
use SpotOnLive\Navigation\Navigation\Container;

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

    public function render($name)
    {
        $container = $this->getContainer($name);
        return $container->render();
    }

    /**
     * Get container from name
     *
     * @param $name
     * @return array
     * @throws ContainerException
     */
    public function getContainer($name)
    {
        foreach ($this->config['containers'] as $containerName => $container) {
            if ($name == $containerName) {
                return new Container($container);
            }
        }

        throw new ContainerException('The container \'%s\' does not exist');
    }
}
