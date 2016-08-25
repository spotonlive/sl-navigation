<?php

namespace SpotOnLive\Navigation\Navigation\Providers;

use SpotOnLive\Navigation\Options\ProviderOptions;

abstract class Provider implements NavigationProviderInterface
{
    /** @var ProviderOptions */
    protected $options;

    /**
     * @return ProviderOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options = [])
    {
        $this->options = new ProviderOptions($options);

        return $this;
    }
}
