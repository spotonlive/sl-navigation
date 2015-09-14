<?php

namespace SpotOnLive\Navigation\Navigation;

// Override view
function view($partial, $data = [])
{
    return \SpotOnLive\NavigationTest\Navigation\ContainerTest::view($partial, $data);
}

// Tests
namespace SpotOnLive\NavigationTest\Navigation;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /** @var \SpotOnLive\Navigation\Navigation\Container */
    protected $navigation;

    /** @var \SpotOnLive\Navigation\Options\ContainerOptions */
    protected $options;

    public function setUp()
    {
        $options = $this->getMockBuilder('SpotOnLive\Navigation\Options\ContainerOptions')
            ->disableOriginalConstructor()
            ->getMock();

        $this->options = $options;

        $navigation = new \SpotOnLive\Navigation\Navigation\Container([]);
        $navigation->setOptions($options);

        $this->navigation = $navigation;
    }

    public function testRenderPartial()
    {
        $partialName = 'test';
        $data = [
            'container' => $this->navigation
        ];

        $return = $this->navigation->renderPartial($partialName);

        $this->assertSame($partialName . json_encode($data), $return);
    }

    public function testRenderNoClass()
    {
        $optionsArray = [
            'ulClass' => null
        ];

        $attributes = [];
        $pages = [];
        $depth = 0;

        $return = '<ul class="">
</ul>';

        $this->options->expects($this->at(0))
            ->method('get')
            ->with('options')
            ->willReturn($optionsArray);

        $this->options->expects($this->at(1))
            ->method('get')
            ->with('ulAttributes')
            ->willReturn($attributes);

        $this->options->expects($this->at(2))
            ->method('get')
            ->with('pages')
            ->willReturn($pages);

        $result = $this->navigation->render($depth);

        $this->assertSame($return, $result);
    }

    public function testRenderWithClass()
    {
        $optionsArray = [
            'ulClass' => 'tester'
        ];

        $attributes = [];
        $pages = [];
        $depth = 0;

        $return = '<ul class="tester">
</ul>';

        $this->options->expects($this->at(0))
            ->method('get')
            ->with('options')
            ->willReturn($optionsArray);

        $this->options->expects($this->at(1))
            ->method('get')
            ->with('ulAttributes')
            ->willReturn($attributes);

        $this->options->expects($this->at(2))
            ->method('get')
            ->with('pages')
            ->willReturn($pages);

        $result = $this->navigation->render($depth);

        $this->assertSame($return, $result);
    }

    public function testRenderWithAttributes()
    {
        $optionsArray = [
            'ulClass' => null
        ];

        $attributes = [
            'attr1' => 'value1',
            'attr2' => 'value2',
        ];
        $pages = [];
        $depth = 0;

        $return = '<ul class="" attr1="value1" attr2="value2">
</ul>';

        $this->options->expects($this->at(0))
            ->method('get')
            ->with('options')
            ->willReturn($optionsArray);

        $this->options->expects($this->at(1))
            ->method('get')
            ->with('ulAttributes')
            ->willReturn($attributes);

        $this->options->expects($this->at(2))
            ->method('get')
            ->with('pages')
            ->willReturn($pages);

        $result = $this->navigation->render($depth);

        $this->assertSame($return, $result);
    }

    /**
     * Replace view from laravel
     *
     * @param string $partial
     * @param array $data
     * @return string
     */
    public static function view($partial, $data = [])
    {
        return $partial . json_encode($data);
    }
}
