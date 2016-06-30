<?php

namespace SpotOnLive\NavigationTest\Options;

use PHPUnit_Framework_TestCase;

class PageOptionsTest extends PHPUnit_Framework_TestCase
{
    /** @var \SpotOnLive\Navigation\Options\PageOptions */
    protected $options;

    protected $defaults = [
        'options' => [
            'render' => true,
            'route_parameters' => [],
            'label' => '',
            'escape_html' => true,
            'li_class' => null,
            'ul_class' => null,
            'wrapper' => '%s',
        ],
        'attributes' => [],
        'pages' => []
    ];

    protected $demoOptions = [
        'a' => 'b'
    ];

    public function setUp()
    {
        $options = new \SpotOnLive\Navigation\Options\PageOptions($this->demoOptions);
        $this->options = $options;
    }

    public function testGetDefaults()
    {
        $result = $this->options->getDefaults();

        $this->assertSame($this->defaults, $result);
    }

    public function testSetDefaults()
    {
        $defaults = [
            'a' => 'b'
        ];

        $this->options->setDefaults($defaults);
        $result = $this->options->getDefaults();

        $this->assertSame($defaults, $result);
    }

    public function testGetOptions()
    {
        $options = [
            'options' => [
                'render' => true,
                'route_parameters' => [],
                'label' => '',
                'escape_html' => true,
                'li_class' => null,
                'ul_class' => null,
                'wrapper' => '%s',
            ],
            'attributes' => [],
            'pages' => [],
            'a' => 'b'
        ];

        $result = $this->options->getOptions();

        $this->assertSame($options, $result);
    }

    public function testSetOptions()
    {
        $newOptions = [
            'new' => 'options',
        ];

        $this->options->setOptions($newOptions);

        $result = $this->options->getOptions();

        $this->assertSame($newOptions, $result);
    }

    public function testGetOfNotExistingEntry()
    {
        $key = 'non-existing';

        $result = $this->options->get($key);

        $this->assertNull($result);
    }

    public function testGet()
    {
        $key = 'a';

        $result = $this->options->get($key);

        $this->assertSame($this->demoOptions[$key], $result);
    }
}
