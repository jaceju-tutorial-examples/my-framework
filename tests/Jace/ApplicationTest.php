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
     */
    public function testRouteToController(
        $requestUri,
        $expectControllerName,
        $expectActionName,
        $expectResult)
    {
        $_SERVER = [
            "REQUEST_URI" => $requestUri,
        ];

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
            ["/", "index", "index", "INDEX"],
            ["/test/abc", "test", "abc", "TEST"],
        ];
    }

}