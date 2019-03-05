<?php

namespace Jsvrcek\ICS\Model\Relationship;

use Jsvrcek\ICS\Utility\Formatter;

class AttendeeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Attendee
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @return Attendee
     */
    protected function setUp()
    {
        $this->object = new Attendee(new Formatter());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Jsvrcek\ICS\Model\Attendee::__toString()
     */
    public function testToString()
    {
        $this->object
            ->setValue('joe-smith@example.com')
            ->setName('Joe Smith')
            ->setCalendarUserType('INDIVIDUAL')
            ->addCalendarMember('list@example.com')
            ->addDelegatedFrom('mary@example.com')
            ->addDelegatedTo('sue@example.com')
            ->addDelegatedTo('jane@example.com')
            ->setParticipationStatus('ACCEPTED')
            ->setRole('REQ-PARTICIPANT')
            ->setRsvp('TRUE')
            ->setSentBy('jack@example.com')
            ->setLanguage('en');
        
        $expected = 'ATTENDEE;CUTYPE=INDIVIDUAL;MEMBER="mailto:list@example.com";ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=TRUE;DELEGATED-TO="mailto:sue@example.com","mailto:jane@example.com";DELEGATED-FROM="mailto:mary@example.com";SENT-BY="jack@example.com";CN=Joe Smith;LANGUAGE=en:mailto:joe-smith@example.com';
        
        $this->assertEquals($expected, $this->object->__toString());
    }
}
