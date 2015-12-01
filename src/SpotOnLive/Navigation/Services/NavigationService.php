<?php

namespace SpotOnLive\Navigation\Services;

use SpotOnLive\Navigation\Exceptions\ContainerException;
use SpotOnLive\Navigation\Navigation\Container;

class NavigationService implements NavigationServiceInterface
{
    /** @var array */
    protected $config;

    /** @var string */
    protected $assertionClass = 'SpotOnLive\Assertions\Services\AssertionService';

    /** @var null */
    protected $assertionService = null;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Render navigation
     *
     * @param string $name
     * @return string
     * @throws ContainerException
     */
    public function render($name)
    {
        $container = $this->getContainer($name);
        return $container->render();
    }

    /**
     * Get container from name
     *
     * @param $name
     * @return Container
     * @throws ContainerException
     */
    public function getContainer($name)
    {
        foreach ($this->config['containers'] as $containerName => $container) {
            if ($name == $containerName) {
                return new Container($container, $this->getAssertionService());
            }
        }

        throw new ContainerException(
            sprintf(
                'The container \'%s\' does not exist',
                $name
            )
        );
    }

    /**
     * @return string
     */
    public function getAssertionClass()
    {
        return $this->assertionClass;
    }

    /**
     * @param string $assertionClass
     */
    public function setAssertionClass($assertionClass)
    {
        $this->assertionClass = $assertionClass;
    }

    /**
     * Get assertion service
     *
     * @return null
     */
    protected function getAssertionService()
    {
        if (!$this->assertionService) {
            if (class_exists($this->assertionClass)) {
                $this->assertionService = app($this->assertionClass);
            }
        }

        return $this->assertionService;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}
