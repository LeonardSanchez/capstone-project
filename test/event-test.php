<?php
/**
 * unit test for event.php
 *
 * Sebastian Sandoval <sbsandoval42@gmail.com>
 */
require_once("/usr/lib/php5/simpletest/autorun.php");

require_once("../php/event.php");

require_once("../php/venue.php");
require_once("../php/event-category.php");

require_once("/etc/apache2/capstone-mysql/rgevents.php");

class EventTest extends UnitTestCase	{
 // NEED comments regarding the state variables
	private $mysqli = null;
	private $event = null;


	private $EVENT_NAME			=	"Wobsky";
	private $EVENT_DATE_TIME	=	"2014-11-24 19:30:00";
	private $TICKET_PRICE		=	7000.00;

	private $venue				=	null;
	private $eventCategory	=	null;

	public function setUp()	{
		$this->mysqli = MysqliConfiguration::getMysqli();

		$this->venue = new Venue(null, "Swee Amphitheater", 150, "505-234-3456", "http://www.holdmyticket.com", "124 Central Ave NW", null,
			"Albuquerque", "NM", "87102");
		$this->venue->insert($this->mysqli);

		$this->eventCategory = new EventCategory(null, "Folk Dubstep");
		$this->eventCategory->insert($this->mysqli);
	}

	public function tearDown()	{
		if($this->event !== null)	{
			$this->event->delete($this->mysqli);
			$this->event = null;
		}

		if($this->eventCategory !== null)	{
			$this->eventCategory->delete($this->mysqli);
			$this->eventCategory = null;
		}

		if($this->venue !== null)	{
			$this->venue->delete($this->mysqli);
			$this->venue = null;
		}

	}

	public function testInsertNewEvent()	{
		$this->assertNotNull($this->mysqli);

		$this->event = new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);

		$this->event->insert($this->mysqli);

		$tempDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->EVENT_DATE_TIME);

		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);
		$this->assertIdentical($this->event->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($this->event->getEventCategoryId(), 	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($this->event->getEventName(), 			$this->EVENT_NAME);
		$this->assertIdentical($this->event->getEventDateTime(), 	$tempDate);
		$this->assertIdentical($this->event->getTicketPrice(), 		$this->TICKET_PRICE);
	}

	public function testUpdateUser()	{
		$this->assertNotNull($this->mysqli);

		$this->event = new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(), $this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);

		$this->event->insert($this->mysqli);

		$tempDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->EVENT_DATE_TIME);

		$newEventName = "Wub n' Fiddle";
		$this->event->setEventName($newEventName);
		$this->event->update($this->mysqli);

		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);
		$this->assertIdentical($this->event->getVenueId(), 			$this->venue->getVenueId());
		$this->assertIdentical($this->event->getEventCategoryId(), 	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($this->event->getEventName(), 			$newEventName);
		$this->assertIdentical($this->event->getEventDateTime(), 	$tempDate);
		$this->assertIdentical($this->event->getTicketPrice(), 		$this->TICKET_PRICE);
	}

	public function testDeleteUser()	{
		$this->assertNotNull($this->mysqli);

		$this->event = new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);

		$this->event->insert($this->mysqli);

		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);

		$this->event->delete($this->mysqli);
		$this->event = null;

		$hopefulEvent = Event::getEventByEventName($this->mysqli, $this->EVENT_NAME);
		$this->assertNull($hopefulEvent);
	}

	// test grabbing an Event from mySQL

	public function testGetEventByEventName() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create an event to post to mySQL
		$this->event = new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);

		// third, insert the event to mySQL
		$this->event->insert($this->mysqli);

		// fourth, get the event using the static method
		$staticEvent = Event::getEventByEventName($this->mysqli, $this->EVENT_NAME);
		var_dump($staticEvent);
		$tempDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->EVENT_DATE_TIME);

		// finally, compare the fields
		$this->assertNotNull($staticEvent->getEventId());
		$this->assertTrue($staticEvent->getEventId() > 0);
		$this->assertIdentical($staticEvent->getEventId(),				$this->event->getEventId());
		$this->assertIdentical($staticEvent->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($staticEvent->getEventCategoryId(),	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEvent->getEventName(),			$this->EVENT_NAME);
		$this->assertIdentical($staticEvent->getEventDateTime(),		$tempDate);
		$this->assertIdentical($staticEvent->getTicketPrice(),		$this->TICKET_PRICE);

	}

	public function testGetEventByEventDateTime()	{
		// verify mySQL connection
		$this->assertNotNull($this->mysqli);

		$testTime1 ="2014-11-24 17:30:00";
		$testTime1 = DateTime::createFromFormat("Y-m-d H:i:s", $testTime1);
		$testTime2 ="2014-11-25 19:30:00";
		$testTime2 = DateTime::createFromFormat("Y-m-d H:i:s", $testTime2);

		var_dump($testTime1, $testTime2);

		$searchTime1 = "2014-11-23";
		$searchTime1 = DateTime::createFromFormat("Y-m-d", $searchTime1);
		$searchTime2 = "2014-11-26";
		$searchTime2 = DateTime::createFromFormat("Y-m-d", $searchTime2);

		// create event to post to mySQL
		$this->event	=	new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);
		$this->event	=	new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(),
			$this->EVENT_NAME, $testTime1, $this->TICKET_PRICE);
		$this->event	=	new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(),
			$this->EVENT_NAME, $testTime2, $this->TICKET_PRICE);

		// insert event into mySQL
		$this->event->insert($this->mysqli);

		// get event using static method
		$staticEvent = Event::getEventByEventDateTime($this->mysqli, $searchTime1, $searchTime2);
		var_dump($staticEvent);
	}


}
?>