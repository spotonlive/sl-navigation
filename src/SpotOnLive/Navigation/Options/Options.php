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
}