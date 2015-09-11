<?php

namespace SpotOnLive\Navigation\Navigation;

use SpotOnLive\Navigation\Navigation\Page;
use SpotOnLive\Navigation\Options\ContainerOptions;

class Container implements ContainerInterface
{
    /** @var ContainerOptions */
    protected $options;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->options = new ContainerOptions($config);
    }

    public function render()
    {
        $class = $this->options->get('ulClass');

        $html = '<ul class="' . $class . '">';

        foreach ($this->getPages() as $page) {
            $html .= $this->renderPage($page, 0);
        }

        $html .= '</ul>';

        return $html;
    }

    public function renderPage(Page $page, $depth = 0)
    {
        $options = $page->getOptions();
        $class = null;

        $html = '<li class="' . $class . '">';
        $html .= '</li>';

        return $html;
    }

    public function renderPartial()
    {
    }

    /**
     * Get pages
     *
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
}