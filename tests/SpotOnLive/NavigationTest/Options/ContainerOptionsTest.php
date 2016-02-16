<?php

namespace SpotOnLive\NavigationTest\Options;

use PHPUnit_Framework_TestCase;

class ContainerOptionsTest extends PHPUnit_Framework_TestCase
{
    /** @var \SpotOnLive\Navigation\Options\ContainerOptions */
    protected $options;

    protected $defaults = [
        'options' => [
            'ul_class' => null,
            'depth' => null,
        ],

        'attributes' => [

        ],

        'pages' => [

        ]
    ];

    protected $demoOptions = [
        'a' => 'b'
    ];

    public function setUp()
    {
        $options = new \SpotOnLive\Navigation\Options\ContainerOptions($this->demoOptions);
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
                'ul_class' => null,
                'depth' => null,
            ],

            'attributes' => [

            ],

            'pages' => [

            ],
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
