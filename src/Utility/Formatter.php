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
                    ->format('Ymd\THis\Z');
    }

    /**
     * @param \DateTime $dateTime
     * @return string
     */
    public function getFormattedDate(\DateTime $dateTime)
    {
        return $dateTime->format('Ymd');
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

    /**
     * converts DateInterval object to string that can be used for a VALARM DURATION
     * @param \DateInterval $interval
     * @return string
     */
    public function getFormattedDateInterval(\DateInterval $interval)
    {
        $format = "P";

        if ($interval->y) { $format .= '%yY'; }
        if ($interval->m) { $format .= '%mM'; }
        if ($interval->d) { $format .= '%dD'; }

        if ($interval->h || $interval->i || $interval->s) {
            $format .= "T";
        }

        if ($interval->h) { $format .= '%hH'; }
        if ($interval->i) { $format .= '%iM'; }
        if ($interval->s) { $format .= '%sS'; }

        return $interval->format($format);
    }
}