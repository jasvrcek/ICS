<?php

namespace Jsvrcek\ICS\Model;

use Jsvrcek\ICS\Model\Relationship\Attendee;
use Jsvrcek\ICS\Utility\Formatter;

/**
 * See http://icalendar.org/iCalendar-RFC-5545/3-6-6-alarm-component.html
 *
 * Class CalendarAlarm
 * @package Jsvrcek\ICS\Model
 */
class CalendarAlarm
{
    /**
     *
     * @var string $action
     */
     private $action;

    /**
     * RFC 5545 supports triggers relative to the parent VEVENT or VTODO, but Jsvrcek\ICS does not.
     * Only absolute trigger times are supported.
     * @todo Support RELATED, DTSTART, and DTEND.
     *
     * @var \DateTime $trigger
     */
    private $trigger;

    /**
     * For AUDIO and EMAIL actions only.
     * For AUDIO there must be exactly one attachment, which must point to a sound resource.
     * For EMAIL there can be any number of attachments, including zero.
     *
     * Should be a string including a path and a file type, like so:
     *
     *     "FMTTYPE=application/msword:http://example.com/agenda.doc"
     *
     * @var array $attachments
     */
    private $attachments = array();

    /**
     * For DISPLAY and EMAIL actions only. For EMAIL this is the body.
     *
     * @var string $description
     */
    private $description;

    /**
     * For EMAIL action only. This is the email subject.
     *
     * @var string $summary
     */
    private $summary;

    /**
     * For EMAIL action only. This is the email recipients.
     *
     * @var array $attendees
     */
    private $attendees = array();

    /**
     * For all actions. The number of times to repeat the alarm.
     * If REPEAT is set then DURATION must also be set.
     *
     * @var integer $repeat
     */
    private $repeat;

    /**
     * For all actions. The duration of the alarm.
     * If DURATION is set then REPEAT must also be set.
     *
     * @var \DateInterval $duration
     */
    private $duration;

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $action = strtoupper($action);
        $this->action = $action;
    }

    /**
     * @return \DateTime
     */
    public function getTrigger()
    {
        return $this->trigger;
    }

    /**
     * @param \DateTime $trigger
     */
    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @param string $attachment
     * @return CalendarAlarm
     */
    public function addAttachment($attachment)
    {
        $this->attachments[] = $attachment;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return array $attendees array of Attendee objects
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * @param array $attendees array of Attendee objects
     */
    public function setAttendees(array $attendees)
    {
        $this->attendees = $attendees;
    }

    /**
     * @param Attendee $attendee
     * @return CalendarAlarm
     */
    public function addAttendee(Attendee $attendee)
    {
        $this->attendees[] = $attendee;
        return $this;
    }

    /**
     * @return int
     */
    public function getRepeat()
    {
        return $this->repeat;
    }

    /**
     * @param int $repeat
     */
    public function setRepeat($repeat)
    {
        $this->repeat = $repeat;
    }

    /**
     * @return \DateInterval
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param \DateInterval $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
}
