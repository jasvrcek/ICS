<?php

namespace Jsvrcek\ICS\Model;

class CalendarEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CalendarEvent
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @return CalendarEvent
     */
    protected function setUp()
    {
        $this->object = new CalendarEvent;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Jsvrcek\ICS\Model\CalendarEvent::setStart
     */
    public function testSetStart()
    {
        $start = new \DateTime();
        
        $this->object->setStart($start);
        
        // test start
        $this->assertEquals($start, $this->object->getStart());
        
        //test default end
        $this->assertEquals($start->add(\DateInterval::createFromDateString('30 minutes')), $this->object->getEnd());
    }

    /**
     * @covers Jsvrcek\ICS\Model\CalendarEvent::setEnd
     * @expectedException Jsvrcek\ICS\Exception\CalendarEventException
     * @expectedExceptionMessage End DateTime must be greater than Start DateTime
     */
    public function testSetEndDateEarlierThanStart()
    {
        $start = new \DateTime('now');
        $end = new \DateTime('yesterday');
        
        $this->object->setStart($start);
        $this->object->setEnd($end);
    }

    /**
     * @covers Jsvrcek\ICS\Model\CalendarEvent::setEnd
     * @expectedException Jsvrcek\ICS\Exception\CalendarEventException
     * @expectedExceptionMessage You must set the Start time before setting the End Time of a CalendarEvent
     */
    public function testSetEndWithoutStart()
    {
        $end = new \DateTime('yesterday');
        
        $this->object->setEnd($end);
    }
}
