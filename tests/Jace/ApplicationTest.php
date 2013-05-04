<?php

namespace Jace;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    protected $_app = null;

    public function setUp()
    {
        $this->_app = new Application();
    }

    public function testAppNameShouldBeMyApp()
    {
        $this->_app->run(__DIR__ . '/config.ini');
        $appName = $this->_app->getAppName();
        $this->assertEquals('MyApp', $appName);
    }
}