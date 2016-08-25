<?php

namespace SpotOnLive\Navigation\Navigation\Providers;

use SpotOnLive\Navigation\Options\ContainerOptions;
use SpotOnLive\Navigation\Options\ProviderOptions;

interface NavigationProviderInterface
{
    /**
     * Resolve options
     *
     * @param ContainerOptions $defaultOptions
     * @return ContainerOptions
     */
    public function resolve(ContainerOptions $defaultOptions);

    /**
     * Set options
     *
     * @param array $options
     * @return ProviderOptions
     */
    public function setOptions(array $options = []);

    /**
     * Get options
     *
     * @return ProviderOptions
     */
    public function getOptions();
}
