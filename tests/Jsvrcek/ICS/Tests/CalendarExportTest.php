<?php

namespace Jsvrcek\ICS\Tests;

use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\Model\Calendar;

class CalendarExportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Jsvrcek\ICS\CalendarExport::getFormattedTimeOffset
     */
    public function testGetFormattedTimeOffset()
    {
        $ce = new CalendarExport();
        
        $offset = -18000;
        $expected = '-0500';
        $actual = $ce->getFormattedTimeOffset($offset);
        $this->assertEquals($expected, $actual);
        
        $offset = -14400;
        $expected = '-0400';
        $actual = $ce->getFormattedTimeOffset($offset);
        $this->assertEquals($expected, $actual);
    }
    
    
    /**
     * @covers Jsvrcek\ICS\CalendarExport::getStream 
     */
    public function testGetStream()
    {
        $cal = new Calendar();
        $cal->setProdId('-//Jsvrcek//ICS//EN');
        
        $ce = new CalendarExport();
        $ce->addCalendar($cal);
        
        $stream = $ce->getStream();
        
        file_put_contents(__DIR__.'/../../../test.ics', $stream);
        
        $expected = file_get_contents(__DIR__.'/../../../test.ics');
        
        $this->assertEquals($expected, $stream);
    }
}