<?php

namespace Jsvrcek\ICS;

use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;
use Jsvrcek\ICS\Model\Description\Location;
use Jsvrcek\ICS\Model\Relationship\Attendee;
use Jsvrcek\ICS\Model\Relationship\Organizer;

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
            $this->stream->addItem('BEGIN:VCALENDAR')
                ->addItem('VERSION:'.$cal->getVersion())
                ->addItem('PRODID:'.$cal->getProdId())
                ->addItem('CALSCALE:'.$cal->getCalendarScale())
                ->addItem('METHOD:'.$cal->getMethod());
            
            //custom headers
            foreach ($cal->getCustomHeaders() as $key => $value)
            {
                $this->stream->addItem($key.':'.$value);
            }
            
            //timezone
            $this->stream->addItem('BEGIN:VTIMEZONE');
            
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
                
                $this->stream->addItem('TZID:'.$tz->getName());
                
                $this->stream->addItem('BEGIN:STANDARD')
                    ->addItem('DTSTART:'.$standard['start'])
                    ->addItem('TZOFFSETTO:'.$standard['offsetTo'])
                    ->addItem('TZOFFSETFROM:'.$standard['offsetFrom']);
                    
                    if ($daylightSavings['exists'])
                    {
                        $this->stream->addItem('RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU');
                    }
                $this->stream->addItem('END:STANDARD');
                
                if ($daylightSavings['exists'])
                {
                    $this->stream->addItem('BEGIN:DAYLIGHT')
                        ->addItem('DTSTART:'.$daylightSavings['start'])
                        ->addItem('TZOFFSETTO:'.$daylightSavings['offsetTo'])
                        ->addItem('TZOFFSETFROM:'.$daylightSavings['offsetFrom'])
                        ->addItem('RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU')
                    ->addItem('END:DAYLIGHT');
                }
            
            $this->stream->addItem('END:VTIMEZONE');
            
            //add events
            /* @var $event CalendarEvent */
            foreach ($cal->getEvents() as $event)
            {
                $this->stream->addItem('BEGIN:VEVENT')
                    ->addItem('UID:'.$event->getUid())
                    ->addItem('DTSTART:'.$this->getFormattedUTCDateTime($event->getStart()))
                    ->addItem('DTEND:'.$this->getFormattedUTCDateTime($event->getEnd()))
                    ->addItem('SUMMARY:'.$event->getSummary())
                    ->addItem('DESCRIPTION:'.$event->getDescription());
                
                    if ($event->getClass())
                        $this->stream->addItem('CLASS:'.$event->getClass());
                
                    /* @var $location Location */
                    foreach ($event->getLocations() as $location)
                    {
                        $this->stream
                            ->addItem('LOCATION'.$location->getUri().$location->getLanguage().':'.$location->getName());
                    }
                    
                    if ($event->getGeo())
                        $this->stream->addItem('GEO:'.$event->getGeo()->getLatitude().';'.$event->getGeo()->getLongitude());
                    
                    if ($event->getCreated())
                        $this->stream->addItem('CREATED:'.$this->getFormattedUTCDateTime($event->getCreated()));
                    
                    if ($event->getLastModified())
                        $this->stream->addItem('LAST-MODIFIED:'.$this->getFormattedUTCDateTime($event->getLastModified()));
                    
                    foreach ($event->getAttendees() as $attendee)
                    {
                        $this->stream->addItem($attendee->__toString());
                    }
                
                $this->stream->addItem('END:VEVENT');
            }
            
            //end calendar
            $this->stream->addItem('END:VCALENDAR');
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
}
