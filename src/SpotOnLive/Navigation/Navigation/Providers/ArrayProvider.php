<?php

namespace SpotOnLive\Navigation\Navigation\Providers;

use SpotOnLive\Navigation\Options\ContainerOptions;

class ArrayProvider extends Provider implements NavigationProviderInterface
{
    /**
     * @param ContainerOptions $options
     * @return ContainerOptions
     */
    public function resolve(ContainerOptions $options)
    {
        return $options;
    }
}
