<?php

namespace Jace;

class Application
{
    protected $_config = [];
    protected $_appName = 'App';

    public function run($filePath)
    {
        $this->_config = Config::factory($filePath);
        $this->_appName = $this->_config->AppName;
        return $this;
    }

    public function getAppName()
    {
        return $this->_appName;
    }
}