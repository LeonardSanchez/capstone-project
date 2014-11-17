<?php
/** this is our simple test for user
 * created By Leonard Sanchez <suavelen69@gmail.com>, <leonard@cnm.edu>*/
//  require the SimpleTest
require_once("/usr/lib/php5/simpletest/autorun.php");
// require the class being tested

require_once("../php/user.php");
/** require mysqli */
require_once("/etc/apache2/capstone-mysql/rgevents.php");

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
		$this->mysqli = new mysqli("localhost", "store_dylan", "deepdive", "store_dylan");

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

	// test creating a new User id and inserting it to mySQL
	public function testInsertNewUserId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user id to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the user id to mySQL
		$this->user->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull  ($this->userId->getUserId());
		$this->assertTrue     ($this->userId->getUserId() > 0);
		$this->assertIdentical($this->userId->getFirstName(),               $this->EMAIL);
		$this->assertIdentical($this->userId->getLastName(),            $this->HASH);
		$this->assertIdentical($this->userId->getDateOfBirth(),                $this->SALT);
		$this->assertIdentical($this->userId->getGender(), $this->AUTH_TOKEN);
	}

	// test updating a User id in mySQL
	public function testUpdateUserId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user id to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the user id to mySQL
		$this->user->insert($this->mysqli);

		// fourth, update the user id and post the changes to mySQL
		$newEmail = "leonard@cnm.edu";
		$this->user->setEmail($newEmail);
		$this->user->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull  ($this->userId->getUserId());
		$this->assertTrue     ($this->userId->getUserId() > 0);
		$this->assertIdentical($this->userId->getFirstName(),           $newEmail);
		$this->assertIdentical($this->userId->getLastName(),            $this->HASH);
		$this->assertIdentical($this->userId->getDateOfBirth(),                $this->SALT);
		$this->assertIdentical($this->userId->getGender(), $this->AUTH_TOKEN);
	}

	// test deleting a User id
	public function testDeleteUserId() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user id to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the user id to mySQL
		$this->user->insert($this->mysqli);

		// fourth, verify the User Id was inserted
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);

		// fifth, delete the user id
		$this->user->delete($this->mysqli);
		$this->user = null;

		// finally, try to get the user id and assert we didn't get a thing
		$hopefulUserId = User::getUserByEmail($this->mysqli, $this->EMAIL);
		$this->assertNull($hopefulUserId);
	}

	// test grabbing a User id from mySQL
	public function testGetUserIdByEmail() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user id to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the user id to mySQL
		$this->user->insert($this->mysqli);

		// fourth, get the user id using the static method
		$staticUser = User::getUserByEmail($this->mysqli, $this->EMAIL);

		// finally, compare the fields
		$this->assertNotNull($staticUser->getUserId());
		$this->assertTrue($staticUser->getUserId() > 0);
		$this->assertIdentical($staticUser->getUserId(),              $this->user->getUserId());
		$this->assertIdentical($staticUser->getFirstName(),               $this->EMAIL);
		$this->assertIdentical($staticUser->getLastName(),            $this->HASH);
		$this->assertIdentical($staticUser->getDateOfBirth(),                $this->SALT);
		$this->assertIdentical($staticUser->getGender(), $this->AUTH_TOKEN);
	}
}
?>
}

}
?>
/**
* Created by PhpStorm.
* User: Leonard
* Date: 11/12/2014
* Time: 9:46 AM
*/
