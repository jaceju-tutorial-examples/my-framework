<?php

namespace Jace;

use Roller\Router;

class Application
{
    const DEFAULT_CONTROLLER = 'index';
    const DEFAULT_ACTION = 'index';

    protected $_config = [];
    protected $_controllerName = 'index';
    protected $_actionName = 'index';

    public function run($filePath)
    {
        $this->_config = Config::factory($filePath);
        $this->_route();
        return $this->_dispatch();
    }

    protected function _route()
    {
        $router = new Router();
        $router->add('/:controllerName/:actionName', function ($controllerName, $actionName) {
            $this->_controllerName = $controllerName;
            $this->_actionName = $actionName;
        });

        $requestUri = $_SERVER["REQUEST_URI"];
        $route = $router->dispatch($requestUri);

        if ($route) {
            $route();
        }
    }

    protected function _dispatch()
    {
        $controllerClass = ucfirst(
            strtolower($this->_controllerName)
            ) . 'Controller';

        $methodName = strtolower($this->_actionName)
            . 'Action';

        Event::trigger('beforeDispatch');
        $controller = new $controllerClass();
        Event::trigger('afterDispatch');

        return $controller->$methodName();
    }

    public function getControllerName()
    {
        return $this->_controllerName;
    }

    public function getActionName()
    {
        return $this->_actionName;
    }
}