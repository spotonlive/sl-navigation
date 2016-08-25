<?php
// @codingStandardsIgnoreStart
namespace {

    class Auth
    {
        public static function user()
        {
            return \SpotOnLive\NavigationTest\Navigation\ContainerTest::$user;
        }
    }
}

namespace SpotOnLive\Navigation\Navigation {

    function view($partial, $data = [])
    {
        return \SpotOnLive\NavigationTest\Navigation\ContainerTest::view($partial, $data);
    }

    function app($class)
    {
        switch ($class) {
            case \SpotOnLive\Navigation\Navigation\Providers\ArrayProvider::class:
                return new \SpotOnLive\Navigation\Navigation\Providers\ArrayProvider();
                break;

            default:
                return null;
        }
    }
}

namespace SpotOnLive\NavigationTest\Navigation {

    use SpotOnLive\Navigation\Navigation\Page;
    use SpotOnLive\Navigation\Navigation\Providers\ArrayProvider;
    use SpotOnLive\Navigation\Navigation\Providers\NavigationProviderInterface;
    use SpotOnLive\Navigation\Options\ContainerOptions;
    use SpotOnLive\Navigation\Options\PageOptions;

    class ContainerTest extends \PHPUnit_Framework_TestCase
    {
        // @codingStandardsIgnoreEnd
        /** @var \SpotOnLive\Navigation\Navigation\Container */
        protected $navigation;

        /** @var ContainerOptions */
        protected $options;

        public static $user;

        public function setUp()
        {
            parent::setUp();

            // Options
            $options = $this->getMockBuilder(ContainerOptions::class)
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
                'container' => $this->navigation,
            ];

            $return = $this->navigation->renderPartial($partialName);

            $this->assertSame($partialName . json_encode($data), $return);
        }

