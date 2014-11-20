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
require_once("../php/profile.php");
require_once("../php/user.php");


require_once("/etc/apache2/capstone-mysql/rgevents.php");

// the TransactionTest is a container for all of our tests
class TransactionTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli      = null;
	// variable to hold the test database row
	private $transaction = null;

	// a few global variables for creating test data
	private $amount		 = "40.00";
	private $dateApproved = "2014-11-10 00:00:00";

	//create state variables for the objects
	private $user       = null;
	private $profile    = null;

	// now to create the setUp
	public function setUp() {
		//connect to mySQL
		$this->mysqli = MysqliConfiguration::getMysqli();

		// set up the objects, and enter all data fields from corresponding table
		$password      = "abc123";
		$email         = "email@gmail.com";
		$salt       	= bin2hex(openssl_random_pseudo_bytes(32));
		$authToken 		= bin2hex(openssl_random_pseudo_bytes(16));
		$passwordHash 	= hash_pbkdf2("sha512", $password, $salt, 2048, 128);
		$this->user 	= new User(null, $email, $passwordHash, $salt, $authToken);
		$this->user->insert($this->mysqli);

		$this->profile = new Profile(null, $this->user->getUserId(), "Jack", "Sparrow", "1972-06-05", "f");
		$this->profile->insert($this->mysqli);

	}

	// now for the tear down after each test
	public function tearDown() {
		if($this->transaction !== null){
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

		// no need to disconnect with new mysqliConfiguration class added YAY!
	}

	// test creating a new Transaction inserting it to mySQL
	public function testInsertNewTransaction() {
		// verify mySQL connected Ok
		$this->assertNotNull($this->mysqli);

		// now, create a transaction to post to mySQL
		$this->transaction = new Transaction(null, $this->amount, $this->dateApproved, $this->profile->getProfileId());

		// insert the transaction to mySQL
		$this->transaction->insert($this->mysqli);

		$testAmount = floatval($this->amount);
		$testDate = DateTime::createFromFormat('Y-m-d H:i:s',$this->dateApproved);

		// and now, compare the fields
		$this->assertNotNull($this->transaction->getTransactionId());
		$this->assertTrue($this->transaction->getTransactionId() > 0);
		$this->assertIdentical($this->transaction->getAmount(),				$testAmount);
		$this->assertIdentical($this->transaction->getDateApproved(),	   $testDate);
		$this->assertIdentical($this->transaction->getProfileId(),			$this->profile->getProfileId());

	 }

	// test updating a Transaction in mySQL
	public function testUpdateTransaction() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a transaction to post to mySQL
		$this->transaction = new Transaction(null, $this->amount, $this->dateApproved, $this->profile->getProfileId());

		// insert the transaction to mySQL
		$this->transaction->insert($this->mysqli);

		// update the transaction and post the changes to mySQL
		$newAmount = "30.00";
		$this->transaction->setAmount($newAmount);
		$this->transaction->update($this->mysqli);

		$testAmount = floatval($newAmount);
		$testDate = DateTime::createFromFormat('Y-m-d H:i:s',$this->dateApproved);

		// now, compare the fields
		$this->assertNotNull($this->transaction->getTransactionId());
		$this->assertTrue($this->transaction->getTransactionId() > 0);
		$this->assertIdentical($this->transaction->getAmount(),				$testAmount);
		$this->assertIdentical($this->transaction->getDateApproved(),	   $testDate);
		$this->assertIdentical($this->transaction->getProfileId(),			$this->profile->getProfileId());

	}

	// test deleting a transaction
	public function testDeleteTransaction() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a transaction to post to mySQL
		$this->transaction = new Transaction(null, $this->amount, $this->dateApproved, $this->profile->getProfileId());

		// insert the transaction to mySQL
		$this->transaction->insert($this->mysqli);

		// verify the transaction was inserted
		$this->assertNotNull($this->transaction->getTransactionId());
		$this->assertTrue($this->transaction->getTransactionId() > 0);

		// delete transaction
		$this->transaction->delete($this->mysqli);
		$this->transaction = null;

		// try to get the transaction and assert we didn't get a thing
		$hopefulTransaction = Transaction::getTransactionByProfileId($this->mysqli, $this->profile->getProfileId());
		$this->assertNull($hopefulTransaction);
	}

	// test grabbing a Transaction from mySQL
	public function testGetTransactionByProfileId() {
		// test mySQL connected ok
		$this->assertNotNull($this->mysqli);

		// create a transaction to post to mySQL
		$this->transaction = new Transaction(null, $this->amount, $this->dateApproved, $this->profile->getProfileId());

		// insert the transaction to mySQL
		$this->transaction->insert($this->mysqli);

		// get the transaction by using the static method
		$staticTransaction = Transaction::getTransactionByProfileId($this->mysqli, $this->profile->getProfileId());

		$testAmount = floatval($this->amount);
		$testDate = DateTime::createFromFormat('Y-m-d H:i:s',$this->dateApproved);

		// compare fields
		$this->assertNotNull($staticTransaction->getTransactionId());
		$this->assertTrue($staticTransaction->getTransactionId() > 0);
		$this->assertIdentical($staticTransaction->getTransactionId(),						$this->transaction->getTransactionId());
		$this->assertIdentical($staticTransaction->getAmount(),								$testAmount);
		$this->assertIdentical($staticTransaction->getDateApproved(),						$testDate);
		$this->assertIdentical($staticTransaction->getProfileId(),							$this->profile->getProfileId());
	}
}
?>