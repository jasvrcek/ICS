ICS
===

Object-oriented php library for creating .ics iCal files

## Usage

	use Jsvrcek\ICS\Model\Calendar;
	use Jsvrcek\ICS\Model\CalendarEvent;
	
	use Jsvrcek\ICS\CalendarExport;
	
	$eventOne = new CalendarEvent();
	$eventOne->setStart(new \DateTime())
		->setSummary('Family reunion')
		->setUid('event-uid');
	
	$eventTwo = new CalendarEvent();
	$eventTwo->setStart(new \DateTime())
		->setSummary('Dentist Appointment')
		->setUid('event-uid');
	
	$calendar = new Calendar();
	$calendar->setProdId('-//My Company//Cool Calendar App//EN')
		->addEvent()
		->addEvent();
	
	$calendarExport = new CalendarExport();
	$calendarExport->addCalendar($calendar);
	
	//output .ics formatted text
	echo $calendarExport->getStream();