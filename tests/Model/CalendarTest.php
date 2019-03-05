<?php

namespace Jsvrcek\ICS\Model;

class CalendarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Jsvrcek\ICS\Model\Calendar::__construct
     */
    public function testConstruct()
    {
        $c = new Calendar();
        
        //test defaults
        $this->assertEquals('America/New_York', $c->getTimezone()->getName());
    }
}
