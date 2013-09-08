<?php

namespace Jace;

class Application
{
    protected $_config = null;
    protected $_controllerName = '';
    protected $_actionName = '';
    protected $_response = null;

    public function run($filePath)
    {
        $this->_config = Config::factory($filePath);
        $this->_route();
        $this->_dispatch();
    }

    protected function _dispatch()
    {
        set_error_handler([$this, 'errorHandler']);
        $this->_response = new Response();
        $this->_response->renderExceptions(true);
        try {
            $controllerClass = ucfirst(strtolower($this->_controllerName)) . 'Controller';
            $actionName = ucfirst(strtolower($this->_actionName)) . 'Action';
            $controller = new $controllerClass();
            Event::trigger('beforeDispatch', $this);
            echo $controller->$actionName();
        } catch (\Exception $e) {
            $this->_response->setException($e);
        }
        //  ... close resources ...
        Event::trigger('afterDispatch', $this);

        $this->_response->sendResponse();
    }

    public function errorHandler($errNo, $errMsg, $errFile, $errLine)
    {
        throw new \ErrorException($errMsg, 0, $errNo, $errFile, $errLine);
    }

    public function getControllerName()
    {
        return $this->_controllerName;
    }

    public function getActionName()
    {
        return $this->_actionName;
    }

    protected function _route()
    {
        $router = new \Roller\Router();
        $router->add('/', function () {
            $this->_controllerName = 'index';
            $this->_actionName = 'index';
        });
        $router->add('/:controllerName/:actionName',
            function ($controllerName, $actionName) {
                $this->_controllerName = $controllerName;
                $this->_actionName = $actionName;
            });

        $requestUri = $_SERVER["REQUEST_URI"];
        $route = $router->dispatch($requestUri);
        if ($route !== false) {
            return $route();
        } else {
            throw new \Exception('404');
        }
    }
}