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
        $s->addItem($item);
        $this->assertEquals($expected, $s->getStream());
        
        //long string test
        $s = new CalendarStream();
        $item = ' aaaaaaa10 aaaaaaa20 aaaaaaa30 aaaaaaa40 aaaaaaa50 aaaaaaa60 aaaaaaa70 aaaaaaa80 aaaaaaa90';
        $expected = ' aaaaaaa10 aaaaaaa20 aaaaaaa30 aaaaaaa40 aaaaaaa50 aaaaaaa60 aaaaaaa70'.Constants::CRLF.' '.' aaaaaaa80 aaaaaaa90'.Constants::CRLF;
        $s->addItem($item);
        $this->assertEquals($expected, $s->getStream());
        
        //mb long string test
        $this->markTestIncomplete('Multi-byte test skipped for now');
        
        $s = new CalendarStream();
        $item = ' ἀἀἀa10 ἀἀἀa20 ἀἀἀa30 ἀἀἀa40 ἀἀἀa50 ἀἀἀa60 ἀἀἀa70 ἀἀἀa80 ἀἀἀa90';
        $expected = ' ἀἀἀa10 ἀἀἀa20 ἀἀἀa30 ἀἀἀa40 ἀἀἀa50 ἀἀἀa60 ἀἀἀa70'.Constants::CRLF.' '.' ἀἀἀa80 ἀἀἀa90'.Constants::CRLF;
        $s->addItem($item);
        
        //echo "\n'$expected'\n'".$s->getStream()."'\n";
        //exit;
        $this->assertEquals($expected, $s->getStream());
    }
    
    public function testReset()
    {
        $s = new CalendarStream();
        $item = 'TEST';
        $s->addItem($item);
        $s->reset();
        $this->assertEquals('', $s->getStream());
    }
    
    public function test__toString()
    {
        $s = new CalendarStream();
        $item = 'TEST';
        $s->addItem($item);
        $expected = 'TEST'.Constants::CRLF;
        $this->assertEquals($expected, $s->__toString());
    }
}