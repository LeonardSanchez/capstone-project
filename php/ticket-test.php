<?php
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/ticket.php");

// the TicketTest is a container for all our tests
class TicketTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli	= null;
	// variable to hold the test database row
	private $ticket	= null;

	// a few "global" variables for creating test data
	private $PROFILE_ID		= "?";
	private $EVENT_ID			= "?";
	private $TRANSACTION_ID	= "?";
	private $BARCODE_ID		= "?";

	// setUp() is a method that is run before each test
	// connect to mySQL
	public function setUp() {
		mysqli_report(MYSQLI_REPORT_STRICT);
		$this->mysqli = new mysqli("localhost", "rgevents", "gunny666happychance", "rgevents-dba");
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown() {
		// delete the ticket if we can
		if($this->ticket !== null) {
			$this->ticket->delete($this->mysqli);
			$this->ticket = null;
		}

		// disconnect from mySQL
		if($this->mysqli !== null) {
		}
	}

	// test creating a new Ticket and inserting it to mySQL
	public function testInsertNewTicket() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->PROFILE_ID, $this->EVENT_ID, $this->TRANSACTION_ID, $this->BARCODE_ID);

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->ticket->getTicketId());
		$this->assertTrue($this->ticket->getTicketId() > 0);
		$this->assertIdentical($this->ticket->getProfileId(),			$this->PROFILE_ID);
		$this->assertIdentical($this->ticket->getEventId(),			$this->EVENT_ID);
		$this->assertIdentical($this->ticket->getTransactionId(),	$this->TRANSACTION_ID);
		$this->assertIdentical($this->ticket->getBarcodeId(),			$this->BARCODE_ID);
	}

	// test updating a Ticket in mySQL
	public function testUpdateTicket() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->PROFILE_ID, $this->EVENT_ID, $this->TRANSACTION_ID, $this->BARCODE_ID);

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// fourth, update the ticket and post the changes to mySQL
		$newEventId = "9999";
		$this->ticket->setEventId($newEventId);
		$this->ticket->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->ticket->getTicketId());
		$this->assertTrue($this->ticket->getTicketId() > 0);
		$this->assertIdentical($this->ticket->getProfileId(),			$this->PROFILE_ID);
		$this->assertIdentical($this->ticket->getEventId(),			$newEventId);
		$this->assertIdentical($this->ticket->getTransactionId(),	$this->TRANSACTION_ID);
		$this->assertIdentical($this->ticket->getBarcodeId(),			$this->BARCODE_ID);
	}

	// test deleting a Venue
	public function testDeleteTicket() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->PROFILE_ID, $this->EVENT_ID, $this->TRANSACTION_ID, $this->BARCODE_ID);

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// fourth, verify the Ticket was inserted
		$this->assertNotNull($this->ticket->getTicketId());
		$this->assertTrue($this->ticket->getTicketId() > 0);

		// fifth, delete the ticket
		$this->ticket->delete($this->mysqli);
		$this->ticket = null;

		// finally, try to get the ticket and assert we didn't get a thing
		$hopefulTicket = Ticket::getTicketByTransactionId($this->mysqli, $this->TRANSACTION_ID);
		$this->assertNull($hopefulTicket);
	}

	// test grabbing a Ticket from mySQL
	public function testGetTicketByTransactionId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a ticket to post to mySQL
		$this->ticket = new Ticket(null, $this->PROFILE_ID, $this->EVENT_ID, $this->TRANSACTION_ID, $this->BARCODE_ID);

		// third, insert the ticket to mySQL
		$this->ticket->insert($this->mysqli);

		// fourth, get the venue using the static method
		$staticTicket = Venue::getTicketByTransactionId($this->mysqli, $this->TICKET_ID);

		// finally, compare the fields
		$this->assertNotNull($staticTicket->getTicketId());
		$this->assertTrue($staticTicket->getTicketId() > 0);
		$this->assertIdentical($staticTicket->getTicketId(),			$this->ticket->getTicketId());
		$this->assertIdentical($staticTicket->getProfileId(),			$this->PROFILE_ID);
		$this->assertIdentical($staticTicket->getEventId(),			$this->EVENT_ID;
		$this->assertIdentical($staticTicket->getTransactionId(),	$this->TRANSACTION_ID);
		$this->assertIdentical($staticTicket->getBarcodeId(),			$this->BARCODE_ID);
	}
}
?>