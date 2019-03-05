<?php

namespace Jsvrcek\ICS\Model\Relationship;

class OrganizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Jsvrcek\ICS\Model\Relationship\Organizer::__toString()
     */
    public function testToString()
    {
        $organizer = new Organizer(
            'leonardo@example.it',
            'Leonardo Da Vinci',
            'http://en.wikipedia.org/wiki/Leonardo_da_Vinci',
            'piero@example.com',
            'it'
        );
        
        $expected = 'ORGANIZER;SENT-BY="piero@example.com";CN=Leonardo Da Vinci;DIR="http://en.wikipedia.org/wiki/Leonardo_da_Vinci";LANGUAGE=it:mailto:leonardo@example.it';
        
        self::assertEquals(
            $expected,
            $organizer->__toString()
        );
    }
}
