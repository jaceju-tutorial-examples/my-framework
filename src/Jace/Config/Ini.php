<?php

namespace Jace\Config;

use Jace\Config;

class Ini extends Config
{
    public function __construct($filePath)
    {
        $this->_data = parse_ini_file($filePath);
    }
}