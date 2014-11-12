<?php
//  require the SimpleTest
require_once("/usr/lib/php5/simpletest/autorun.php");

// require the class needing to be tested
//require_once("../php/user.php");

// the UserTest is a container for all our tests
class UserTest extends UnitTestCase
{
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $user = null;

	// a few variables for creating test data
	private $EMAIL = "unit-test@example.net";
	private $PASSWORD = "TRXLOVERS";
	private $SALT = null;
	private $AUTH_TOKEN = null;
	private $HASH = null;

	// public function is used to connect to mySQL and to calculate the salt, hash, and authenticationToken
	public function setUp()
	{
		// connect to mySQL
		mysqli_report(MYSQLI_REPORT_STRICT);
		$this->mysqli = new mysqli("localhost", "store_leo", "deepdive", "store_leo");

		// randomize the salt, hash, and authentication token
		$this->SALT = bin2hex(openssl_random_pseudo_bytes(32));
		$this->AUTH_TOKEN = bin2hex(openssl_random_pseudo_bytes(16));
		$this->HASH = hash_pbkdf2("sha512", $this->PASSWORD, $this->SALT, 2048, 128);
	}

	// tearDown()
	// use it to delete the test record and disconnect from mySQL
	public function tearDown()
	{
		// delete the user
		if($this->user !== null) {
			$this->user->delete($this->mysqli);
			$this->user = null;
		}
	}

}
?>
/**
 * Created by PhpStorm.
 * User: Leonard
 * Date: 11/12/2014
 * Time: 9:46 AM
 */ 