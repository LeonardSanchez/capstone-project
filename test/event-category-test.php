<?php
/**
 *
 */
// first require the SimpleTest framework
require_once("/ust/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/event-category.php");

// require mySQLI
require_once("/etc/apache2/capstone-mysqli/regevents.php");

// the EventCategoryTest is a container for all our tests
class EventCategoryTest extends UnitTestCase {
	// variable to hold the test database row
	private  $mysqli 			= null;
	// variable to hold the test database row
	private $eventCategory	= null;

	// a few "global" variables for creating test data
	private $EVENT_CATEGORY	=  "Concert";

	// setUp() is a method that is run before each test
	// connect to mySQL
	public function setUp() {
		$this->mysqli = MysqliConfiguration::getMysqli();
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record
	public function tearDown() {
		// delete eventCategory if we can
		if($this->eventCategory !== null) {
			$this->eventCategory->delete($this->mysqli);
			$this->eventCategory = null;
		}
	}

	// test creating a new EventCategory and inserting it to mySQL
	public function  testInsertNewEventCategory() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a venue to post to mySQL
		$this->eventCategory = new EventCategory(null, $this->EVENT_CATEGORY);

		// third, insert the eventCategory to mySQL
		$this->eventCategory->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->eventCategory->getEventCategoryId());
		$this->assertTrue($this->eventCategory->getEventCategoryId() > 0);
		$this->assertIdentical($this->eventCategory->getEventCategory(),		$this->EVENT_CATEGORY);
	}

	// test updating an EventCategory to post to mySQL
	public function testUpdateEventCategory() {
		// first, verify mysQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create an eventCategory to post to mySQL
		$this->eventCategory = new EventCategory(null, $this->EVENT_CATEGORY);

		// third, insert the eventCategory to mySQL
		$this->eventCategory->insert($this->mysqli);

		// fourth, update the eventCategory and post the changes to mySQL
		$newEventCategory = "Sporting";
		$this->eventCategory->setEventCategory($newEventCategory);
		$this->eventCategory->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->eventCategory->getEventCategoryId());
		$this->assertTrue($this->eventCategory->getEventCategoryId() > 0);
		$this->assertIdentical($this->eventCategory->getEventCategory(),		$newEventCategory);
	}

	// test deleting an EventCategory
	public function testDeleteEventCategory() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create an eventCategory to post to mySQL
		$this->eventCategory = new EventCategory(null, $this->EVENT_CATEGORY);

		// third, insert the eventCategory to mySQL
		$this->eventCategory->insert($this->mysqli);

		// fourth, verify the EventCategory was inserted
		$this->assertNotNull($this->eventCategory->getEventCategoryId());
		$this->assertTrue($this->eventCategory->getEventCategoryId() > 0);

		// fifth, delete the eventCategory
		$this->eventCategory->delet($this->mysqli);
		$this->eventCategory = null;

		// finally, try to get the eventCategory and assert we didn't get a thing
		$hopefulEventCategory = EventCategory::getEventCategorybyEventCategory($this->mysqli, $this->EVENT_CATEGORY);
		$this->assertNull($hopefulEventCategory);
	}

	// test grabbing an eventCategory from mySQL
	public function testGetEventCategoryByEventCategory() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create an eventCategory to post to mySQL
		$this->eventCategory = new EventCategory(null, $this->EVENT_CATEGORY);

		// third, insert the eventCategory to mySQL
		$this->eventCategory->insert($this->mysqli);

		// fourth, get the eventCategory using the static method
		$staticEventCategory = EventCategory::getEventCategoryByEventCategory($this->mysqli, $this->EVENT_CATEGORY);

		// finally ,compare the fields
		$this->assertNotNull($staticEventCategory->getEventCategoryId());
		$this->assertTrue($staticEventCategory->getEventCategoryId() > 0);
		$this->assertIdentical($staticEventCategory->getEventCategory(),			$this->EVENT_CATEGORY);
	}

}