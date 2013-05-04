<?php

namespace Jace;

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Event::reset();
    }

    public function showSomething()
    {
    }

    public function testRegister()
    {
        Event::register('test', [$this, 'showSomething']);
        Event::trigger('test');
    }
}