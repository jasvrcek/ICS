[![Build status](https://travis-ci.org/jasvrcek/ICS.svg?branch=master)](https://travis-ci.org/jasvrcek/ICS)

ICS
===

Object-oriented php library for creating (and eventually reading) .ics iCal files.

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

## License

The MIT License (MIT)

Copyright (c) 2013 Justin Svrcek

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
