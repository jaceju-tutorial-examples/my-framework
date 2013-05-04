<?php

namespace Jace;

class Event
{
    private static $_callbacks = [];

    private function __construct()
    {}

    public static function register($name, $callback)
    {
        if (!is_callable($callback)) {
            throw new \Exception('Invalid callback!');
        }
        $eventName = strtolower($name);
        static::$_callbacks[$eventName][] = $callback;
    }

    public static function trigger($name, $source = null)
    {
        $eventName = strtolower($name);
        if (isset(static::$_callbacks[$eventName])) {
            foreach (static::$_callbacks[$eventName] as $callback) {
                call_user_func($callback, $source);
            }
        }
    }

    public static function getCallbacks($name)
    {
        $eventName = strtolower($name);
        if (isset(static::$_callbacks[$eventName])) {
            return static::$_callbacks[$eventName];
        }
        return [];
    }

    public static function reset()
    {
        static::$_callbacks = [];
    }
}