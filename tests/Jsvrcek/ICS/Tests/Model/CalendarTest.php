<?php

namespace Jsvrcek\ICS\Tests\Model;

use Jsvrcek\ICS\Model\Calendar;

class CalendarGetterAndSetterTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCalendar()
    {
        $cal = $this->createCalendar();
        $this->assertTrue($cal instanceof Calendar);
    }
    
    public function testVersion()
    {
        $cal = $this->createCalendar();
        $this->assertTrue($cal->setVersion('2.0') instanceof Calendar);
        $this->assertEquals('2.0', $cal->getVersion());
    }
    
    /**
     * @return \Jsvrcek\ICS\Model\Calendar
     */
    protected function createCalendar()
    {
        return new Calendar();
    }
}