<?php
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/venue.php");

// require mySQLI
require_once("/etc/apache2/capstone-mysql/rgevents.php");

// the VenueTest is a container for all our tests
class VenueTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli	= null;
	// variable to hold the test database row
	private $venue		= null;

	// a few "global" variables for creating test data
	private $VENUE_NAME				= "Unit Test Ampitheatre";
	private $VENUE_CAPACITY			= 200;
	private $VENUE_PHONE				= "505-769-3522";
	private $VENUE_WEBSITE			= "http://www.kimotickets.com";
	private $VENUE_ADDRESS_1		= "421 Central Ave NW";
	private $VENUE_ADDRESS_2		= "";
	private $VENUE_CITY				= "Albuquerque";
	private $VENUE_STATE				= "NM";
	private $VENUE_ZIP_CODE			= "87102";

	// setUp() is a method that is run before each test
	// connect to mySQL
	public function setUp() {
		$this->mysqli = MysqliConfiguration::getMysqli();
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record
	public function tearDown() {
		// delete the venue if we can
		if($this->venue !== null) {
		$this->venue->delete($this->mysqli);
		$this->venue = null;
		}
	}

	// test creating a new Venue and inserting it to mySQL
	public function testInsertNewVenue() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a venue to post to mySQL
		$this->venue = new Venue(null, $this->VENUE_NAME, $this->VENUE_CAPACITY, $this->VENUE_PHONE, $this->VENUE_WEBSITE, $this->VENUE_ADDRESS_1, $this->VENUE_ADDRESS_2, $this->VENUE_CITY, $this->VENUE_STATE, $this->VENUE_ZIP_CODE);

		// third, insert the venue to mySQL
		$this->venue->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->venue->getVenueId());
		$this->assertTrue($this->venue->getVenueId() > 0);
		$this->assertIdentical($this->venue->getVenueName(),			$this->VENUE_NAME);
		$this->assertIdentical($this->venue->getVenueCapacity(),		$this->VENUE_CAPACITY);
		$this->assertIdentical($this->venue->getVenuePhone(),			$this->VENUE_PHONE);
		$this->assertIdentical($this->venue->getVenueWebsite(),		$this->VENUE_WEBSITE);
		$this->assertIdentical($this->venue->getVenueAddress1(),		$this->VENUE_ADDRESS_1);
		$this->assertIdentical($this->venue->getVenueAddress2(),		$this->VENUE_ADDRESS_2);
		$this->assertIdentical($this->venue->getVenueCity(),			$this->VENUE_CITY);
		$this->assertIdentical($this->venue->getVenueState(),			$this->VENUE_STATE);
		$this->assertIdentical($this->venue->getVenueZipCode(),		$this->VENUE_ZIP_CODE);
	}

	// test updating a Venue to post to mySQL
	public function testUpdateVenue() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a venue to post to mySQL
		$this->venue = new Venue(null, $this->VENUE_NAME, $this->VENUE_CAPACITY, $this->VENUE_PHONE, $this->VENUE_WEBSITE, $this->VENUE_ADDRESS_1, $this->VENUE_ADDRESS_2, $this->VENUE_CITY, $this->VENUE_STATE, $this->VENUE_ZIP_CODE);

		// third, insert the venue to mySQL
		$this->venue->insert($this->mysqli);

		// fourth, update the venue and post the changes to mySQL
		$newVenueZipCode = "87120";
		$this->venue->setVenueZipCode($newVenueZipCode);
		$this->venue->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->venue->getVenueId());
		$this->assertTrue($this->venue->getVenueId() > 0);
		$this->assertIdentical($this->venue->getVenueName(),			$this->VENUE_NAME);
		$this->assertIdentical($this->venue->getVenueCapacity(),		$this->VENUE_CAPACITY);
		$this->assertIdentical($this->venue->getVenuePhone(),			$this->VENUE_PHONE);
		$this->assertIdentical($this->venue->getVenueWebsite(),		$this->VENUE_WEBSITE);
		$this->assertIdentical($this->venue->getVenueAddress1(),		$this->VENUE_ADDRESS_1);
		$this->assertIdentical($this->venue->getVenueAddress2(),		$this->VENUE_ADDRESS_2);
		$this->assertIdentical($this->venue->getVenueCity(),			$this->VENUE_CITY);
		$this->assertIdentical($this->venue->getVenueState(),			$this->VENUE_STATE);
		$this->assertIdentical($this->venue->getVenueZipCode(),		$newVenueZipCode);
	}

	// test deleting a Venue
	public function testDeleteVenue() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a venue to post to mySQL
		$this->venue = new Venue(null, $this->VENUE_NAME, $this->VENUE_CAPACITY, $this->VENUE_PHONE, $this->VENUE_WEBSITE, $this->VENUE_ADDRESS_1, $this->VENUE_ADDRESS_2, $this->VENUE_CITY, $this->VENUE_STATE, $this->VENUE_ZIP_CODE);

		// third, insert the venue to mySQL
		$this->venue->insert($this->mysqli);

		// fourth, verify the Venue was inserted
		$this->assertNotNull($this->venue->getVenueId());
		$this->assertTrue($this->venue->getVenueId() > 0);

		// fifth, delete the venue
		$this->venue->delete($this->mysqli);
		$this->venue = null;

		// finally, try to get the venue and assert we didn't get a thing
		$hopefulVenue = Venue::getVenueByVenueName($this->mysqli, $this->VENUE_NAME);
		$this->assertNull($hopefulVenue);
	}

	// test grabbing a Venue from mySQL
	public function testGetVenueByVenueName() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a venue to post to mySQL
		$this->venue = new Venue(null, $this->VENUE_NAME, $this->VENUE_CAPACITY, $this->VENUE_PHONE, $this->VENUE_WEBSITE, $this->VENUE_ADDRESS_1, $this->VENUE_ADDRESS_2, $this->VENUE_CITY, $this->VENUE_STATE, $this->VENUE_ZIP_CODE);

		// third, insert the venue to mySQL
		$this->venue->insert($this->mysqli);

		// fourth, get the venue using the static method
		$staticVenue = Venue::getVenueByVenueName($this->mysqli, $this->VENUE_NAME);
		var_dump($staticVenue);

		// finally, compare the fields
		$this->assertNotNull($staticVenue->getVenueId());
		$this->assertTrue($staticVenue->getVenueId() > 0);
		$this->assertIdentical($staticVenue->getVenueId(),				$this->venue->getVenueId());
		$this->assertIdentical($staticVenue->getVenueName(),			$this->VENUE_NAME);
		$this->assertIdentical($staticVenue->getVenueCapacity(),		$this->VENUE_CAPACITY);
		$this->assertIdentical($staticVenue->getVenuePhone(),			$this->VENUE_PHONE);
		$this->assertIdentical($staticVenue->getVenueWebsite(),		$this->VENUE_WEBSITE);
		$this->assertIdentical($staticVenue->getVenueAddress1(),		$this->VENUE_ADDRESS_1);
		$this->assertIdentical($staticVenue->getVenueAddress2(),		$this->VENUE_ADDRESS_2);
		$this->assertIdentical($staticVenue->getVenueCity(),			$this->VENUE_CITY);
		$this->assertIdentical($staticVenue->getVenueState(),			$this->VENUE_STATE);
		$this->assertIdentical($staticVenue->getVenueZipCode(),		$this->VENUE_ZIP_CODE);
	}
}
?>