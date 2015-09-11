<?php

namespace SpotOnLive\Navigation\Navigation;

use SpotOnLive\Navigation\Options\PageOptions;

class Page implements PageInterface
{
    /** @var PageOptions */
    protected $options;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->options = new PageOptions($config);
    }

    /**
     * Get label text
     *
     * @return string
     */
    public function getLabel()
    {
        $options = $this->options;

        /** @var string $label */
        $label = $options->get('label');

        if ($options->get('escape_html')) {
            $label = htmlspecialchars($label);
        }

        return $label;
    }

    public function isActive()
    {

    }

    /**
     * @return array|Page[]
     */
    public function getPages()
    {
        $pagesArray = $this->options->get('pages');

        if (is_null($pagesArray)) {
            $pagesArray = [];
        }

        $pages = [];

        foreach ($pagesArray as $page) {
            $pages = new Page($page);
        }

        return $pages;
    }

    /**
     * @return PageOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param PageOptions $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}