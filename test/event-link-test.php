<?php
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/event-link.php");

// require the classes for poor man's dependency injection
require_once("../php/event-category.php");
require_once("../php/venue.php");
require_once("../php/event.php");

// require mySQLI
require_once("/etc/apache2/capstone-mysql/rgevents.php");

// the TicketTest is a container for all our tests
class EventLinkTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli	= null;
	// variable to hold the test database row
	private $eventLink	= null;

	// create state variables for the objects
	private $eventCategory	= null;
	private $venue				= null;
	private $event				= null;

	// setUp() is a method that is run before each test
	// connect to mySQL
	public function setUp() {
		$this->mysqli = MysqliConfiguration::getMysqli();

		$this->EventLink = null;

		// setup the objects, and enter all data fields from corresponding table

		$this->venue	= new Venue(null, "That One Place", 150, "505-765-1234", "http://www.thatoneplace.com", "218 Central Ave", null, "Albuquerque", "NM", "87103");
		$this->venue->insert($this->mysqli);

		$this->eventCategory	= new EventCategory(null, "theatre");
		$this->eventCategory->insert($this->mysqli);

		$this->event	= new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(), "A Christmas Carol: Patrick Stewart One Man Show", "2014-12-19 12:30:00", 25.00);
		$this->event->insert($this->mysqli);

	}


// tearDown() is a method that is run after each test
	// here, we use it to delete the test record
	public function tearDown()
	{
		// delete the ticket if we can
		// for the foreign keys MAKE SURE TO DELETE IN REVERSE ORDER!

		if($this->eventLink !== null) {
			$this->eventLink->delete($this->mysqli);
			$this->eventLink = null;
		}


		if($this->event !== null) {
			$this->event->delete($this->mysqli);
			$this->event = null;
		}

		if($this->eventCategory !== null) {
			$this->eventCategory->delete($this->mysqli);
			$this->eventCategory = null;
		}

		if($this->venue !== null) {
			$this->venue->delete($this->mysqli);
			$this->venue = null;
		}
	}

		// test creating a new Ticket and inserting it to mySQL
		public function testInsertNewEventLink() {
			// first, verify mySQL connected OK
			$this->assertNotNull($this->mysqli);

			// second, create a ticket to post to mySQL
			$this->eventLink = new EventLink($this->eventCategory->getEventCategoryId(), $this->event->getEventId());
			// third, insert the ticket to mySQL
			$this->eventLink->insert($this->mysqli);

			// finally, compare the fields
			$this->assertIdentical($this->eventLink->getEventCategoryId(), $this->eventCategory->getEventCategoryId());
			$this->assertIdentical($this->eventLink->getEventId(), $this->event->getEventId());
		}
		// test deleting an EventLink
		public function testDeleteEventLink() {
			// first, verify mySQL connected OK
			$this->assertNotNull($this->mysqli);

			// second, create an eventLink to post to mySQL
			$this->eventLink = new EventLink($this->eventCategory->getEventCategoryId(), $this->event->getEventId());

			// third, insert the eventLik to mySQL
			$this->eventLink->insert($this->mysqli);

			// fourth, verify the eventLink was inserted
			$this->assertNotNull($this->eventCategory->getEventCategoryId());
			$this->assertTrue($this->eventCategory->getEventCategoryId() > 0);
			$this->assertNotNull($this->event->getEventId());
			$this->assertTrue($this->event->getEventId() > 0);

			// fifth, delete the eventLink
			$this->eventLink->delete($this->mysqli);
			$this->eventLink = null;

			// finally, try to get the eventLink and assert we didn't get a thing
			$hopefulEventLink = EventLink::getEventLinkByEventCategoryIdAndEventId($this->mysqli, $this->eventCategory->getEventCategoryId(), $this->event->getEventId());

			$this->assertNull($hopefulEventLink);
		}

	// test grabbing an EventLink from mySQL by EventId
	public function testGetEventLinkByEventId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second create an eventLink to post to mySQL
		$this->eventLink = new EventLink($this->eventCategory->getEventCategoryId(), $this->event->getEventId());

		// third, insert the eventLink to mySQL
		$this->eventLink->insert($this->mysqli);

		// fourth, get the eventLink using a static method
		$staticEventLink = EventLink::getEventLinkByEventId($this->mysqli, $this->event->getEventId());

		// finally compare the fields
		$this->assertIdentical($staticEventLink[0]->getEventCategoryId(),	$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEventLink[0]->getEventId(),			$this->event->getEventId());
	}

	// test grabbing an EventLink from mySQL by EventCategoryId
	public function testGetEventLinkByEventCategoryId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second create an eventLink to post to mySQL
		$this->eventLink = new EventLink($this->eventCategory->getEventCategoryId(), $this->event->getEventId());

		// third insert the eventLink to mySQL
		$this->eventLink->insert($this->mysqli);

		// fourth, get the eventLink using a static method
		$staticEventLink = EventLink::getEventLinkByEventCategoryId($this->mysqli, $this->eventCategory->getEventCategoryId());

		// finally, compare the fields
		$this->assertIdentical($staticEventLink[0]->getEventCategoryId(),		$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEventLink[0]->getEventId(),				$this->event->getEventId());
	}

	public function testGetEventLinkByEventCategoryIdAndEventId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create an eventLink to post to mySQL
		$this->eventLink = new EventLink($this->eventCategory->getEventCategoryId(), $this->event->getEventId());

		// third, insert the eventLink to mySQL
		$this->eventLink->insert($this->mysqli);

		// fourth, get the eventLink using a static method
		$staticEventLink = EventLink::getEventLinkByEventCategoryIdAndEventId($this->mysqli, $this->eventCategory->getEventCategoryId(), $this->event->getEventId());

		// finally, compare the fields
		$this->assertIdentical($staticEventLink[0]->getEventCategoryId(),		$this->eventCategory->getEventCategoryId());
		$this->assertIdentical($staticEventLink[0]->getEventId(),				$this->event->getEventId());
	}
}







