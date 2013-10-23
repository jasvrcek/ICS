ICS
===

Object-oriented php library for creating (and eventually reading) .ics iCal files

* This project does not yet support all functionality of the .ics format.

## Usage

	use Jsvrcek\ICS\Model\Calendar;
	use Jsvrcek\ICS\Model\CalendarEvent;
	use Jsvrcek\ICS\Model\Relationship\Attendee;
	use Jsvrcek\ICS\Model\Relationship\Organizer;
	
	use Jsvrcek\ICS\Utility\Formatter;
	use Jsvrcek\ICS\CalendarStream;
	use Jsvrcek\ICS\CalendarExport;
	
	//setup an event
	$eventOne = new CalendarEvent();
	$eventOne->setStart(new \DateTime())
		->setSummary('Family reunion')
		->setUid('event-uid');
		
	//add an Attendee
	$attendee = new Attendee(new Formatter());
	$attendee->setValue('moe@example.com')
		->setName('Moe Smith');
	$eventOne->addAttendee($attendee);
	
	//set the Organizer
	$organizer = new Organizer(new Formatter());
	$organizer->setValue('heidi@example.com')
		->setName('Heidi Merkell')
		->setLanguage('de');
	$eventOne->setOrganizer($organizer);
	
	//new event
	$eventTwo = new CalendarEvent();
	$eventTwo->setStart(new \DateTime())
		->setSummary('Dentist Appointment')
		->setUid('event-uid');
	
	//setup calendar
	$calendar = new Calendar();
	$calendar->setProdId('-//My Company//Cool Calendar App//EN')
		->addEvent($eventOne)
		->addEvent($eventTwo);
	
	//setup exporter
	$calendarExport = new CalendarExport(new CalendarStream, new Formatter());
	$calendarExport->addCalendar($calendar);
	
	//output .ics formatted text
	echo $calendarExport->getStream();

## Todos

* Jsvrcek\ICS\Model\CalendarAlarm
* Jsvrcek\ICS\Model\CalendarTodo

## Reference
 
 * http://tools.ietf.org/html/rfc5545