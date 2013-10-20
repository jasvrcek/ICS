<?php

namespace Jsvrcek\ICS\Tests;

use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\Model\Calendar;

class CalendarExportTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAndSetCalendars()
    {
        $calendars = array(new Calendar());
        $ce = new CalendarExport();
        $ce->setCalendars($calendars);
        
        $this->assertEquals($calendars, $ce->getCalendars());
    }
    
    public function testAddCalendar()
    {
        $cal = new Calendar();
        $ce = new CalendarExport();
        $ce->addCalendar($cal);
        
        $this->assertEquals(array($cal), $ce->getCalendars());
    }
    
    public function testGetStream()
    {
        $cal = new Calendar();
        
        $ce = new CalendarExport();
        $ce->addCalendar($cal);
        
        $stream = $ce->getStream();
        
        //file_put_contents(__DIR__.'/../../../test.ics', $stream);
        
        $expected = file_get_contents(__DIR__.'/../../../test.ics');
        
        $this->assertEquals($expected, $stream);
    }
}