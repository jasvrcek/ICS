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
            $this->stream->addItemToStream('VERSION:'.$cal->getVersion());
            
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
     * @return CalendarExport
     */
    public function setCalendars(array $calendars)
    {
        $this->calendars = $calendars;
        return $this;
    }

    /**
     * @param Calendar $cal
     * @return CalendarExport
     */
    public function addCalendar(Calendar $cal)
    {
        $this->calendars[] = $cal;
        return $this;
    }
}
