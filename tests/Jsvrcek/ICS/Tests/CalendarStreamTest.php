<?php

namespace Jsvrcek\ICS\Tests;

use Jsvrcek\ICS\CalendarStream;
use Jsvrcek\ICS\Constants;

class CalendarStreamTest extends \PHPUnit_Framework_TestCase
{
    public function testGetStream()
    {
        $s = new CalendarStream();
        $this->assertEquals('', $s->getStream());
    }
    
    public function testAddItemToStream()
    {
        //simple test
        $s = new CalendarStream();
        $item = 'TEST';
        $expected = 'TEST'.Constants::CRLF;
        $s->addItemToStream($item);
        $this->assertEquals($expected, $s->getStream());
        
        //long string test
        $s = new CalendarStream();
        $item = ' aaaaaaa10 aaaaaaa20 aaaaaaa30 aaaaaaa40 aaaaaaa50 aaaaaaa60 aaaaaaa70 aaaaaaa80 aaaaaaa90';
        $expected = ' aaaaaaa10 aaaaaaa20 aaaaaaa30 aaaaaaa40 aaaaaaa50 aaaaaaa60 aaaaaaa70'.Constants::CRLF.' '.' aaaaaaa80 aaaaaaa90'.Constants::CRLF;
        $s->addItemToStream($item);
        $this->assertEquals($expected, $s->getStream());
        
        //mb long string test
        $s = new CalendarStream();
        $item = ' §§§a10 §§§a20 §§§a30 §§§a40 §§§a50 §§§a60 §§§a70 §§§a80 §§§a90';
        $expected = ' §§§a10 §§§a20 §§§a30 §§§a40 §§§a50 §§§a60 §§§a70'.Constants::CRLF.' '.' §§§a80 §§§a90'.Constants::CRLF;
        $s->addItemToStream($item);
        $this->assertEquals($expected, $s->getStream());
    }
    
    public function testReset()
    {
        $s = new CalendarStream();
        $item = 'TEST';
        $s->addItemToStream($item);
        $s->reset();
        $this->assertEquals('', $s->getStream());
    }
    
    public function test__toString()
    {
        $s = new CalendarStream();
        $item = 'TEST';
        $s->addItemToStream($item);
        $expected = 'TEST'.Constants::CRLF;
        $this->assertEquals($expected, $s->__toString());
    }
}