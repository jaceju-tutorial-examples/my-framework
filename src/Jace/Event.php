<?php

namespace Jace;

class Event
{
    private static $_callbacks = [];

    public static function register($name, $callback)
    {
        $eventName = strtolower($name);
        if (is_callable($callback)) {
            static::$_callbacks[$eventName][] = $callback;
        }
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
    }
}