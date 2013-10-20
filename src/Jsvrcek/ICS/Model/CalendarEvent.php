<?php

namespace Jsvrcek\ICS\Model;
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

}
