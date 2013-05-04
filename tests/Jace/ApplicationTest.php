<?php

namespace Jace;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    protected $_app = null;

    public function setUp()
    {
        $this->_app = new Application();
    }

    public function testControllerNameShouldBeIndex()
    {
        $_SERVER = [
            "REQUEST_URI" => "/index/test",
        ];
        $this->_app->run(__DIR__ . '/config.ini');
        $controllerName = $this->_app->getControllerName();
        $this->assertEquals('index', $controllerName);
    }

    public function testResultShouldBeTest()
    {
        $_SERVER = [
            "REQUEST_URI" => "/index/test",
        ];
        $result = $this->_app->run(__DIR__ . '/config.ini');
        $this->assertEquals('TEST', $result);
    }
}