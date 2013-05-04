<?php

namespace Jace;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    protected $_config = null;

    public function setUp()
    {
        $this->_config = Config::factory(__DIR__ . '/config.ini');
    }

    public function testConfigTypeShouldBeIni()
    {
        $this->assertInstanceOf('Jace\\Config\\Ini', $this->_config);
    }

    public function testItShouldReturnValue()
    {
        $appName = $this->_config->appName;
        $this->assertEquals('MyApp', $appName);
    }
}