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

	private $mysqli = null;
	private $event = null;

	private $VENUE_ID				=	null;
	private $EVENT_CATEGORY_ID	=	null;
	private $EVENT_NAME			=	"Wobsky";
	private $EVENT_DATE_TIME	=	"2014-11-24 19:30:00";
	private $TICKET_PRICE		=	7000.00;

	private $venue				=	null;
	private $eventCategory	=	null;

	public function setUp()	{
		$this->mysqli = MysqliConfiguration::getMysqli();

		$this->venue = new Venue(null, "Swee", 3, "555-234-3456", "www.swee.com", "1 That St NW", null,
			"Albuquerque", "NM", "87651");
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

		$this->event = new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategory(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);

		$this->event->insert($this->mysqli);

		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);
		$this->assertIdentical($this->event->getVenueId(),	$this->venue->getVenueId());
		$this->assertIdentical($this->event->getEventCategoryId(), $this->venue->getEventCategoryId());
		$this->assertIdentical($this->event->getEventName(), $this->EVENT_NAME);
		$this->assertIdentical($this->event->getEventDateTime(), $this->EVENT_DATE_TIME);
		$this->assertIdentical($this->event->getTicketPrice(), $this->TICKET_PRICE);
	}

	public function testUpdateUser()	{
		$this->assertNotNull($this->mysqli);

		$this->event = new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategory(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);

		$this->event->insert($this->mysqli);

		$newEventName = "Wub n' Fiddle";
		$this->event->setEventName($newEventName);
		$this->event->update($this->mysqli);

		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);
		$this->assertIdentical($this->event->getVenueId(), $this->getVenueId());
		$this->assertIdentical($this->event->getEventCategoryId(), $this->getEventCategoryId());
		$this->assertIdentical($this->event->getEventName(), $this->$newEventName);
		$this->assertIdentical($this->event->getEventDateTime(), $this->EVENT_DATE_TIME);
		$this->assertIdentical($this->event->getTicketPrice(), $this->TICKET_PRICE);
	}

	public function testDeleteUser()	{
		$this->assertNotNull($this->mysqli);

		$this->event = new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategory(),
			$this->EVENT_NAME, $this->EVENT_DATE_TIME, $this->TICKET_PRICE);

		$this->event->insert($this->mysqli);

		$this->assertNotNull($this->event->getEventId());
		$this->assertTrue($this->event->getEventId() > 0);

		$this->event->delete($this->mysqli);
		$this->event = null;


	}

}