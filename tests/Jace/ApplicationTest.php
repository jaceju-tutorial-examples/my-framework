<?php

namespace Jace;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    protected $_app = null;

    public function setUp()
    {
        $this->_app = new Application();
    }

    /**
     * @dataProvider provider
     * jaceju@gmail.com
     */
    public function testDispatch(
        $requestUri,
        $expectControllerName,
        $expectActionName,
        $expectResult
        )
    {
        $_SERVER["REQUEST_URI"] = $requestUri;

        ob_start();
        $this->_app->run(__DIR__ . '/config.ini');
        $controllerName = $this->_app->getControllerName();
        $actionName = $this->_app->getActionName();
        $this->assertEquals($expectControllerName, $controllerName);
        $this->assertEquals($expectActionName, $actionName);
        $result = ob_get_clean();
        $this->assertEquals($expectResult, $result);
    }

    public function provider()
    {
        return [
            ["/", 'index', 'index', 'INDEX'],
            ["/blog/article", 'blog', 'article', 'Article'],
        ];
    }

    public function testErrorController()
    {
        ob_start();
        $_SERVER["REQUEST_URI"] = "/index/error";
        $this->_app->run(__DIR__ . '/config.ini');
        $result = ob_get_clean();
        $this->assertEquals("ERROR!!!!" . PHP_EOL, $result);
    }

    public function testExceptionController()
    {
        ob_start();
        $_SERVER["REQUEST_URI"] = "/index/exception";
        $this->_app->run(__DIR__ . '/config.ini');
        $result = ob_get_clean();
        $this->assertEquals("EXCEPTION!!!!!!" . PHP_EOL, $result);
    }

    public function testEvent()
    {
        Event::register('beforeDispatch', function () {
            echo "Before Dispatch!!!" . PHP_EOL;
        });
        Event::register('afterDispatch', function () {
            echo "After Dispatch!!!" . PHP_EOL;
        });

        ob_start();
        $_SERVER["REQUEST_URI"] = "/index/index";
        $this->_app->run(__DIR__ . '/config.ini');
        $result = ob_get_clean();
        echo $result;
    }
}