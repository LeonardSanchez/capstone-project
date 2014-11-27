<?php
/**
 * Unit test for barcode
 *
 * @author Brendan Slevin
 **/

// lets start by requiring the simple test framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// next, require the class to be tested and others that the class is dependent upon
require_once("../php/user.php");
require_once("../php/profile.php");
require_once("../php/venue.php");
require_once("../php/event-category.php");
require_once("../php/event.php");
require_once("../php/ticket.php");
require_once("../php/barcode.php");

// centralized mySQL configuration class
require_once("/etc/apache2/capstone-mysql/rgevents.php");

// the BarcodeTest is a container for all of our tests
class BarcodeTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $barcode = null;

	// create state variables for creating test data
	private $user          = null;
	private $profile       = null;
	private $venue         = null;
	private $eventCategory = null;
	private $event         = null;
	private $ticket		  = null;

	// now to create the setUp
	public function setUp()
	{
		//connect to mySQL
		$this->mysqli = MysqliConfiguration::getMysqli();

		// time to create the objects from the foreign key paths
		$password = "abc1234";
		$email = "email5@gmail.com";
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$authToken = bin2hex(openssl_random_pseudo_bytes(16));
		$passwordHash = hash_pbkdf2("sha512", $password, $salt, 2048, 128);
		$this->user = new User(null, $email, $passwordHash, $salt, $authToken);
		$this->user->insert($this->mysqli);

		$this->profile = new Profile(null, $this->user->getUserId(), "Brendan", "Slevin", "1987-11-07", "m");
		$this->profile->insert($this->mysqli);

		$this->venue = new Venue(null, "SunshineTheater", 10, "505-505-5055", "http://www.sunshine.com", "128 Central ave", "Apt 212", "Albuquerque", "NM", "87108");
		$this->venue->insert($this->mysqli);

		$this->eventCategory = new EventCategory(null, "rock");
		$this->eventCategory->insert($this->mysqli);

		$this->event = new Event(null, $this->eventCategory->getEventCategoryId(), $this->venue->getVenueId(), "New Event", "2014-01-01 07:07:07", 17.00);
		$this->event->insert($this->mysqli);

		$this->ticket = new Ticket(null, $this->profile->getProfileId(), $this->event->getEventId());
		$this->ticket->insert($this->mysqli);
	}

	// now for the tear down after each test
	public function tearDown() {
		if($this->barcode !== null){
			$this->barcode->delete($this->mysqli);
			$this->barcode = null;
		}

		if($this->ticket !== null){
			$this->ticket->delete($this->mysqli);
			$this->ticket = null;
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

		if($this->profile !== null) {
			$this->profile->delete($this->mysqli);
			$this->profile = null;
		}

		if($this->user !== null) {
			$this->user->delete($this->mysqli);
			$this->user = null;
		}

		// no need to disconnect with new mysqliConfiguration class added YAY!
	}

	// test creating a new Barcode inserting it to mySQL
	public function testInsertNewBarcode() {
		// verify mySQL connected Ok
		$this->assertNotNull($this->mysqli);

		// now, create a Barcode to post to mySQL
		$this->barcode = new Barcode(null, $this->ticket->getTicketId());

		// insert the Barcode to mySQL
		$this->barcode->insert($this->mysqli);

		// and now, compare the fields
		$this->assertNotNull($this->barcode->getBarcodeId());
		$this->assertTrue($this->barcode->getBarcodeId() > 0);
		$this->assertIdentical($this->barcode->getTicketId(),				$this->ticket->getTicketId());
	}

	// test updating a Barcode in mySQL
	public function testUpdateBarcode() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a Barcode to post to mySQL
		$this->barcode = new Barcode(null, $this->ticket->getTicketId());

		// insert the Barcode to mySQL
		$this->barcode->insert($this->mysqli);

		// update the Barcode and post the changes to mySQL
		$newTicketTest = new Ticket(null, $this->profile->getProfileId(), $this->event->getEventId());
		$newTicketTest->insert($this->mysqli);
		$this->barcode->setTicketId($newTicketTest->getTicketId());
		$this->barcode->update($this->mysqli);

		// now, compare the fields
		$this->assertNotNull($this->barcode->getBarcodeId());
		$this->assertTrue($this->barcode->getBarcodeId() > 0);
		$this->assertIdentical($this->barcode->getTicketId(),				$newTicketTest->getTicketId());

		$this->barcode->delete($this->mysqli);
		$newTicketTest->delete($this->mysqli);

	}

	// test deleting a Barcode
	public function testDeleteBarcode() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a Barcode to post to mySQL
		$this->barcode = new Barcode(null, $this->ticket->getTicketId());

		// insert the Barcode to mySQL
		$this->barcode->insert($this->mysqli);

		// verify the Barcode was inserted
		$this->assertNotNull($this->barcode->getBarcodeId());
		$this->assertTrue($this->barcode->getBarcodeId() > 0);

		// delete Barcode
		$this->barcode->delete($this->mysqli);
		$this->barcode = null;

		// try to get the Barcode and assert we didn't get a thing
		$hopefulBarcode = Barcode::getBarcodeByTicketId($this->mysqli, $this->ticket->getTicketId());
		$this->assertNull($hopefulBarcode);
	}

	// test grabbing a Barcode from mySQL
	public function testGetBarcodeByTicketId() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a Barcode to post to mySQL
		$this->barcode = new Barcode(null, $this->ticket->getTicketId());

		// insert the Barcode to mySQL
		$this->barcode->insert($this->mysqli);

		// get the Barcode by using the static method
		$staticBarcode = Barcode::getBarcodeByTicketId($this->mysqli, $this->ticket->getTicketId());

		// compare fields
		$this->assertNotNull($staticBarcode->getBarcodeId());
		$this->assertTrue($staticBarcode->getBarcodeId() > 0);
		$this->assertIdentical($staticBarcode->getBarcodeId(),						  $this->barcode->getBarcodeId());
		$this->assertIdentical($staticBarcode->getTicketId(),                     $this->ticket->getTicketId());
	}
}
?>