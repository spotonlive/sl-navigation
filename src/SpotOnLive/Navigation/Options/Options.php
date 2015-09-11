<?php

namespace SpotOnLive\Navigation\Options;

class Options implements OptionsInterface
{
    /** @var array */
    protected $defaults = [];

    /** @var array */
    protected $options = [];

    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->defaults, $options);
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @param array $defaults
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * Get value from key
     *
     * @param $key
     * @return array|mixed|null|string
     */
    public function get($key)
    {
        if (!array_key_exists($key, $this->options)) {
            return null;
        }

        /** @var string|array|mixed $options */
        $options = $this->options[$key];

        return $options;
    }
}