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
        $result = $this->_app->run(__DIR__ . '/config.ini');
        $controllerName = $this->_app->getControllerName();
        $actionName = $this->_app->getActionName();
        $this->assertEquals('index', $controllerName);
        $this->assertEquals('index', $actionName);
        $this->assertEquals('INDEX', $result);
    }

    public function testTestController()
    {
        $_SERVER = [
            "REQUEST_URI" => "/test/abc",
        ];
        $result = $this->_app->run(__DIR__ . '/config.ini');
        $controllerName = $this->_app->getControllerName();
        $actionName = $this->_app->getActionName();
        $this->assertEquals('test', $controllerName);
        $this->assertEquals('abc', $actionName);
        $this->assertEquals('TEST', $result);
    }
}