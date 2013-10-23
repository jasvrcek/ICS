<?php

namespace Jsvrcek\ICS\Utility;

class Formatter
{    
    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function getFormattedDateTime(\DateTime $dateTime)
    {
        return $dateTime->format('Ymd\THis');
    }
    
    /**
     * @param int $offset
     * @return string
     */
    public function getFormattedTimeOffset($offset)
    {
        $prefix = ($offset < 0) ? '-' : '+';
        
        return $prefix.gmdate('Hi', abs($offset));
    }
    
    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function getFormattedUTCDateTime(\DateTime $dateTime)
    {
        return $dateTime->setTimezone(new \DateTimeZone('UTC'))
                    ->format('Ymd\This\Z');
    }
    
    /**
     * converts email addresses into mailto: uri
     * @param string $uri
     * @return string
     */
    public function getFormattedUri($uri)
    {
        if (strpos($uri, '@') && stripos($uri, 'mailto:') === false)
            $uri = 'mailto:'.$uri;
        
        return $uri;
    }
    
}