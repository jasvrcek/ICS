<?php

namespace Jsvrcek\ICS;

use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\CalendarStream;

class CalendarExport
{
    /**
     * 
     * @var array
     */
    private $calendars = array();
    
    /**
     * 
     * @var CalendarStream;
     */
    private $stream;
    
    public function __construct()
    {
        $this->stream = new CalendarStream();
    }

    /**
     * @return string
     */
    public function getStream()
    {
        $this->stream->reset();
        
        /* @var $cal Calendar */
        foreach ($this->getCalendars() as $cal)
        {
            //start calendar
            $this->stream->addItemToStream('BEGIN:VCALENDAR');
            $this->stream->addItemToStream('VERSION:2.0');
            
            //end calendar
            $this->stream->addItemToStream('END:VCALENDAR');
        }
        
        return $this->stream->getStream();
    }    
    

    /**
     * @return array
     */
    public function getCalendars()
    {
        return $this->calendars;
    }

    /**
     * @param array $calendars
     */
    public function setCalendars(array $calendars)
    {
        $this->calendars = $calendars;
    }

    /**
     * @param Calendar $cal
     */
    public function addCalendar(Calendar $cal)
    {
        $this->calendars[] = $cal;
    }
}
