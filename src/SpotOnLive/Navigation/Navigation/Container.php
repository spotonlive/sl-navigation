<?php

namespace SpotOnLive\Navigation\Navigation;

use Auth;
use SpotOnLive\Navigation\Exceptions\IllegalConfigurationException;
use SpotOnLive\Navigation\Options\ContainerOptions;

class Container implements ContainerInterface
{
    /** @var ContainerOptions */
    protected $options;

    /** @var null */
    protected $assertionService;

    /**
     * @param array $config
     * @param null $assertionService
     */
    public function __construct(array $config = [], $assertionService = null)
    {
        $this->options = new ContainerOptions($config);
        $this->assertionService = $assertionService;
    }

    /**
     * Render navigation in partial
     *
     * @param string $partial
     * @return string
     */
    public function renderPartial($partial)
    {
        $html = view($partial, [
            'container' => $this,
        ]);

        return (string) $html;
    }

    /**
     * Render navigation
     *
     * @param null|integer $maxDepth
     * @return string
     */
    public function render($maxDepth = null)
    {
        $options = $this->getOptions()->get('options');
        $class = $options['ulClass'];

        $html = "<ul class=\"" . $class . "\"" . $this->getAttributes() . ">\n";

        foreach ($this->getPages() as $page) {
            $html .= $this->renderPage($page, $maxDepth);
        }

        $html .= '</ul>';

        return $html;
    }

    /**
     * Check for a valid assertion service
     *
     * @throws IllegalConfigurationException
     */
    protected function validateAssertionService()
    {
        if (!$this->assertionService) {
            throw new IllegalConfigurationException(
                _('Please require spotonlive/assertions` to use assertions in your navigation')
            );
        }
    }

    /**
     * Render page
     *
     * @param \SpotOnLive\Navigation\Navigation\Page $page
     * @param null $maxDepth
     * @param int $depth
     * @return null|string
     * @throws \SpotOnLive\Navigation\Exceptions\NoRouteException
     */
    public function renderPage(Page $page, $maxDepth = null, $depth = 0)
    {
        // Check for depth
        if (!is_null($maxDepth) && $depth > $maxDepth) {
            return null;
        }

        $options = $page->getOptions()->get('options');
        $classes = [];

        // Check if the page should be rendered
        if (!$options['render']) {
            return null;
        }

        // Check for assertions
        if (isset($options['assertion'])) {
            $this->validateAssertionService();

            if (!$this->assertionService->isGranted($options['assertion'], $this->getUser())) {
                return null;
            }
        }

        // CSS class for li
        if ($options['liClass']) {
            $classes[] = $options['liClass'];
        }

        // Active page
        if ($page->isActive()) {
            $classes[] = 'active';
        }

        $html = "   <li class=\"" . implode(" ", $classes) . "\"" . $page->getAttributes('li') . ">\n";
        $html .= '      <a href="' . $page->getUrl() . '"' . $page->getAttributes('a') . '>' . $page->getLabel() . "</a>\n";

        if (count($page->getPages()) && (is_null($maxDepth) || $maxDepth != $depth)) {
            $pageOptions = $page->getOptions()->get('options');
            $ulClass = $pageOptions['ulClass'];

            $html .= "      <ul class=\"" . $ulClass . "\"" . $page->getAttributes('ul') . ">\n";

            foreach ($page->getPages() as $subPage) {
                $html .= $this->renderPage($subPage, $maxDepth, ($depth + 1));
            }

            $html .= "      </ul>\n";
        }

        $html .= "    </li>\n";

        return $html;
    }

    /**
     * Get pages
     *
     * @return array|Page[]
     */
    public function getPages()
    {
        $pagesArray = $this->getOptions()->get('pages');

        if (is_null($pagesArray)) {
            $pagesArray = [];
        }

        $pages = [];

        foreach ($pagesArray as $page) {
            $page = new Page($page);
            $options = $page->getOptions()->get('options');

            $pages[] = $page;
        }

        return $pages;
    }

    /**
     * Get attributes as string
     *
     * @return string
     */
    public function getAttributes()
    {
        $attributes = $this->getOptions()->get('ulAttributes');

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
     * @return ContainerOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param ContainerOptions $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * Get user
     */
    protected function getUser()
    {
        return Auth::user();
    }
}
