<?php

namespace Jsvrcek\ICS\Tests\Model\Recurrence;

use Jsvrcek\ICS\Model\Recurrence\DataType\Weekday;
use Jsvrcek\ICS\Model\Recurrence\DataType\WeekdayNum;
use Jsvrcek\ICS\Model\Recurrence\DataType\Frequency;

use Jsvrcek\ICS\Utility\Formatter;
use Jsvrcek\ICS\Model\Recurrence\RecurrenceRule;

class RecurrenceRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RecurrenceRule
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @return Rule
     */
    protected function setUp()
    {
        $this->object = new RecurrenceRule(new Formatter());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Jsvrcek\ICS\Model\Recurrence\RecurrentRule::__toString()
     */
    public function testToString()
    {
        $this->object
            ->setFrequency(new Frequency(Frequency::YEARLY))
            ->setInterval(2)
            ->setCount(10)
            ->addByDay(new WeekdayNum(Weekday::MONDAY, 10, WeekdayNum::COUNT_FROM_START))
            ->addByDay(new WeekdayNum(Weekday::TUESDAY, 10, WeekdayNum::COUNT_FROM_END))
            ->setUntil(new \DateTime('2050-01-01 00:00:00', new \DateTimeZone('UTC')))
        ;
        
        $expected = 'RRULE:FREQ=YEARLY;INTERVAL=2;UNTIL=20500101T000000Z;COUNT=10;BYDAY=10MO,-10TU';
        
        $this->assertEquals($expected, $this->object->__toString());

        //get a new object, test byMonth
        $this->setUp();

        $this->object
            ->setFrequency(new Frequency(Frequency::WEEKLY))
            ->setInterval(1)
            ->addByMonth(2)
            ->addByMonth(3)
            ->addByMonth(4)
        ;

        $expected = 'RRULE:FREQ=WEEKLY;INTERVAL=1;BYMONTH=2,3,4';
        
        $this->assertEquals($expected, $this->object->__toString());
    }
    
    /**
     * @covers Jsvrcek\ICS\Model\Recurrence\RecurrentRule::parse()
     * @depends testToString
     */
    public function testParse()
    {
        //reset instance
        $this->setUp();
        
        $rRuleString = 'RRULE:FREQ=YEARLY;INTERVAL=2';
        $this->object->parse($rRuleString);
        $this->assertEquals($rRuleString, $this->object->__toString());
        
        $rRuleString = 'RRULE:FREQ=WEEKLY;INTERVAL=4';
        $this->object->parse($rRuleString);
        $this->assertEquals($rRuleString, $this->object->__toString());
        
        $rRuleString = 'RRULE:FREQ=WEEKLY;INTERVAL=4;UNTIL=20500101T000000Z';
        $this->object->parse($rRuleString);
        $this->assertEquals($rRuleString, $this->object->__toString());
        
        /*
        $rRuleString = 'RRULE:FREQ=YEARLY;INTERVAL=2;COUNT=10;BYDAY=10MO,-10TU';
        $this->object->parse($rRuleString);
        $this->assertEquals($rRuleString, $this->object->__toString());
        */
    }
}
