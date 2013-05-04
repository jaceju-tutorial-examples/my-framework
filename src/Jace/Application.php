<?php

namespace Jace;

use Roller\Router;

class Application
{
    protected $_config = [];
    protected $_controllerName = '';
    protected $_actionName = '';

    public function run($filePath)
    {
        $this->_config = Config::factory($filePath);

        $router = new Router();
        $router->add('/:controllerName/:actionName', [$this, 'dispatch']);

        $requestUri = $_SERVER["REQUEST_URI"];
        $route = $router->dispatch($requestUri);

        if ($route) {
            return $route();
        }
    }

    public function dispatch($controllerName, $actionName)
    {
        $this->_controllerName = $controllerName;
        $this->_actionName = $actionName;

        $controllerClass = ucfirst(
            strtolower($this->_controllerName)
            ) . 'Controller';
        $methodName = strtolower($this->_actionName) . 'Action';

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