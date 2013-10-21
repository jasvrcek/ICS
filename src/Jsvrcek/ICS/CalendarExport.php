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
            
            //calscale
            $this->stream->addItemToStream('CALSCALE:'.$cal->getCalendarScale());
            
            //method
            $this->stream->addItemToStream('METHOD:'.$cal->getMethod());
            
            //custom headers
            foreach ($cal->getCustomHeaders() as $key => $value)
            {
                $this->stream->addItemToStream($key.':'.$value);
            }
            
            //timezone
            $this->stream->addItemToStream('BEGIN:VTIMEZONE');
            
                $tz = $cal->getTimezone();
                $transitions = $tz->getTransitions(strtotime('1970-01-01'), strtotime('1970-12-31'));
                
                $daylightSavings = array(
                        'exists' => false,
                        'start' => '',
                        'offsetTo' => '',
                        'offsetFrom' => ''
                    );
                
                $standard = array(
                        'start' => '',
                        'offsetTo' => '',
                        'offsetFrom' => ''
                    );
                
                foreach ($transitions as $transition)
                {
                    $varName = ($transition['isdst']) ? 'daylightSavings' : 'standard';
                    
                    ${$varName}['exists'] = true;
                    ${$varName}['start'] = $this->getFormattedDateTime(new \DateTime($transition['time']));
                    
                    ${$varName}['offsetTo'] = $this->getFormattedTimeOffset($transition['offset']);
                    
                    //get previous offset
                    $previousTimezoneObservance = $transition['ts'] - 100;
                    $tzDate = new \DateTime('now', $tz);
                    $tzDate->setTimestamp($previousTimezoneObservance);
                    $offset = $tzDate->getOffset();
                    
                    ${$varName}['offsetFrom'] = $this->getFormattedTimeOffset($offset);
                }
                
                $this->stream->addItemToStream('TZID:'.$tz->getName());
                
                $this->stream->addItemToStream('BEGIN:STANDARD');
                    $this->stream->addItemToStream('DTSTART:'.$standard['start']);
                    $this->stream->addItemToStream('TZOFFSETTO:'.$standard['offsetTo']);
                    $this->stream->addItemToStream('TZOFFSETFROM:'.$standard['offsetFrom']);
                    
                    if ($daylightSavings['exists'])
                    {
                        $this->stream->addItemToStream('RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU');
                    }
                $this->stream->addItemToStream('END:STANDARD');
                
                if ($daylightSavings['exists'])
                {
                    $this->stream->addItemToStream('BEGIN:DAYLIGHT');
                        $this->stream->addItemToStream('DTSTART:'.$daylightSavings['start']);
                        $this->stream->addItemToStream('TZOFFSETTO:'.$daylightSavings['offsetTo']);
                        $this->stream->addItemToStream('TZOFFSETFROM:'.$daylightSavings['offsetFrom']);
                        $this->stream->addItemToStream('RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU');
                    $this->stream->addItemToStream('END:DAYLIGHT');
                }
            
            $this->stream->addItemToStream('END:VTIMEZONE');
            
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
        $prefix = '';
        
        if ($offset < 0)
            $prefix = '-';
        
        return $prefix.gmdate('Hi', abs($offset));
    }
}
