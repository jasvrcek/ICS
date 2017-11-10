<?php

namespace Jsvrcek\ICS\Tests\Model\Relationship;

use Jsvrcek\ICS\Utility\Formatter;
use Jsvrcek\ICS\Model\Relationship\Organizer;

class OrganizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Organizer
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @return Organizer
     */
    protected function setUp()
    {
        $this->object = new Organizer(new Formatter());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Jsvrcek\ICS\Model\Organizer::__toString()
     */
    public function testToString()
    {
        $this->object
            ->setValue('leonardo@example.it')
            ->setName('Leonardo Da Vinci')
            ->setLanguage('it')
            ->setDirectory('http://en.wikipedia.org/wiki/Leonardo_da_Vinci')
            ->setSentBy('piero@example.com');
        
        $expected = 'ORGANIZER;SENT-BY="piero@example.com";CN=Leonardo Da Vinci;DIR="http://en.wikipedia.org/wiki/Leonardo_da_Vinci";LANGUAGE=it:mailto:leonardo@example.it';
        
        $this->assertEquals($expected, $this->object->__toString());
    }
}
