<?php

class CustomException extends Exception
{}

class IndexController
{
    public function indexAction()
    {
        return "INDEX";
    }

    public function errorAction()
    {
        trigger_error('ERROR!!!!');
        return "Do Something";
    }

    public function exceptionAction()
    {
        throw new \CustomException("EXCEPTION!!!!!!");
    }
}