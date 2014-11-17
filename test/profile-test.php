<?php
/**
 * This is a simple test of our profile class
 */
/** require the simple test framework */
require_once("/usr/lib/php5/simpletest/autorun.php");
/** then require the class being tested */
require_once("../php/profile.php");
/** require mysqli */
require_once("/etc/apache2/capstone-mysql/rgevents.php");
/** the Profile test is a container for all of our tests */
class ProfileTest extends UnitTestCase {
	// variable to hold the mysqli connection
	private $mysqli  = null;
	// variable to hold the test datebase row
	private $profile = null;
	// the "global variables" for creating test data
	private $EMAIL 			= "leonard@cnm.edu";
	private $PASSWORD 		= "TRXLOVERS";
	private $SALT				= null;
	private $AUTH_TOKEN		= null;
	private $HASH           = null;
	/** set up is what we run before each test
	 * we use it to connect to mySQL and to calculate the salt, authentication token, and the hash.*/
	public function setUp() {
		// connect to mySQL
		mysqli_report (MYSQLI_REPORT_STRICT);
		$this->mysqli = new mysqli("localhost", "store_dylan", "deepdive", "store_dylan");

		// randomize the salt, hash, and authentication token
		$this->SALT       = bin2hex(openssl_random_pseudo_bytes(32));
		$this->AUTH_TOKEN = bin2hex(openssl_random_pseudo_bytes(16));
		$this->HASH       = hash_pbkdf2("sha512", $this->PASSWORD, $this->SALT, 2048, 128);
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown() {
		// delete the profile if we can
		if($this->profile !== null) {
			$this->profile->delete($this->mysqli);
			$this->profile = null;
		}

	}

	// test creating a new Profile and inserting it to mySQL
	public function testInsertNewProfile() {
		// first, verify mySQL connected
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull  ($this->profile->getProfileId());
		$this->assertTrue     ($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getFirstName(),               $this->EMAIL);
		$this->assertIdentical($this->profile->getLastNamed(),               $this->HASH);
		$this->assertIdentical($this->profile->getDateOfBirth(),             $this->SALT);
		$this->assertIdentical($this->profile->getGender(),                  $this->AUTH_TOKEN);
	}

	// test updating a Profile in mySQL
	public function testUpdateProfile() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, update the profile and post the changes to mySQL
		$newEmail = "leonard@cnm.edu";
		$this->profile->setEmail($newEmail);
		$this->profile->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull  ($this->profile->getUserId());
		$this->assertTrue     ($this->profile->getUserId() > 0);
		$this->assertIdentical($this->profile->getEmail(),               $newEmail);
		$this->assertIdentical($this->profile->getPassword(),            $this->HASH);
		$this->assertIdentical($this->profile->getSalt(),                $this->SALT);
		$this->assertIdentical($this->profile->getAuthenticationToken(), $this->AUTH_TOKEN);
	}

	// test deleting a Profile
	public function testDeleteProfile() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, verify the Profile was inserted
		$this->assertNotNull($this->profile->getUserId());
		$this->assertTrue   ($this->profile->getUserId() > 0);

		// fifth, delete the profile
		$this->profile->delete($this->mysqli);
		$this->profile = null;

		// finally, try to get the profile and assert we didn't get a thing
		$hopefulProfile = Profile::getProfileByEmail($this->mysqli, $this->EMAIL);
		$this->assertNull($hopefulProfile);
	}

	// test grabbing a Profile from mySQL
	public function testGetProfileByEmail() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a profile to post to mySQL
		$this->profile = new Profile(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, get the profile using the static method
		$staticUser = Profile::getProfileByEmail($this->mysqli, $this->EMAIL);

		// finally, compare the fields
		$this->assertNotNull  ($staticUser->getProfileId());
		$this->assertTrue     ($staticUser->getProfileId() > 0);
		$this->assertIdentical($staticUser->getProfileId(),           $this->profile->getProfileId());
		$this->assertIdentical($staticUser->getFirstName(),           $this->EMAIL);
		$this->assertIdentical($staticUser->getLastName(),            $this->HASH);
		$this->assertIdentical($staticUser->getDateOfBirth(),         $this->SALT);
		$this->assertIdentical($staticUser->getGender(),              $this->AUTH_TOKEN);
	}
}
?>
	}

}