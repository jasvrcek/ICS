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
    public function addItem($item)
    {
        //get number of bytes
        $length = strlen($item);
        
        $block = '';
        
        if ($length > 75)
        {
            $start = 0;
            
            while ($start < $length)
            {
                $block .= mb_strcut($item, $start, self::LINE_LENGTH, 'UTF-8');
                $start = $start + self::LINE_LENGTH;
                
                //add space if not last line
                if ($start < $length) $block .= Constants::CRLF.' ';
            }
        }
        else
        {
            $block = $item;
        }
    
        $this->stream .= $block.Constants::CRLF;
        
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