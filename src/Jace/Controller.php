<?php

namespace Jace;

class Controller
{
    protected $_response = null;

    public function setResponse(Response $response)
    {
        $this->_response = $response;
    }
}