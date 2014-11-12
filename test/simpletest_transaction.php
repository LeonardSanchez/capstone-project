<?php
/**
 * This is a simple test for the transaction class
 *
 * @author Brendan Slevin
 **/

// lets start by requiring the simple test framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// next, require the class to be tested
require_once("../php/transaction.php");

require_once("/etc/apache2/capstone-mysql/rgevents.php");

// the TransactionTest is a container for all of our tests
class TransactionTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli      = null;
	// variable to hold the test database row
	private $transaction = null;

	// a few global variables for creating test data
	private $amount		 = "40.00";
	private $dateApproved = "11/10/2014";
	private $profileId    = 1;

	// now to create the setUp
	public function setUp() {
		//connect to mySQL
		$this->mysqli = MysqliConfiguration::getMysqli();


		// no need to randomize anything
	}

	// now for the tear down after each test
	public function tearDown() {
		if($this->transaction !== null){
			$this->transaction->delete($this->mysqli);
			$this->transaction = null;
		}

		// no need to disconnect with new mysqliConfiguration class added YAY!
	}

	// test creating a new Transaction inserting it to mySQL
	public function testInsertNewTransaction() {
		// verify mySQL connected Ok
		$this->assertNotNull($this->mysqli);

		// now, create a transaction to post to mySQL
		$this->transaction = new Transaction(null, $this->amount, $this->dateApproved, $this->profileId);

		// insert the transaction to mySQL
		$this->transaction->insert($this->mysqli);

		// and now, compare the fields
		$this->assertNotNull($this->transaction->getTransactionId());
		$this->assertTrue($this->transaction->getTransactionId() > 0);
		$this->assertIdentical($this->transaction->getAmount(),				$this->amount);
		$this->assertIdentical($this->transaction->getDateApproved(),	   $this->dateApproved);
		$this->assertIdentical($this->transaction->getProfileId(),			$this->profileId);
	}

	// test updating a Transaction in mySQL
	public function testUpdateTransaction() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a transaction to post to mySQL
		$this->transaction = new Transaction(null, $this->amount, $this->dateApproved, $this->profileId);

		// insert the transaction to mySQL
		$this->transaction->insert($this->mysqli);

		// update the transaction and post the changes to mySQL
		$newAmount = "40.00";
		$this->transaction->setAmount($newAmount);
		$this->transaction->update($this->mysqli);

		// now, compare the fields
		$this->assertNotNull($this->transaction->getTransactionId());
		$this->assertTrue($this->transaction->getTransactionId() > 0);
		$this->assertIdentical($this->transaction->getAmount(),				$newAmount);
		$this->assertIdentical($this->transaction->getDateApproved(),	   $this->dateApproved);
		$this->assertIdentical($this->transaction->getProfileId(),			$this->profileId);

	}

	// test deleting a transaction
	public function testDeleteTransaction() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a transaction to post to mySQL
		$this->transaction = new Transaction(null, $this->amount, $this->dateApproved, $this->profileId);

		// insert the transaction to mySQL
		$this->transaction->insert($this->mysqli);

		// verify the transaction was inserted
		$this->assertNotNull($this->transaction->getTransactionId());
		$this->assertTrue($this->transaction->getTransactionId() > 0);

		// delete transaction
		$this->transaction->delete($this->mysqli);
		$this->transaction = null;

		// try to get the transaction and assert we didn't get a thing
		$hopefulTransaction = Transaction::getTransactionByProfileId($this->mysqli, $this->profileId);
		$this->assertNull($hopefulTransaction);
	}

	// test grabbing a Transaction from mySQL
	public function testGetTransactionByProfileId() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a transaction to post to mySQL
		$this->transaction = new Transaction(null, $this->amount, $this->dateApproved, $this->profileId);

		// insert the transaction to mySQL
		$this->transaction->insert($this->mysqli);

		// get the transaction by using the static method
		$staticTransaction = Transaction::getTransactionByProfileId($this->mysqli, $this->profileId);

		// compare fields
		$this->assertNotNull($staticTransaction->getTransactionId());
		$this->assertTrue($staticTransaction->getTransactionId() > 0);
		$this->assertIdentical($staticTransaction->getTransactionId(),						$this->transaction->getTransactionId());
		$this->assertIdentical($staticTransaction->getAmount(),								$this->amount);
		$this->assertIdentical($staticTransaction->getDateApproved(),						$this->dateApproved);
		$this->assertIdentical($staticTransaction->getProfileId(),							$this->profileId);
	}
}
?>