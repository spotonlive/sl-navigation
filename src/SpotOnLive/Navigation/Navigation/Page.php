<?php

namespace SpotOnLive\Navigation\Navigation;

use Route;
use SpotOnLive\Navigation\Exceptions\NoRouteException;
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
        $options = $this->options->get('options');

        /** @var string $label */
        $label = $options['label'];

        if ($options['escape_html']) {
            $label = htmlspecialchars($label);
        }

        return $label;
    }

    /**
     * Get url
     *
     * @return string
     * @throws NoRouteException
     */
    public function getUrl()
    {
        $options = $this->options->get('options');

        if (!isset($options['route']) && !isset($options['url'])) {
            throw new NoRouteException('Please provide a route or url');
        }

        if (isset($options['route'])) {
            return route($options['route']);
        }

        return $options['url'];
    }

    public function isActive()
    {
        $options = $this->options->get('options');

        /** @var \Illuminate\Routing\Route $currentRoute */
        $currentRoute = Route::current();

        if (isset($options['route'])) {
            if ($currentRoute->getName() == $options['route']) {
                return true;
            }

            return false;
        }

        if ($currentRoute->getUri() == $options['url']) {
            return true;
        }

        // Check for active sub page
        if ($this->activeSubPage($this->getPages())) {
            return true;
        }

        return false;
    }

    /**
     * Check for active sub pages
     *
     * @param array|Page[] $pages
     * @return bool
     */
    public function activeSubPage(array $pages)
    {
        /** @var Page $page */
        foreach ($pages as $page) {
            if ($page->isActive() || $this->activeSubPage($page->getPages())) {
                return true;
            }
        }

        return false;
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
            $pages[] = new Page($page);
        }

        return $pages;
    }

    /**
     * Get attributes as string
     *
     * @param string $type
     * @return null|string
     */
    public function getAttributes($type = "li")
    {
        $attributes = $this->options->get($type . 'Attributes');

        if (is_null($attributes)) {
            $attributes = [];
        }

        $attributesString = [];

        foreach ($attributes as $attr => $val) {
            $val = htmlspecialchars($val);
            $attributesString[] = sprintf('%s="%s"', $attr, $val);
        }

        $attributes = implode(" ", $attributesString);

        if (!$attributes) {
            return null;
        }

        return " " . $attributes;
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
