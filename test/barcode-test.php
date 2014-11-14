<?php
/**
 * Unit test for barcode
 *
 * @author Brendan Slevin
 **/

// lets start by requiring the simple test framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// next, require the class to be tested
require_once("../php/barcode.php");

require_once("/etc/apache2/capstone-mysql/rgevents.php");

// the barcodeTest is a container for all of our tests
class BarcodeTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $barcode = null;

	// a global variable for creating test data
	private $ticketId		 = 1;

	// now to create the setUp
	public function setUp() {
		//connect to mySQL
		$this->mysqli = MysqliConfiguration::getMysqli();

		// no need to randomize anything
	}

	// now for the tear down after each test
	public function tearDown() {
		if($this->barcode !== null){
			$this->barcode->delete($this->mysqli);
			$this->barcode = null;
		}

		// no need to disconnect with new mysqliConfiguration class added YAY!
	}

	// test creating a new barcode inserting it to mySQL
	public function testInsertNewBarcode() {
		// verify mySQL connected Ok
		$this->assertNotNull($this->mysqli);

		// now, create a barcode to post to mySQL
		$this->barcode = new Barcode(null, $this->ticketId);

		// insert the barcode to mySQL
		$this->barcode->insert($this->mysqli);

		// and now, compare the fields
		$this->assertNotNull($this->barcode->getBarcodeId());
		$this->assertTrue($this->barcode->getBarcodeId() > 0);
		$this->assertIdentical($this->barcode->getTicketId(),				$this->ticketId);
	}

	// test updating a barcode in mySQL
	public function testUpdateBarcode() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a barcode to post to mySQL
		$this->barcode = new Barcode(null, $this->ticketId);

		// insert the barcode to mySQL
		$this->barcode->insert($this->mysqli);

		// update the barcode and post the changes to mySQL
		$newTicketId = 1;
		$this->barcode->setTicketId($newTicketId);
		$this->barcode->update($this->mysqli);

		// now, compare the fields
		$this->assertNotNull($this->barcode->getBarcodeId());
		$this->assertTrue($this->barcode->getBarcodeId() > 0);
		$this->assertIdentical($this->barcode->getTicketId(),				$newTicketId);

	}

	// test deleting a barcode
	public function testDeleteBarcode() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a barcode to post to mySQL
		$this->barcode = new Barcode(null, $this->ticketId);

		// insert the barcode to mySQL
		$this->barcode->insert($this->mysqli);

		// verify the barcode was inserted
		$this->assertNotNull($this->barcode->getBarcodeId());
		$this->assertTrue($this->barcode->getBarcodeId() > 0);

		// delete barcode
		$this->barcode->delete($this->mysqli);
		$this->barcode = null;

		// try to get the barcode and assert we didn't get a thing
		$hopefulBarcode = Barcode::getBarcodeByTicketId($this->mysqli, $this->ticketId);
		$this->assertNull($hopefulBarcode);
	}
}
?>