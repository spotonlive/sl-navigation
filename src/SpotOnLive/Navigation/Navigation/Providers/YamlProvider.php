<?php

namespace SpotOnLive\Navigation\Navigation\Providers;

use Symfony\Component\Yaml\Yaml;
use SpotOnLive\Navigation\Options\ContainerOptions;
use SpotOnLive\Navigation\Exceptions\IllegalConfigurationException;

class YamlProvider extends Provider implements NavigationProviderInterface
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
            throw new IllegalConfigurationException('Missing path to the yaml file');
        }

        if (!file_exists($path)) {
            throw new IllegalConfigurationException('Invalid path - file not found');
        }

        $options = $this->loadYamlFromPath($path);

        return new ContainerOptions($options);
    }

    /**
     * Load yaml from path
     *
     * @param string $path
     * @return array
     * @throws IllegalConfigurationException
     */
    protected function loadYamlFromPath($path)
    {
        if (!$assoc = Yaml::parse($path)) {
            throw new IllegalConfigurationException(
                sprintf(
                    'Not able to get data from %s',
                    $path
                )
            );
        }

        return $assoc;
    }
}
