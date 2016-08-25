<?php

namespace SpotOnLive\Navigation\Navigation\Providers;

use SpotOnLive\Navigation\Exceptions\IllegalConfigurationException;
use SpotOnLive\Navigation\Options\ContainerOptions;

class JsonProvider extends Provider implements NavigationProviderInterface
{
    /**
     * Resolve json navigation
     *
     * @param ContainerOptions $initialOptions
     * @return ContainerOptions
     * @throws IllegalConfigurationException
     */
    public function resolve(ContainerOptions $initialOptions)
    {
        $providerOptions = $this->getOptions();

        if (!$path = $providerOptions->get('path')) {
            throw new IllegalConfigurationException('Missing path to the json file');
        }

        if (!file_exists($path)) {
            throw new IllegalConfigurationException('Invalid path - file not found');
        }

        $options = $this->loadJsonFromPath($path);

        return new ContainerOptions($options);
    }

    /**
     * Load json from path
     *
     * @param string $path
     * @return array
     * @throws IllegalConfigurationException
     */
    protected function loadJsonFromPath($path)
    {
        if (!$json = file_get_contents($path)) {
            throw new IllegalConfigurationException(
                sprintf(
                    'Not able to get data from %s',
                    $path
                )
            );
        }

        /** @var array $assoc */
        $assoc = json_decode($json, true);

        return $assoc;
    }
}
