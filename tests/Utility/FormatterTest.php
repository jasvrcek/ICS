<?php

namespace Jsvrcek\ICS\Utility;

class FormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Jsvrcek\ICS\Formatter::getFormattedDateTime
     */
    public function testGetFormattedDateTime()
    {
        $ce = new Formatter();

        $dateTime = new \DateTime('1998-01-18 23:00:00');
        $expected = '19980118T230000';
        $actual = $ce->getFormattedDateTime($dateTime);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Jsvrcek\ICS\Formatter::getFormattedTimeOffset
     */
    public function testGetFormattedTimeOffset()
    {
        $ce = new Formatter();

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
     * @covers Jsvrcek\ICS\Formatter::getFormattedUTCDateTime
     */
    public function testGetFormattedUTCDateTime()
    {
        $ce = new Formatter();

        $dateTime = new \DateTime('1998-01-18 23:00:00', new \DateTimeZone('America/New_York'));
        $expected = '19980119T040000Z';
        $actual = $ce->getFormattedUTCDateTime($dateTime);
        $this->assertEquals($expected, $actual);
        $ce = new Formatter();

        $dateTime = new \DateTime('1998-01-18 11:00:00', new \DateTimeZone('America/New_York'));
        $expected = '19980118T160000Z';
        $actual = $ce->getFormattedUTCDateTime($dateTime);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers \Jsvrcek\ICS\Utility\Formatter::getFormattedDateTimeWithTimeZone
     */
    public function testGetFormattedLocalDateTimeWithTimeZone()
    {
        $ce = new Formatter();

        $dateTime = new \DateTime('1998-01-18 23:00:00', new \DateTimeZone('America/New_York'));
        $expected = 'TZID=America/New_York:19980118T230000';
        $actual = $ce->getFormattedDateTimeWithTimeZone($dateTime);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Jsvrcek\ICS\Formatter::getFormattedUri
     */
    public function testGetFormattedUri()
    {
        $ce = new Formatter();

        $expected = 'mailto:test@example.com';
        $actual = $ce->getFormattedUri('test@example.com');
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Jsvrcek\ICS\Formatter::getFormattedDateInterval
     */
    public function testGetFormattedDateInterval()
    {
        $ce = new Formatter();

        $tests = array(
            "PT15M",
            "PT1H",
            "P345D",
            "P1Y6M29DT4H34M23S"
        );

        foreach ($tests as $test) {
            $this->assertEquals(
                $test,
                $ce->getFormattedDateInterval(new \DateInterval($test)),
                $test
            );
        }
    }
}
