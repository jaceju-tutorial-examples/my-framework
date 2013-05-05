<?php

namespace Jace;

class Response
{
    private $_body = [];
    private $_exceptions = [];
    private $_renderExceptions = false;

    public function appendBody($body)
    {
        $this->_body[] = $body;
    }

    public function setException(Exception $e)
    {
        $this->_exceptions[] = $e;
    }

    public function getExceptions()
    {
        return $this->_exceptions;
    }

    public function isException()
    {
        return !empty($this->_exceptions);
    }

    public function renderExceptions($flag = null)
    {
        if (null !== $flag) {
            $this->_renderExceptions = $flag ? true : false;
        }
        return $this->_renderExceptions;
    }

    public function sendResponse()
    {
        $this->sendHeaders();
        if ($this->isException() && $this->renderExceptions()) {
            $this->displayException();
        }
        $this->outputBody();
    }

    public function sendHeaders()
    {}

    public function displayException()
    {
        $exception = '';
        foreach ($this->getExceptions() as $e) {
            $exception .= $e->getMessage() . PHP_EOL;
        }
        echo $exception;
    }

    public function outputBody()
    {
        echo implode('', $this->_body);
    }
}
