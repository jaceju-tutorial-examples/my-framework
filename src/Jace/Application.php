<?php

namespace Jace;

use Roller\Router;

class Application
{
    const DEFAULT_CONTROLLER = 'index';
    const DEFAULT_ACTION = 'index';

    protected $_config = [];
    protected $_response = null;
    protected $_controllerName = 'index';
    protected $_actionName = 'index';

    public function run($filePath)
    {
        set_error_handler([$this, 'exceptionErrorHandler']);

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
        $this->_response = new Response();
        try {
            $controllerClass = ucfirst(
                strtolower($this->_controllerName)
                ) . 'Controller';

            $methodName = strtolower($this->_actionName)
                . 'Action';

            Event::trigger('beforeDispatch');
            $controller = new $controllerClass();
            $controller->setResponse($this->_response);
            $this->_response->appendBody($controller->$methodName());
            Event::trigger('afterDispatch');

        } catch (Exception $e) {
            $this->_response->setException($e);
        }
        $this->_response->sendResponse();
    }

    public function getControllerName()
    {
        return $this->_controllerName;
    }

    public function getActionName()
    {
        return $this->_actionName;
    }

    public static function exceptionErrorHandler($errNo, $errMsg, $errFile, $errLine )
    {
        throw new \ErrorException($errMsg, 0, $errNo, $errFile, $errLine);
    }
}