<?php

namespace SpotOnLive\NavigationTest\Helpers;

use PHPUnit_Framework_TestCase;

class NavigationHelperTest extends PHPUnit_Framework_TestCase
{
    /** @var \SpotOnLive\Navigation\Helpers\NavigationHelper */
    protected $helper;

    /** @var \SpotOnLive\Navigation\Services\NavigationService */
    protected $navigationService;

    public function setUp()
    {
        $navigationService = $this->getMockBuilder('SpotOnLive\Navigation\Services\NavigationService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->navigationService = $navigationService;

        $helper = new \SpotOnLive\Navigation\Helpers\NavigationHelper($navigationService);
        $this->helper = $helper;
    }

    public function testGetContainer()
    {
        $name = "testContainer";
        $result = "container";

        $this->navigationService->expects($this->at(0))
            ->method('getContainer')
            ->with($name)
            ->willReturn($result);

        $return = $this->helper->getContainer($name);

        $this->assertSame($result, $return);
    }
}
