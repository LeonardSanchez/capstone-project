
<?php
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/ticket.php");

// require the classes for poor man's dependency injection
require_once("../php/user.php");
require_once("../php/profile.php");
require_once("../php/event-category.php");
require_once("../php/venue.php");
require_once("../php/event.php");
require_once("../php/transaction.php");


// require mySQLI
require_once("/etc/apache2/capstone-mysql/rgevents.php");

// the TicketTest is a container for all our tests
class TicketTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli	= null;
	// variable to hold the test database row
	private $ticket	= null;

	// create state variables for the objects
	private $user				= null;
	private $profile			= null;
	private $eventCategory	= null;
	private $venue				= null;
	private $event				= null;
	private $transaction		= null;

	// setUp() is a method that is run before each test
	// connect to mySQL
	public function setUp() {
		$this->mysqli = MysqliConfiguration::getMysqli();

		// setup the objects, and enter all data fields from corresponding table

		$salt       	= bin2hex(openssl_random_pseudo_bytes(32));
		$authToken 		= bin2hex(openssl_random_pseudo_bytes(16));
		$passwordHash 	= hash_pbkdf2("sha512", "password", $salt, 2048, 128);
		$this->user 	= new User(null, "someemail@gmail.com", $passwordHash, $salt, $authToken);
		$this->user->insert($this->mysqli);

		$this->profile = new Profile(null, $this->user->getUserId(), "Bill", "Murray", "1972-05-21 12:00:00", "m");
		$this->profile->insert($this->mysqli);

		$this->transaction = new Transaction(null, $this->profile->getProfileId(), "20.00", "2014-11-15 12:00:00");
		$this->transaction->insert($this->mysqli);

		$this->venue	= new Venue(null, "The Place To Be", 500, "505-765-4321", "http://www.theplacetobe.com", "456 First Ave", null, "Albuquerque", "NM", "87109");
		$this->venue->insert($this->mysqli);

		$this->eventCategory	= new EventCategory(null, "concert");
		$this->eventCategory->insert($this->mysqli);

		$this->event	= new Event(null, $this->venue->getVenueId(), $this->eventCategory->getEventCategoryId(), "Creedence Clearwater Revival", "2014-12-12 12:00:00", "25.00");
		$this->event->insert($this->mysqli);

	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record
	public function tearDown() {
		// delete the ticket if we can
		// for the foreign keys MAKE SURE TO DELETE IN REVERSE ORDER!

		if($this->ticket !== null) {
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

		if($this->transaction !== null) {
			$this->transaction->delete($this->mysqli);
			$this->transaction = null;
		}

		if($this->profile !== null) {
			$this->profile->delete($this->mysqli);
			$this->profile = null;
		}

		if($this->user !== null) {
			$this->user->delete($this->mysqli);
			$this->user = null;
		}

		// tear down the objects
	}

	// test creating a new Ticket and inserting it to mySQL
	public function testInsertNewTicket() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->profile->getProfileId(), $this->event->getEventId(), $this->transaction->getTransactionId());

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->ticket->getTicketId());
		$this->assertTrue($this->ticket->getTicketId() > 0);
		$this->assertIdentical($this->ticket->getProfileId(),			$this->profile->getProfileId());
		$this->assertIdentical($this->ticket->getEventId(),			$this->event->getEventId());
		$this->assertIdentical($this->ticket->getTransactionId(),	$this->transaction->getTransactionId());
	}

	// test updating a Ticket in mySQL
	// Possibly delete the update method, question on the table is, in what scenario would you update a ticketId
	// Create second venue, insert it,
	public function testUpdateTicket() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->profile->getProfileId(), $this->event->getEventId(), $this->transaction->getTransactionId());

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// fourth, update the ticket and post the changes to mySQL
		$newEventId = "9999";
		$this->ticket->setEventId($newEventId);
		$this->ticket->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->ticket->getTicketId());
		$this->assertTrue($this->ticket->getTicketId() > 0);
		$this->assertIdentical($this->ticket->getProfileId(),			$this->profile->getProfileId());
		$this->assertIdentical($this->ticket->getEventId(),			$newEventId);
		$this->assertIdentical($this->ticket->getTransactionId(),	$this->transaction->getTransactionId());
	}

	// test deleting a Venue
	public function testDeleteTicket() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->profile->getProfileId(), $this->event->getEventId(), $this->transaction->getTransactionId());

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// fourth, verify the Ticket was inserted
		$this->assertNotNull($this->ticket->getTicketId());
		$this->assertTrue($this->ticket->getTicketId() > 0);

		// fifth, delete the ticket
		$this->ticket->delete($this->mysqli);
		$this->ticket = null;

		// finally, try to get the ticket and assert we didn't get a thing
		$hopefulTicket = Ticket::getTicketByTransactionId($this->mysqli, $this->transaction->getTransactionId());
		$this->assertNull($hopefulTicket);
	}

	// test grabbing a Ticket from mySQL
	public function testGetTicketByTransactionId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->profile->getProfileId(), $this->event->getEventId(), $this->transaction->getTransactionId());

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// fourth, get the venue using the static method
		$staticTicket = Venue::getTicketByTransactionId($this->mysqli, $this->transaction->getTransactionId());

		// finally, compare the fields
		$this->assertNotNull($staticTicket->getTicketId());
		$this->assertTrue($staticTicket->getTicketId() > 0);
		$this->assertIdentical($staticTicket->getTicketId(),			$this->ticket->getTicketId());
		$this->assertIdentical($staticTicket->getProfileId(),			$this->profile->getProfileId());
		$this->assertIdentical($staticTicket->getEventId(),			$this->event->getEventId());
		$this->assertIdentical($staticTicket->getTransactionId(),	$this->transaction->getTransactionId());
	}
	// write a static method for each foreign key

	// test grabbing a Ticket from mySQL
	public function testGetTicketByEventId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->profile->getProfileId(), $this->event->getEventId(), $this->transaction->getTransactionId());

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// fourth, get the venue using the static method
		$staticTicket = Venue::getTicketByEventId($this->mysqli, $this->event->getEventId());

		// finally, compare the fields
		$this->assertNotNull($staticTicket->getTicketId());
		$this->assertTrue($staticTicket->getTicketId() > 0);
		$this->assertIdentical($staticTicket->getTicketId(),			$this->ticket->getTicketId());
		$this->assertIdentical($staticTicket->getProfileId(),			$this->profile->getProfileId());
		$this->assertIdentical($staticTicket->getEventId(),			$this->event->getEventId());
		$this->assertIdentical($staticTicket->getTransactionId(),	$this->transaction->getTransactionId());
	}

	// test grabbing a Ticket from mySQL
	public function testGetTicketByProfileId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->profile->getProfileId(), $this->event->getEventId(), $this->transaction->getTransactionId());

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// fourth, get the venue using the static method
		$staticTicket = Venue::getTicketByProfileId($this->mysqli, $this->profile->getProfileId());

		// finally, compare the fields
		$this->assertNotNull($staticTicket->getTicketId());
		$this->assertTrue($staticTicket->getTicketId() > 0);
		$this->assertIdentical($staticTicket->getTicketId(),			$this->ticket->getTicketId());
		$this->assertIdentical($staticTicket->getProfileId(),			$this->profile->getProfileId());
		$this->assertIdentical($staticTicket->getEventId(),			$this->event->getEventId());
		$this->assertIdentical($staticTicket->getTransactionId(),	$this->transaction->getTransactionId());
	}
}
?>