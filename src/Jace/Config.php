<?php

namespace Jace;

abstract class Config
{
    protected $_data = [];

    public function __get($name)
    {
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        } else {
            return null;
        }
    }

    public static function factory($filePath)
    {
        $ext = pathinfo($filePath)['extension'];
        $className = "\\" . __NAMESPACE__ . "\\Config\\" . ucfirst(strtolower($ext));
        if (class_exists($className)) {
            return new $className($filePath);
        } else {
            throw new \Exception("Invalid file type.");
        }
    }
}