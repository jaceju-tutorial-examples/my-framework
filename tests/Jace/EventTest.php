<?php

namespace Jace;

class A
{
    public static function eat()
    {
        echo "A::eat" . PHP_EOL;
    }
}

class C
{
    public static function eat()
    {
        echo "C::eat" . PHP_EOL;
    }
}

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testRegister()
    {
        Event::register('eat', 'Jace\\A::eat');
        Event::register('eat', 'Jace\\C::eat');
        $this->assertEquals(2,
            count(Event::getCallbacks('eat')));
        ob_start();
        Event::trigger('eat');
        $result = ob_get_clean();
        $this->assertEquals("A::eat" . PHP_EOL . "C::eat" . PHP_EOL, $result);
    }
}