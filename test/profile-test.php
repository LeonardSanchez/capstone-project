<?php
// 1st require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class in question
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
	private $user           = null;

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
		$this->user = new User(null, "randomemail@yahoo.com", $passwordHash, $salt, $authToken);
		$this->user->insert($this->mysqli);
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
		if($this->user    !== null) {
			$this->user->delete($this->mysqli);
			$this->user = null;
		}
	}

	//test creating a new Profile and inserting it to mySQL
	public function testInsertNewProfile() {
		// 1st, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// 2nd, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->user->getUserId(), $this->FIRST_NAME, $this->LAST_NAME, $this->DATE_OF_BIRTH, $this->GENDER);

		// 3rd, insert the user to mySQL
		$this->profile->insert($this->mysqli);

		$tempDate = DateTime::createFromFormat('Y-m-d', $this->DATE_OF_BIRTH);

		// finally, compare the fields
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getUserId(),			$this->profile->getUserId());
		$this->assertIdentical($this->profile->getFirstName(),		$this->FIRST_NAME);
		$this->assertIdentical($this->profile->getLastName(),			$this->LAST_NAME);
		$this->assertIdentical($this->profile->getDateOfBirth(),		$tempDate);
		$this->assertIdentical($this->profile->getGender(),			$this->GENDER);
	}

	// test updating a Profile in mySQL
	public function testUpdateProfile() {
		// 1st, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// 2nd, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->user->getUserId(), $this->FIRST_NAME, $this->LAST_NAME, $this->DATE_OF_BIRTH, $this->GENDER);

		// 3rd, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// 4th, update the profile and post the changes to mySQL
		$newFirstName = "Sherman";
		$this->profile->setFirstName($newFirstName);
		$this->profile->update($this->mysqli);

		$tempDate = DateTime::createFromFormat('Y-m-d', $this->DATE_OF_BIRTH);

		//finally, compare the fields
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getUserId(),			$this->user->getUserId());
		$this->assertIdentical($this->profile->getFirstName(),		$newFirstName);
		$this->assertIdentical($this->profile->getLastName(),			$this->LAST_NAME);
		$this->assertIdentical($this->profile->getDateOfBirth(),		$tempDate);
		$this->assertIdentical($this->profile->getGender(),			$this->GENDER);
	}

	//test deleting a Profile
	public function testDeleteProfile() {
		// 1st, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// 2nd, create a profile to post to mySql
		$this->profile = new Profile(null, $this->user->getUserId(), $this->FIRST_NAME, $this->LAST_NAME, $this->DATE_OF_BIRTH, $this->GENDER);

		// 3rd, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// 4th, verify the Profile was inserted
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() >0);

		//5th, delete the profile
		$destroyedProfileId = $this->profile->getProfileId();
		$this->profile->delete($this->mysqli);
		$this->profile = null;

		// finally, try to get the profile and assert we didn't get anything
		$staticProfile = Profile::getProfileByProfileId($this->mysqli, $destroyedProfileId);
		$this->assertNull($staticProfile);
	}

	// test grabbing a Profile from mySQL
	public function testGetProfileByProfileId() {
		// 1st, verify mySQL connected
		$this->assertNotNull($this->mysqli);

		// 2nd, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->user->getUserId(), $this->FIRST_NAME, $this->LAST_NAME, $this->DATE_OF_BIRTH, $this->GENDER);

		// 3rd, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// 4th, get the profile using the static method
		$staticProfile = Profile::getProfileByProfileId($this->mysqli, $this->profile->getProfileId());
		$tempDate = DateTime::createFromFormat('Y-m-d', $this->DATE_OF_BIRTH);

		// finally, compare the fields
		$this->assertNotNull($staticProfile->getProfileId());
		$this->assertTrue($staticProfile->getProfileId() > 0);
		$this->assertIdentical($staticProfile->getProfileId(),		$this->profile->getProfileId());
		$this->assertIdentical($staticProfile->getUserId(),			$this->user->getUserId());
		$this->assertIdentical($staticProfile->getFirstName(),		$this->FIRST_NAME);
		$this->assertIdentical($staticProfile->getLastName(),			$this->LAST_NAME);
		$this->assertIdentical($staticProfile->getDateOfBirth(),		$tempDate);
		$this->assertIdentical($staticProfile->getGender(),			$this->GENDER);
	}
}

?>