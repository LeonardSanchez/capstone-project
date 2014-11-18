<?php
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/profile.php");

// require the classes for poor man's dependency injection
require_once("../php/user.php");

// require mySQLI
require_once("/etc/apache2/capstone-mysql/rgevents.php");

// the ProfileTest is a container for all our tests
class ProfileTest extends unitTestCase {
	// variable to hold the mySQL connection
	private $mysqli	= null;
	// variable to hold the test database row
	private $profile 	= null;

	// a few "global" variables for creating test data
	private $FIRST_NAME		= "Mr";
	private $LAST_NAME		= "Peabody";
	private $DATE_OF_BIRTH	= "1977-05-27";
	private $GENDER			= "M";

	// create state variables for the objects


	// setUp() is a method that is run before each test & connnect to mySQl
	public function setUp()
	// connect to mySQL
	{
		mysqli_report(MYSQLI_REPORT_STRICT);
		$this->mysqli = MysqliConfiguration::getMysqli();

		// setup the objects, and enter all data fields from corresponding table

		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$authToken = bin2hex(openssl_random_pseudo_bytes(16));
		$passwordHash = hash_pbkdf2("sha512", "password123", $salt, 2048, 128);
		$this->profile = new User(null, "randomemail@yahoo.com", $passwordHash, $salt, $authToken);
		$this->profile->insert($this->mysqli);
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown()
	{
		// delete the user if we can

		if($this->profile !== null) {
			$this->profile->delete($this->mysqli);
			$this->profile = null;
		}
		if($this->profile !== null) {
			$this->profile->delete($this->mysqli);
			$this->profile = null;
		}
	}

	//test creating a new Profile and inserting it to mySQL
	public function testInsertNewProfile() {
		// fist, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->user->getUserId(), $this->FIRST_NAME, $this->LAST_NAME, $this->DATE_OF_BIRTH, $this->GENDER);

		// third, insert the user to mySQL
		$this->profile->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getUserId(),			$this->profile->getUserId());
		$this->assertIdentical($this->profile->getFirstName(),		$this->FIRST_NAME);
		$this->assertIdentical($this->profile->getLastName(),			$this->LAST_NAME);
		$this->assertIdentical($this->profile->getDateOfBirth(),		$this->DATE_OF_BIRTH);
		$this->assertIdentical($this->profile->getGender(),			$this->GENDER);
	}

	// test updating a Profile in mySQL
	public function testUpdateProfile() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->profile->getUserId(), $this->FIRST_NAME, $this->LAST_NAME, $this->DATE_OF_BIRTH, $this->GENDER);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, update the profile and post the changes to mySQL
		$newFirstName = "Sherman";
		$this->profile->setFirstName($newFirstName);
		$this->profile->update($this->mysqli);

		//finally, compare the fields
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getUserId(),			$this->user->getUserId());
		$this->assertIdentical($this->profile->getFirstName(),		$newFirstName);
		$this->assertIdentical($this->profile->getLastName(),			$this->LAST_NAME);
		$this->assertIdentical($this->profile->getDateOfBirth(),		$this->DATE_OF_BIRTH);
		$this->assertIdentical($this->profile->getGender(),			$this->GENDER);
	}

	//test deleting a Profile
	public function testDeleteProfile() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySql
		$this->profile = new Profile(null, $this->profile->getUserId(), $this->FIRST_NAME, $this->LAST_NAME, $this->DATE_OF_BIRTH, $this->GENDER);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, verify the Profile was inserted
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() >0);

		//fifth, delete the profile
		$this->profile->delete($this->mysqli);
		$this->profile = null;

		// finally, try to get the profile and assert we didn't get a thing
		$staticProfile = Profile::getProfileByProfileId($this->mysqli, $this->PROFILE_ID);
		$this->assertNull($staticProfile);
	}

	// test grabbing a Profile from mySQL
	public function testGetProfileByProfileId() {
		// first, verify mySQL connected O
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->profile->getUserId(), $this->FIRST_NAME, $this->LAST_NAME, $this->DATE_OF_BIRTH, $this->GENDER);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, get the user using the static method
		$staticProfile = Profile::getProfileByProfileId($this->mysqli, $this->PROFILE_ID);

		// finally, compare the fields
		$this->assertNotNull($staticProfile->getProfileId());
		$this->assertTrue($staticProfile->getProfileId() > 0);
		$this->assertIdentical($staticProfile->getProfileId(),		$this->profile->getProfileId());
		$this->assertIdentical($staticProfile->getUserId(),			$this->user->getUserId());
		$this->assertIdentical($staticProfile->getFirstName(),		$this->FIRST_NAME);
		$this->assertIdentical($staticProfile->getLastName(),			$this->LAST_NAME);
		$this->assertIdentical($staticProfile->getDateOfBirth(),		$this->DATE_OF_BIRTH);
		$this->assertIdentical($staticProfile->getGender(),			$this->GENDER);
	}
}

?>