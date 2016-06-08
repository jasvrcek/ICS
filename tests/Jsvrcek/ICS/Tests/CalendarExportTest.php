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
            ->setOrganizer($organizer)
            ->setSequence(3);
        
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
        
        //create second calendar using batch event provider
        $calTwo = new Calendar();
        $calTwo->setProdId('-//Jsvrcek//ICS//EN2')
            ->setTimezone(new \DateTimeZone('Arctic/Longyearbyen'));
        
        $calTwo->setEventsProvider(function($start){
            $eventOne = new CalendarEvent();
            $eventOne->setUid('asdfasdf@example.com')
                ->setStart(new \DateTime('2016-01-01 01:01:01'))
                ->setEnd(new \DateTime('2016-01-02 01:01:01'))
                ->setSummary('A long day');
            
            $eventTwo = new CalendarEvent();
            $eventTwo->setUid('asdfasdf@example.com')
                ->setStart(new \DateTime('2016-01-02 01:01:01'))
                ->setEnd(new \DateTime('2016-01-03 01:01:01'))
                ->setSummary('Another long day');
            
            return ($start > 0) ? array() : array($eventOne, $eventTwo);
        });
        
        $ce = new CalendarExport(new CalendarStream(), new Formatter());
        $ce->addCalendar($cal)
            ->addCalendar($calTwo);
        
        $stream = $ce->getStream();
        
        //file_put_contents(__DIR__.'/../../../test.ics', $stream);
        
        $expected = file_get_contents(__DIR__.'/../../../test.ics');
        
        $this->assertEquals($expected, $stream);
    }
}