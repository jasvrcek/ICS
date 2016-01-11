<?php

namespace Jsvrcek\ICS;

use Jsvrcek\ICS\Constants;

class CalendarStream
{
    //length of line in bytes
    const LINE_LENGTH = 70;
    
    
    /**
     * 
     * @var string
     */
    private $stream = '';
    
    /**
     * resets stream to blank string
     */
    public function reset()
    {
        $this->stream = '';
    }
    
    /**
     * @return string
     */
    public function getStream()
    {
        return $this->stream;
    }
    
    /**
     * splits item into new lines if necessary
     * @param string $item
     * @return CalendarStream
     */
    public function addItem($item);
    {
	$line_breaks=array("\r\n","\n", "\r");
	$item=str_replace($line_breaks,'\n',$item);
        $this->stream .= wordwrap($item,70,Constants::CRLF.' ',true).Constants::CRLF;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getStream();
    }
}
