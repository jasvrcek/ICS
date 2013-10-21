<?php

namespace Jsvrcek\ICS\Model;

use Jsvrcek\ICS\Model\CalendarAlarm;
use Jsvrcek\ICS\Exception\CalendarEventException;

class CalendarEvent
{
    /**
     * 
     * @var string $uid
     */
    private $uid;

    /**
     * 
     * @var \DateTime $start
     */
    private $start;

    /**
     * 
     * @var \DateTime $end
     */
    private $end;

    /**
     * 
     * @var string $summary
     */
    private $summary;

    /**
     * 
     * @var string $description
     */
    private $description;
    
    /**
     * 
     * @var array $alarms
     */
    private $alarms = array();

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     * @return CalendarEvent
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * also sets end time to 30 minutes after start as default<br>
     * - end time can be overridden with setEnd()
     * 
     * @param \DateTime $start
     * @return CalendarEvent
     */
    public function setStart(\DateTime $start)
    {
        $this->start = $start;
        $this->setEnd($start->add(new \DateInterval('P30M')));
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     * @return CalendarEvent
     */
    public function setEnd(\DateTime $end)
    {
        //check End is greater than Start
        if ($this->getStart() instanceof \DateTime)
        {
            if ($this->getStart() > $end)
                throw new CalendarEventException('End DateTime must be greater than Start DateTime');
        }
        else
        {
            throw new CalendarEventException('You must set the Start time before setting the End Time of a CalendarEvent');
        }
        
        $this->end = $end;
        return $this;
    }

    /**
     * @return the string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     * @return CalendarEvent
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return the string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return CalendarEvent
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * @return array $alarms returs array of CalendarAlarm objects
     */
    public function getAlarms()
    {
        return $this->alarms;
    }
    
    /**
     * @param CalendarAlarm $alarm
     * @return \Jsvrcek\ICS\Model\CalendarEvent
     */
    public function addAlarm(CalendarAlarm $alarm)
    {
        $this->alarms[] = $alarm;
        return $this;
    }
    
    /**
     * @param array $alarms
     * @return \Jsvrcek\ICS\Model\CalendarEvent
     */
    public function setAlarms(array $alarms)
    {
        $this->alarms = $alarms;
        return $this;
    }
}
