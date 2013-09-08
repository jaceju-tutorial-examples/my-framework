<?php

namespace Jace;

abstract class Module
{
    protected $_app = null;

    public function __construct(Application $app)
    {
        $this->_app = $app;
    }

    public function init()
    {
    }
}