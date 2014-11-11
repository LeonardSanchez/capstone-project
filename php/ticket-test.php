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
	private $BARCODE			= "?";

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
}