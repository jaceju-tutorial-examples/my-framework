<?php

namespace Jace;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    protected $_app = null;

    public function setUp()
    {
        $this->_app = new Application();
    }

    public function testIndexController()
    {
        $_SERVER = [
            "REQUEST_URI" => "/",
        ];

        ob_start();
        $this->_app->run(__DIR__ . '/config.ini');
        $controllerName = $this->_app->getControllerName();
        $actionName = $this->_app->getActionName();
        $this->assertEquals('index', $controllerName);
        $this->assertEquals('index', $actionName);

        $result = ob_get_clean();
        $this->assertEquals('INDEX', $result);
    }

    public function testTestController()
    {
        $_SERVER = [
            "REQUEST_URI" => "/test/abc",
        ];

        ob_start();
        $this->_app->run(__DIR__ . '/config.ini');
        $controllerName = $this->_app->getControllerName();
        $actionName = $this->_app->getActionName();
        $this->assertEquals('test', $controllerName);
        $this->assertEquals('abc', $actionName);

        $result = ob_get_clean();
        $this->assertEquals('TEST', $result);
    }
}