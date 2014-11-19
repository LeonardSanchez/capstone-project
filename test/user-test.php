<?php

// THIS HAS PASSED UNIT TEST AGAIN ON 2014-11-17 22:33:00 MST

// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");
// then require the class under scrutiny
require_once("../php/user.php");
// require mySQLI
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// the UserTest is a container for all our tests
class UserTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $user   = null;
	// a few "global" variables for creating test data
	private $EMAIL      = "unit-test@example.net";
	private $PASSWORD  = "ChedGeek5";
	private $SALT       = null;
	private $AUTHTOKEN = null;
	private $HASH       = null;
	// setUp() is a method that is run before each test
	// here, we use it to connect to mySQL and to calculate the salt, hash, and authenticationToken
	public function setUp() {
		// connect to mySQL
		$this->mysqli = MysqliConfiguration::getMysqli();
		// randomize the salt, hash, and authentication token
		$this->SALT       = bin2hex(openssl_random_pseudo_bytes(32));
		$this->AUTHTOKEN = bin2hex(openssl_random_pseudo_bytes(16));
		$this->HASH       = hash_pbkdf2("sha512", $this->PASSWORD, $this->SALT, 2048, 128);
	}
	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown() {
		// delete the user if we can
	if($this->user !== null) {
			$this->user->delete($this->mysqli);
			$this->user = null;
		}
	}
	// test creating a new User and inserting it to mySQL
	public function testInsertNewUser() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);
		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHTOKEN);
		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);
		// finally, compare the fields
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);
		$this->assertIdentical($this->user->getEmail(),				$this->EMAIL);
		$this->assertIdentical($this->user->getPasswordHash(),	$this->HASH);
		$this->assertIdentical($this->user->getSalt(),				$this->SALT);
		$this->assertIdentical($this->user->getAuthToken(),		$this->AUTHTOKEN);
	}
	// test updating a User in mySQL
	public function testUpdateUser() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);
		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHTOKEN);
		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);
		// fourth, update the user and post the changes to mySQL
		$newEmail = "jake@cortez.org.mx";
		$this->user->setEmail($newEmail);
		$this->user->update($this->mysqli);
		// finally, compare the fields
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);
		$this->assertIdentical($this->user->getEmail(),               	$newEmail);
		$this->assertIdentical($this->user->getPasswordHash(),			$this->HASH);
		$this->assertIdentical($this->user->getSalt(),                	$this->SALT);
		$this->assertIdentical($this->user->getAuthToken(),				$this->AUTHTOKEN);
	}
	// test deleting a User
	public function testDeleteUser() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);
		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHTOKEN);
		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);
		// fourth, verify the User was inserted
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);
		// fifth, delete the user
		$this->user->delete($this->mysqli);
		$this->user = null;
		// finally, try to get the user and assert we didn't get a thing
		$hopefulUser = User::getUserByEmail($this->mysqli, $this->EMAIL);
		$this->assertNull($hopefulUser);
	}
	// test grabbing a User from mySQL
	public function testGetUserByEmail() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);
		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHTOKEN);
		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);
		// fourth, get the user using the static method
		$staticUser = User::getUserByEmail($this->mysqli, $this->EMAIL);
		// finally, compare the fields
		$this->assertNotNull($staticUser->getUserId());
		$this->assertTrue($staticUser->getUserId() > 0);
		$this->assertIdentical($staticUser->getUserId(),					$this->user->getUserId());
		$this->assertIdentical($staticUser->getEmail(),             	$this->EMAIL);
		$this->assertIdentical($staticUser->getPasswordHash(),			$this->HASH);
		$this->assertIdentical($staticUser->getSalt(),						$this->SALT);
		$this->assertIdentical($staticUser->getAuthToken(),				$this->AUTHTOKEN);
	}
}
?>