        public function testRenderNoClass()
        {
            $optionsArray = [
                'ul_class' => null
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
                ->with('ul_attributes')
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
                'ul_class' => 'tester'
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
                ->with('ul_attributes')
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
                'ul_class' => null
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
                ->with('ul_attributes')
                ->willReturn($attributes);

            $this->options->expects($this->at(2))
                ->method('get')
                ->with('pages')
                ->willReturn($pages);

            $result = $this->navigation->render($depth);

            $this->assertSame($return, $result);
        }

        public function testRenderPageMaxDepth()
        {
            /** @var Page $page */
            $page = $this->getMock('\SpotOnLive\Navigation\Navigation\Page');
            $maxDepth = 1;
            $depth = 2;

            $result = $this->navigation->renderPage($page, $maxDepth, $depth);

            $this->assertNull($result);
        }

        public function testRenderPageNoRender()
        {
            $maxDepth = 2;
            $depth = 2;

            $optionsData = [
                'render' => false,
            ];

            /** @var Page $page */
            $page = $this->getMock('\SpotOnLive\Navigation\Navigation\Page');

            /** @var PageOptions $options */
            $options = $this->getMock('\SpotOnLive\Navigation\Options\PageOptions');

            $page->expects($this->at(0))
                ->method('getOptions')
                ->willReturn($options);

            $options->expects($this->at(0))
                ->method('get')
                ->with('options')
                ->willReturn($optionsData);

            $result = $this->navigation->renderPage($page, $maxDepth, $depth);

            $this->assertNull($result);
        }

        public function testRenderAssertionNoAssertionService()
        {
            $maxDepth = 2;
            $depth = 2;

            $assertionName = 'assertion.test';

            $optionsData = [
                'assertion' => $assertionName,
                'render' => true,
            ];

            /** @var Page $page */
            $page = $this->getMock('\SpotOnLive\Navigation\Navigation\Page');

            /** @var PageOptions $options */
            $options = $this->getMock('\SpotOnLive\Navigation\Options\PageOptions');

            $page->expects($this->at(0))
                ->method('getOptions')
                ->willReturn($options);

            $options->expects($this->at(0))
                ->method('get')
                ->with('options')
                ->willReturn($optionsData);

            $this->setExpectedException(
                '\SpotOnLive\Navigation\Exceptions\IllegalConfigurationException',
                'Please require spotonlive/assertions` to use assertions in your navigation'
            );

            $result = $this->navigation->renderPage($page, $maxDepth, $depth);

            $this->assertNull($result);
        }

        public function testRenderAssertionNotGranted()
        {
            $maxDepth = 2;
            $depth = 2;

            $assertionName = 'assertion.test';

            $optionsData = [
                'assertion' => $assertionName,
                'render' => true,
            ];

            $assertionService = $this->getMockBuilder('stdClass')
                ->setMethods(['isGranted'])
                ->getMock();

            $this->navigation->setAssertionService($assertionService);

            /** @var Page $page */
            $page = $this->getMock('\SpotOnLive\Navigation\Navigation\Page');

            /** @var PageOptions $options */
            $options = $this->getMock('\SpotOnLive\Navigation\Options\PageOptions');

            $user = $this->getMock('stdClass');

            $page->expects($this->at(0))
                ->method('getOptions')
                ->willReturn($options);

            $options->expects($this->at(0))
                ->method('get')
                ->with('options')
                ->willReturn($optionsData);

            // Set value for \Auth
            self::$user = $user;

            $assertionService->expects($this->at(0))
                ->method('isGranted')
                ->with($assertionName, $user)
                ->willReturn(false);

            $result = $this->navigation->renderPage($page, $maxDepth, $depth);

            $this->assertNull($result);
        }

        public function testRenderIsActive()
        {
            $maxDepth = 2;
            $depth = 2;

            $assertionName = 'assertion.test';

            $optionsData = [
                'assertion' => $assertionName,
                'render' => true,
                'li_class' => null,
                'wrapper' => '%s',
            ];

            $url = 'http://spotonlive.dk';
            $label = 'spotonlive';
            $pages = [];

            $assertionService = $this->getMockBuilder('stdClass')
                ->setMethods(['isGranted'])
                ->getMock();

            $this->navigation->setAssertionService($assertionService);

            /** @var Page $page */
            $page = $this->getMock(Page::class);

            /** @var PageOptions $options */
            $options = $this->getMock(PageOptions::class);

            $user = $this->getMock('stdClass');

            $page->expects($this->at(0))
                ->method('getOptions')
                ->willReturn($options);

            $options->expects($this->at(0))
                ->method('get')
                ->with('options')
                ->willReturn($optionsData);

            // Set value for \Auth
            self::$user = $user;

            $assertionService->expects($this->at(0))
                ->method('isGranted')
                ->with($assertionName, $user)
                ->willReturn(true);

            $page->expects($this->at(1))
                ->method('isActive')
                ->willReturn(true);

            $page->expects($this->at(2))
                ->method('getUrl')
                ->willReturn($url);

            $page->expects($this->at(3))
                ->method('getAttributes')
                ->with('a')
                ->willReturn(null);

            $page->expects($this->at(4))
                ->method('getLabel')
                ->willReturn($label);

            $page->expects($this->at(5))
                ->method('getLabel')
                ->willReturn($label);

            $page->expects($this->at(6))
                ->method('getPages')
                ->willReturn($pages);

            $expected = '   <li class="active">
      <a href="http://spotonlive.dk">spotonlive</a>
    </li>
';

            $result = $this->navigation->renderPage($page, $maxDepth, $depth);

            $this->assertSame($expected, $result);
        }

        public function testRenderIsNotActive()
        {
            $maxDepth = 2;
            $depth = 2;

            $assertionName = 'assertion.test';

            $optionsData = [
                'assertion' => $assertionName,
                'render' => true,
                'li_class' => null,
                'wrapper' => '%s',
            ];

            $url = 'http://spotonlive.dk';
            $label = 'spotonlive';
            $pages = [];

            $assertionService = $this->getMockBuilder('stdClass')
                ->setMethods(['isGranted'])
                ->getMock();

            $this->navigation->setAssertionService($assertionService);

            /** @var Page $page */
            $page = $this->getMock(Page::class);

            /** @var PageOptions $options */
            $options = $this->getMock(PageOptions::class);

            $user = $this->getMock('stdClass');

            $page->expects($this->at(0))
                ->method('getOptions')
                ->willReturn($options);

            $options->expects($this->at(0))
                ->method('get')
                ->with('options')
                ->willReturn($optionsData);

            // Set value for \Auth
            self::$user = $user;

            $assertionService->expects($this->at(0))
                ->method('isGranted')
                ->with($assertionName, $user)
                ->willReturn(true);

            $page->expects($this->at(1))
                ->method('isActive')
                ->willReturn(false);

            $page->expects($this->at(2))
                ->method('getUrl')
                ->willReturn($url);

            $page->expects($this->at(3))
                ->method('getAttributes')
                ->with('a')
                ->willReturn(null);

            $page->expects($this->at(4))
                ->method('getLabel')
                ->willReturn($label);

            $page->expects($this->at(5))
                ->method('getPages')
                ->willReturn($pages);

            $expected = '   <li class="">
      <a href="http://spotonlive.dk">spotonlive</a>
    </li>
';

            $result = $this->navigation->renderPage($page, $maxDepth, $depth);

            $this->assertSame($expected, $result);
        }

        public function testRenderWithLiClass()
        {
            $maxDepth = 2;
            $depth = 2;

            $assertionName = 'assertion.test';

            $optionsData = [
                'assertion' => $assertionName,
                'render' => true,
                'li_class' => 'hidden',
                'wrapper' => '%s',
            ];

            $url = 'http://spotonlive.dk';
            $label = 'spotonlive';
            $pages = [];

            $assertionService = $this->getMockBuilder('stdClass')
                ->setMethods(['isGranted'])
                ->getMock();

            $this->navigation->setAssertionService($assertionService);

            /** @var Page $page */
            $page = $this->getMock(Page::class);

            /** @var PageOptions $options */
            $options = $this->getMock(PageOptions::class);

            $user = $this->getMock('stdClass');

            $page->expects($this->at(0))
                ->method('getOptions')
                ->willReturn($options);

            $options->expects($this->at(0))
                ->method('get')
                ->with('options')
                ->willReturn($optionsData);

            // Set value for \Auth
            self::$user = $user;

            $assertionService->expects($this->at(0))
                ->method('isGranted')
                ->with($assertionName, $user)
                ->willReturn(true);

            $page->expects($this->at(1))
                ->method('isActive')
                ->willReturn(false);

            $page->expects($this->at(2))
                ->method('getUrl')
                ->willReturn($url);

            $page->expects($this->at(3))
                ->method('getAttributes')
                ->with('a')
                ->willReturn(null);

            $page->expects($this->at(4))
                ->method('getLabel')
                ->willReturn($label);

            $page->expects($this->at(5))
                ->method('getPages')
                ->willReturn($pages);

            $expected = '   <li class="hidden">
      <a href="http://spotonlive.dk">spotonlive</a>
    </li>
';

            $result = $this->navigation->renderPage($page, $maxDepth, $depth);

            $this->assertSame($expected, $result);
        }

        public function testRenderWithSubPages()
        {
            $maxDepth = 3;
            $depth = 2;

            $assertionName = 'assertion.test';

            $optionsData = [
                'assertion' => $assertionName,
                'render' => true,
                'li_class' => null,
                'ul_class' => 'visible',
                'wrapper' => '%s',
            ];

            $subPageOptionsData = [
                'render' => true,
                'li_class' => null,
                'wrapper' => '%s',
            ];

            $url = 'http://spotonlive.dk';
            $label = 'spotonlive';

            $subPageUrl = 'http://spotonmarketing.dk';
            $subPageLabel = 'spotonmarketing';

            /** @var Page $subPage */
            $subPage = $this->getMock(Page::class);

            $pages = [
                $subPage,
            ];

            $assertionService = $this->getMockBuilder('stdClass')
                ->setMethods(['isGranted'])
                ->getMock();

            $this->navigation->setAssertionService($assertionService);

            /** @var Page $page */
            $page = $this->getMock(Page::class);

            /** @var PageOptions $options */
            $options = $this->getMock(PageOptions::class);

            /** @var PageOptions $subPageOptions */
            $subPageOptions = $this->getMock('\SpotOnLive\Navigation\Options\PageOptions');

            $user = $this->getMock('stdClass');

            $page->expects($this->at(0))
                ->method('getOptions')
                ->willReturn($options);

            $options->expects($this->at(0))
                ->method('get')
                ->with('options')
                ->willReturn($optionsData);

            // Set value for \Auth
            self::$user = $user;

            $assertionService->expects($this->at(0))
                ->method('isGranted')
                ->with($assertionName, $user)
                ->willReturn(true);

            $page->expects($this->at(1))
                ->method('isActive')
                ->willReturn(false);

            $page->expects($this->at(2))
                ->method('getUrl')
                ->willReturn($url);

            $page->expects($this->at(3))
                ->method('getAttributes')
                ->with('a')
                ->willReturn(null);

            $page->expects($this->at(4))
                ->method('getLabel')
                ->willReturn($label);

            $page->expects($this->at(5))
                ->method('getPages')
                ->willReturn($pages);

            $page->expects($this->at(6))
                ->method('getAttributes')
                ->with('ul')
                ->willReturn(null);

            $subPage->expects($this->at(0))
                ->method('getOptions')
                ->willReturn($subPageOptions);

            $subPageOptions->expects($this->at(0))
                ->method('get')
                ->with('options')
                ->willReturn($subPageOptionsData);

            $subPage->expects($this->at(1))
                ->method('isActive')
                ->willReturn(false);

            $subPage->expects($this->at(2))
                ->method('getUrl')
                ->willReturn($subPageUrl);

            $subPage->expects($this->at(3))
                ->method('getAttributes')
                ->with('a')
                ->willReturn(null);

            $subPage->expects($this->at(4))
                ->method('getLabel')
                ->willReturn($subPageLabel);

            $subPage->expects($this->at(5))
                ->method('getPages')
                ->willReturn([]);

            $result = $this->navigation->renderPage($page, $maxDepth, $depth);

            $expected = '   <li class="">
      <a href="http://spotonlive.dk">spotonlive</a>
      <ul class="visible">
   <li class="">
      <a href="http://spotonmarketing.dk">spotonmarketing</a>
    </li>
      </ul>
    </li>
';

            $this->assertSame($expected, $result);
        }

        public function testGetPagesNull()
        {
            $pages = null;

            $this->options->expects($this->at(0))
                ->method('get')
                ->with('pages')
                ->willReturn($pages);

            $result = $this->navigation->getPages();

            $this->assertSame([], $result);
        }

        public function testGetPagesWithPages()
        {
            $pages = [
                [
                    'options' => [
                        'label' => 'test1',
                        'route' => 'test.test1',
                    ],
                ],
                [
                    'options' => [
                        'label' => 'test2',
                        'route' => 'test.test2',
                    ],
                ]
            ];

            $this->options->expects($this->at(0))
                ->method('get')
                ->with('pages')
                ->willReturn($pages);

            $result = $this->navigation->getPages();

            $this->assertCount(2, $result);

            foreach ($result as $page) {
                $this->assertInstanceOf('SpotOnLive\Navigation\Navigation\Page', $page);
            }
        }

        public function testGetAttributesNull()
        {
            $attributes = null;

            $this->options->expects($this->at(0))
                ->method('get')
                ->with('ul_attributes')
                ->willReturn($attributes);

            $result = $this->navigation->getAttributes();

            $this->assertNull($result);
        }

        public function testGetAttributesWithAttributes()
        {
            $attributes = [
                'id' => '1234',
                'placeholder' => 'test'
            ];

            $this->options->expects($this->at(0))
                ->method('get')
                ->with('ul_attributes')
                ->willReturn($attributes);

            $result = $this->navigation->getAttributes();

            $this->assertSame(' id="1234" placeholder="test"', $result);
        }

        public function testGetUser()
        {
            $method = self::getMethod('getUser');
            $object = new \SpotOnLive\Navigation\Navigation\Container([]);

            $user = $this->getMock('stdClass');

            self::$user = $user;

            $result = $method->invokeArgs($object, []);

            $this->assertSame($user, $result);
        }

        public function testGetAssertionService()
        {
            $assertionService = $this->getMock('stdClass');

            $this->navigation->setAssertionService($assertionService);

            $result = $this->navigation->getAssertionService();

            $this->assertSame($assertionService, $result);
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

        /**
        * @param string $name
        * @return \ReflectionMethod
        */
        protected static function getMethod($name)
        {
            $class = new \ReflectionClass('SpotOnLive\Navigation\Navigation\Container');

            $method = $class->getMethod($name);
            $method->setAccessible(true);

            return $method;
        }
    }
}
