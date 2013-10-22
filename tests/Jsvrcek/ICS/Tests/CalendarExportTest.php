<?php

namespace Jsvrcek\ICS\Tests;

use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;

class CalendarExportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Jsvrcek\ICS\CalendarExport::getFormattedDateTime
     */
    public function testGetFormattedDateTime()
    {
        $ce = new CalendarExport();
        
        $dateTime = new \DateTime('1998-01-18 23:00:00');
        $expected = '19980118T230000';
        $actual = $ce->getFormattedDateTime($dateTime);
        $this->assertEquals($expected, $actual);
    }
    
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
        
        $offset = 14400;
        $expected = '+0400';
        $actual = $ce->getFormattedTimeOffset($offset);
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @covers Jsvrcek\ICS\CalendarExport::getFormattedUTCDateTime
     */
    public function testGetFormattedUTCDateTime()
    {
        $ce = new CalendarExport();
        
        $dateTime = new \DateTime('1998-01-18 23:00:00', new \DateTimeZone('America/New_York'));
        $expected = '19980119T040000Z';
        $actual = $ce->getFormattedUTCDateTime($dateTime);
        $this->assertEquals($expected, $actual);
    }
    
    
    /**
     * @covers Jsvrcek\ICS\CalendarExport::getStream 
     */
    public function testGetStream()
    {
        $event = new CalendarEvent();
        $event->setUid('lLKjd89283oja89282lkjd8@example.com')
            ->setStart(new \DateTime('1 October 2013'))
            ->setEnd(new \DateTime('31 October 2013'))
            ->setSummary('Oktoberfest at the South Pole');
        
        $cal = new Calendar();
        $cal->setProdId('-//Jsvrcek//ICS//EN')
            ->setTimezone(new \DateTimeZone('Antarctica/McMurdo'))
            ->addEvent($event);
        
        $ce = new CalendarExport();
        $ce->addCalendar($cal);
        
        $stream = $ce->getStream();
        
        file_put_contents(__DIR__.'/../../../test.ics', $stream);
        
        $expected = file_get_contents(__DIR__.'/../../../test.ics');
        
        $this->assertEquals($expected, $stream);
    }
}