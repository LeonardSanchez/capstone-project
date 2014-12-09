<?php
/**
 * unit test for event.php
 *
 * Sebastian Sandoval <sbsandoval42@gmail.com>
 */
require_once("/usr/lib/php5/simpletest/autorun.php");

require_once("../php/classes/event.php");

require_once("../php/classes/venue.php");
require_once("../php/classes/event-category.php");

require_once("/etc/apache2/capstone-mysql/rgevents.php");

class EventTest extends UnitTestCase	{
 	// mysqli pointer for connection and event object for testing
	private $mysqli = null;
	private $event = null;

	// test variables
	private $EVENT_NAME			=	"Wobsky";
	private $EVENT_DATE_TIME	=	"2014-11-24 19:30:00";
	private $TICKET_PRICE		=	7000.00;

	// objects for venue and eventCategory
	private $venue				=	null;
	private $eventCategory	=	null;
	// objects for multiple results on getEventByEventDateTime
	private $newEvent			=	null;
	private $newEvent1		=	null;

	/**
	 * setup
	 * venue for venueId
	 * eventCategory for eventCategoryId
	 * newEvent for testing
	 */
	public function setUp()	{
		$this->mysqli = MysqliConfiguration::getMysqli();

		$this->venue = new Venue(null, "Swee Amphitheater", 150, "505-234-3456", "http://www.holdmyticket.com", "124 Central Ave NW", null,
			"Albuquerque", "NM", "87102");
		$this->venue->insert($this->mysqli);

		$this->eventCategory = new EventCategory(null, "Folk Dubstep", null);
		$this->eventCategory->insert($this->mysqli);

		// converting to DateTime object
		$testTime1 ="2014-11-24 17:30:00";
		$testTime1 = DateTime::createFromFormat("Y-m-d H:i:s", $testTime1);
		$testTime2 ="2014-11-25 19:30:00";
		$testTime2 = DateTime::createFromFormat("Y-m-d H:i:s", $testTime2);

		$this->newEvent = new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(),
											"Wobble", $testTime1, 5000.00);
		$this->newEvent->insert($this->mysqli);
		$this->newEvent1	=	new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(),
												"Wobbie", $testTime2, 10.99);
		$this->newEvent1->insert($this->mysqli);
	}

	/**
	 * tearDown
	 *	reverse order
	 * event
	 * newEvent1
	 * newEvent
	 * eventCategory
	 * venue
	 */
	public function tearDown()	{
		if($this->event !== null)	{
			$this->event->delete($this->mysqli);
			$this->event = null;
		}

		if($this->newEvent1 !== null)	{
			$this->newEvent1->delete($this->mysqli);
			$this->newEvent1 = null;
		}

		if($this->newEvent !== null)	{
			$this->newEvent->delete($this->mysqli);
			$this->newEvent = null;
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

	// testInsertNewEvent
	public function testInsertNewEvent()	{
		// test connection
		$this->assertNotNull($this->mysqli);

		// create test object
		$this->event = new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);
		// insert test object
		$this->event->insert($this->mysqli);

		// create DateTime object
		$tempDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->EVENT_DATE_TIME);

		//run tests
		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);
		$this->assertIdentical($this->event->getEventCategoryId(), 	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($this->event->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($this->event->getEventName(), 			$this->EVENT_NAME);
		$this->assertIdentical($this->event->getEventDateTime(), 	$tempDate);
		$this->assertIdentical($this->event->getTicketPrice(), 		$this->TICKET_PRICE);
	}

	// test update event
	public function testUpdateEvent()	{
		// test mysqli connection
		$this->assertNotNull($this->mysqli);

		// setup test case
		$this->event = new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(), $this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);
		// insert test case
		$this->event->insert($this->mysqli);

		// create DateTime object
		$tempDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->EVENT_DATE_TIME);

		// get change
		$newEventName = "Wub n' Fiddle";
		$this->event->setEventName($newEventName);
		// update
		$this->event->update($this->mysqli);

		// run tests
		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);
		$this->assertIdentical($this->event->getEventCategoryId(), 	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($this->event->getVenueId(), 			$this->venue->getVenueId());
		$this->assertIdentical($this->event->getEventName(), 			$newEventName);
		$this->assertIdentical($this->event->getEventDateTime(), 	$tempDate);
		$this->assertIdentical($this->event->getTicketPrice(), 		$this->TICKET_PRICE);
	}

	// test delete event
	public function testDeleteEvent()	{
		// test mysqli connection
		$this->assertNotNull($this->mysqli);

		// setup test case
		$this->event = new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);
		// insert test case
		$this->event->insert($this->mysqli);

		// test insert passed
		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);

		// delete event
		$this->event->delete($this->mysqli);
		$this->event = null;

		// test if delete was successful
		$hopefulEvent = Event::getEventByEventName($this->mysqli, $this->EVENT_NAME);
		$this->assertNull($hopefulEvent);
	}

	// test grabbing an Event from mySQL

	public function testGetEventByEventName() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create an event to post to mySQL
		$this->event = new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);

		// third, insert the event to mySQL
		$this->event->insert($this->mysqli);

		// fourth, get the event using the static method
		$staticEvent = Event::getEventByEventName($this->mysqli, $this->EVENT_NAME);
		$tempDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->EVENT_DATE_TIME);

		// finally, compare the fields
		$this->assertNotNull($staticEvent[0]->getEventId());
		$this->assertTrue($staticEvent[0]->getEventId() > 0);
		$this->assertIdentical($staticEvent[0]->getEventId(),				$this->event->getEventId());
		$this->assertIdentical($staticEvent[0]->getEventCategoryId(),	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEvent[0]->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($staticEvent[0]->getEventName(),			$this->EVENT_NAME);
		$this->assertIdentical($staticEvent[0]->getEventDateTime(),		$tempDate);
		$this->assertIdentical($staticEvent[0]->getTicketPrice(),		$this->TICKET_PRICE);

	}

	public function testGetEventByEventDateTime()	{
		// verify mySQL connection
		$this->assertNotNull($this->mysqli);

		// create DateTime object
		$tempDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->EVENT_DATE_TIME);

		// create testing Date objects
		$searchTime1 = "2014-11-24";
		$searchTime1 = DateTime::createFromFormat("Y-m-d", $searchTime1);
		$searchTime2 = "2014-11-25";
		$searchTime2 = DateTime::createFromFormat("Y-m-d", $searchTime2);


		// create event to post to mySQL
		$this->event	=	new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(),
			$this->EVENT_NAME, $tempDate, $this->TICKET_PRICE);

		// insert event into mySQL
		$this->event->insert($this->mysqli);

		// get event using static method
		$staticEvent = Event::getEventByEventDateTime($this->mysqli, $searchTime1, $searchTime2);

		// test normal test case
		$this->assertNotNull($staticEvent[0]->getEventId());
		$this->assertTrue($staticEvent[0]->getEventId() > 0);
		$this->assertIdentical($staticEvent[0]->getEventId(),				$this->newEvent->getEventId());
		$this->assertIdentical($staticEvent[0]->getEventCategoryId(),	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEvent[0]->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($staticEvent[0]->getEventName(),			$this->newEvent->getEventName());
		$this->assertIdentical($staticEvent[0]->getEventDateTime(),		$this->newEvent->getEventDateTime());
		$this->assertIdentical($staticEvent[0]->getTicketPrice(),		$this->newEvent->getTicketPrice());

		// test newEvent
		$this->assertNotNull($staticEvent[1]->getEventId());
		$this->assertTrue($staticEvent[1]->getEventId() > 0);
		$this->assertIdentical($staticEvent[1]->getEventId(),				$this->newEvent1->getEventId());
		$this->assertIdentical($staticEvent[0]->getEventCategoryId(),	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEvent[1]->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($staticEvent[1]->getEventName(),			$this->newEvent1->getEventName());
		$this->assertIdentical($staticEvent[1]->getEventDateTime(),		$this->newEvent1->getEventDateTime());
		$this->assertIdentical($staticEvent[1]->getTicketPrice(),		$this->newEvent1->getTicketPrice());

		// test newEvent1
		$this->assertNotNull($staticEvent[2]->getEventId());
		$this->assertTrue($staticEvent[2]->getEventId() > 0);
		$this->assertIdentical($staticEvent[2]->getEventId(),				$this->event->getEventId());
		$this->assertIdentical($staticEvent[0]->getEventCategoryId(),	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEvent[2]->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($staticEvent[2]->getEventName(),			$this->EVENT_NAME);
		$this->assertIdentical($staticEvent[2]->getEventDateTime(),		$tempDate);
		$this->assertIdentical($staticEvent[2]->getTicketPrice(),		$this->TICKET_PRICE);
	}

	public function testGetEventByEventId()	{
		// verify mysqli connection
		$this->assertNotNull($this->mysqli);

		// create date time object
		$tempDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->EVENT_DATE_TIME);

		// create event to post to mySQL
		$this->event	=	new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(),
			$this->EVENT_NAME, $tempDate, $this->TICKET_PRICE);

		$this->event->insert($this->mysqli);

		$staticEvent	=	Event::getEventByEventId($this->mysqli, $this->event->getEventId());

		$this->assertNotNull($staticEvent[0]->getEventId());
		$this->assertTrue($staticEvent[0]->getEventId() > 0);
		$this->assertIdentical($staticEvent[0]->getEventId(),				$this->event->getEventId());
		$this->assertIdentical($staticEvent[0]->getEventCategoryId(),	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEvent[0]->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($staticEvent[0]->getEventName(),			$this->EVENT_NAME);
		$this->assertIdentical($staticEvent[0]->getEventDateTime(),		$tempDate);
		$this->assertIdentical($staticEvent[0]->getTicketPrice(),		$this->TICKET_PRICE);
	}

}
?>