<?php

namespace Jsvrcek\ICS\Tests;

use Jsvrcek\ICS\Model\Recurrence\DataType\Weekday;

use Jsvrcek\ICS\Model\Recurrence\DataType\WeekdayNum;

use Jsvrcek\ICS\Model\Recurrence\DataType\Frequency;

use Jsvrcek\ICS\Model\Recurrence\RecurrenceRule;

use Jsvrcek\ICS\Model\Relationship\Organizer;

use Jsvrcek\ICS\Utility\Formatter;

use Jsvrcek\ICS\CalendarStream;

use Jsvrcek\ICS\Model\Relationship\Attendee;

use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;

class CalendarExportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Jsvrcek\ICS\CalendarExport::getStream 
     */
    public function testGetStream()
    {
        $organizer = new Organizer(new Formatter());
        $organizer->setValue('sue@example.com')
            ->setName('Sue Jones')
            ->setSentBy('mary@example.com')
            ->setLanguage('en');
        
        $attendee = new Attendee(new Formatter());
        $attendee->setName('Jane Smith')
            ->setCalendarUserType('INDIVIDUAL')
            ->setParticipationStatus('ACCEPTED')
            ->setRole('REQ-PARTICIPANT')
            ->setSentBy('joe@example')
            ->addCalendarMember('list@example.com')
            ->setValue('jane-smith@example.com');
        
        $event = new CalendarEvent();
        $event->setUid('lLKjd89283oja89282lkjd8@example.com')
            ->setStart(new \DateTime('1 October 2013'))
            ->setEnd(new \DateTime('31 October 2013'))
            ->setSummary('Oktoberfest at the South Pole')
            ->addAttendee($attendee)
            ->setOrganizer($organizer);
        
        $rrule = new RecurrenceRule(new Formatter());
        $rrule->setFrequency(new Frequency(Frequency::MONTHLY))
            ->setInterval(2)
            ->setCount(6)
            ->addByDay(new WeekdayNum(Weekday::SATURDAY, 2));
        $event->setRecurrenceRule($rrule);
        
        $cal = new Calendar();
        $cal->setProdId('-//Jsvrcek//ICS//EN')
            ->setTimezone(new \DateTimeZone('Antarctica/McMurdo'))
            ->addEvent($event);
        
        $ce = new CalendarExport(new CalendarStream(), new Formatter());
        $ce->addCalendar($cal);
        
        $stream = $ce->getStream();
        
        //file_put_contents(__DIR__.'/../../../test.ics', $stream);
        
        $expected = file_get_contents(__DIR__.'/../../../test.ics');
        
        $this->assertEquals($expected, $stream);
    }
}