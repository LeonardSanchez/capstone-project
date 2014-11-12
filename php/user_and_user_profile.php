
<?php
/**
 * mySQL Enabled User and User Profile
 * @author Leonard Sanchez <Suavelen69@gmail.com, leonard@cnm.edu>
 *
 **/
class User {
	/**
	 * user id for  User; this is the primary key
	 **/
	private $userId;
	/**
	 * email for the User; this is a unique field
	 **/
	private $email;
	/**
	 * SHA512 PBKDF2 hash of the password
	 **/
	private $password;
	/**
	 * salt used in the PBKDF2 hash
	 **/
	private $salt;
	/**
	 * authentication token used for  new accounts and password resets
	 **/
	private $authenticationToken;

	/**
	 * constructors for the User
	 * @param mixed $newUserId user id (or null if new object)
	 * @param string $newEmail email
	 * @param string $newPassword PBKDF2 hash of the password
	 * @param string $newSalt salt used in the PBKDF2 hash
	 * @param mixed $newAuthenticationToken authentication token used in new accounts and password resets (or null if active User)
	 * @throws UnexpectedValueException when a parameter is wrong type
	 * @throws RangeException when a parameter is invalid
	 **/
	public function __construct($newUserId, $newEmail, $newPassword, $newSalt, $newAuthenticationToken) {
		try {
			$this->setUserId($newUserId);
			$this->setEmail($newEmail);
			$this->setPassword($newPassword);
			$this->setSalt($newSalt);
			$this->setAuthenticationToken($newAuthenticationToken);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct User", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to the caller
			throw(new RangeException("Unable to construct User", 0, $range));
		}
	}

	/**
	 * gets the value of user id
	 * @return mixed user id (or null if new object)
	 **/
	public function getUserId() {
		return($this->userId);
	}

	/**
	 * set the value of user id
	 * @param mixed $newUserId user id (or null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if user id isn't positive
	 **/
	public function setUserId($newUserId) {
		// set allow the user id to be null if a new object
		if($newUserId === null) {
			$this->userId = null;
			return;
		}

		// ensure the user id is an integer
		if(filter_var($newUserId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("user id $newUserId is not numeric"));
		}

		// convert the user id to an integer and enforce it's positive
		$newUserId = intval($newUserId);
		if($newUserId <= 0) {
			throw(new RangeException("user id $newUserId is not positive"));
		}

		//  take user id out of quarantine and assign it
		$this->userId = $newUserId;
	}

	/**
	 * get the value of email
	 * @return string value of email
	 **/
	public function getEmail() {
		return($this->email);
	}

	/**
	 * sets the value of email
	 * @param string $newEmail email
	 * @throws UnexpectedValueException if the input doesn't appear to be an Email
	 **/
	public function setEmail($newEmail) {
		// sanitize the Email as a likely Email
		$newEmail = trim($newEmail);
		if(($newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL)) == false) {
			throw(new UnexpectedValueException("email $newEmail does not appear to be an email address"));
		}

		// then just take email out of quarantine
		$this->email = $newEmail;
	}

	/**
	 * gets the value of password
	 * @return string value of password
	 **/
	public function getPassword() {
		return($this->password);
	}

	/**
	 * sets the value of password
	 * @param string $newPassword SHA512 PBKDF2 hash of the password
	 * @throws RangeException when input is not a valid SHA512 PBKDF2 hash
	 **/
	public function setPassword($newPassword) {
		// verify the password has 128 hex characters
		$newPassword   = trim($newPassword);
		$newPassword   = strtolower($newPassword);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{128}$/"));
		if(filter_var($newPassword, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("password is not a valid SHA512 PBKDF2 hash"));
		}

		// take  password out of quarantine
		$this->password = $newPassword;
	}

	/**
	 * gets the value of the salt
	 *
	 * @return string value of the salt
	 **/
	public function getSalt() {
		return($this->salt);
	}

	/**
	 * sets the value of salt
	 * @param string $newSalt salt (64 hexadecimal bytes)
	 * @throws RangeException when input is not 64 hexadecimal bytes
	 **/
	public function setSalt($newSalt) {
		// verify salt has 64 hex characters
		$newSalt   = trim($newSalt);
		$newSalt   = strtolower($newSalt);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{64}$/"));
		if(filter_var($newSalt, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("salt is not 64 hexadecimal bytes"));
		}

		// take salt out of quarantine
		$this->salt = $newSalt;
	}

	/**
	 * gets the value of authentication token
	 * @return mixed value of authentication token
	 **/
	public function getAuthenticationToken() {
		return($this->authenticationToken);
	}

	/**
	 * sets the value of authentication token
	 * @param mixed $newAuthenticationToken authentication token (32 hexadecimal bytes)
	 * @throws RangeException when input is not 32 hexadecimal bytes
	 **/
	public function setAuthenticationToken($newAuthenticationToken) {
		//  set allow the authentication token to null if an active o
		if($newAuthenticationToken === null) {
			$this->authenticationToken = null;
			return;
		}

		// confirm the authentication token has 32 hex characters
		$newAuthenticationToken   = trim($newAuthenticationToken);
		$newAuthenticationToken   = strtolower($newAuthenticationToken);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{32}$/"));
		if(filter_var($newAuthenticationToken, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("authentication token is not 32 hexadecimal bytes"));
		}

		// take authentication token out of quarantine
		$this->authenticationToken = $newAuthenticationToken;
	}

	/**
	 * inserts this User to mySQL
	 * @param resource $mysqli pointer to mySQL connection
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the userId is null
		if($this->userId !== null) {
			throw(new mysqli_sql_exception("not a new user"));
		}

		// create query template
		$query     = "INSERT INTO user(email, password, salt, authenticationToken) VALUES(?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssss", $this->email, $this->password,
			$this->salt,  $this->authenticationToken);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null userId
		$this->userId = $mysqli->insert_id;
	}

	/**
	 * deletes this User from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the userId is not null
		if($this->userId === null) {
			throw(new mysqli_sql_exception("Unable to delete a user that does not exist"));
		}

		// create query template
		$query     = "DELETE FROM user WHERE userId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->userId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * update the User in mySQL
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the userId is not null
		if($this->userId === null) {
			throw(new mysqli_sql_exception("Unable to update a user that does not exist"));
		}

		// create query template
		$query     = "UPDATE user SET email = ?, password = ?, salt = ?, authenticationToken = ? WHERE userId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssssi", $this->email, $this->password,
			$this->salt,  $this->authenticationToken,
			$this->userId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * gets the User by Email
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $email email to search for
	 * @return mixed User found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getUserByEmail(&$mysqli, $email) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the Email before searching
		$email = trim($email);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		// create query template
		$query     = "SELECT userId, email, password, salt, authenticationToken FROM user WHERE email = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the email to the place holder in the template
		$wasClean = $statement->bind_param("s", $email);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get result from the SELECT query
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		//  if  a result, make it into a User object
		//  no result, null
		$row = $result->fetch_assoc(); // fetch_assoc() returns a row as an associative array

		// convert the associative array to a User
		if($row !== null) {
			try {
				$user = new User($row["userId"], $row["email"], $row["password"], $row["salt"], $row["authenticationToken"]);
			}
			catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to User", 0, $exception));
			}

			// if we got here, the User is good - return it
			return($user);
		} else {
			//  return null
			return(null);
		}
	}
}
?>


<?php
//  require the SimpleTest
require_once("/usr/lib/php5/simpletest/autorun.php");

// require the class needing to be tested
//require_once("../php/user.php");

// the UserTest is a container for all our tests
class UserTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $user   = null;

	// a few variables for creating test data
	private $EMAIL      = "unit-test@example.net";
	private $PASSWORD   = "TRXLOVERS";
	private $SALT       = null;
	private $AUTH_TOKEN = null;
	private $HASH       = null;

	// public function is used to connect to mySQL and to calculate the salt, hash, and authenticationToken
	public function setUp() {
		// connect to mySQL
		mysqli_report(MYSQLI_REPORT_STRICT);
		$this->mysqli = new mysqli("localhost", "store_leo", "deepdive", "store_leo");

		// randomize the salt, hash, and authentication token
		$this->SALT       = bin2hex(openssl_random_pseudo_bytes(32));
		$this->AUTH_TOKEN = bin2hex(openssl_random_pseudo_bytes(16));
		$this->HASH       = hash_pbkdf2("sha512", $this->PASSWORD, $this->SALT, 2048, 128);
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

	// test creating a new User and inserting it to mySQL
	public function testInsertNewUser() {
		// verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// insert the user to mySQL
		$this->user->insert($this->mysqli);

		// compare the fields
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);
		$this->assertIdentical($this->user->getEmail(),               $this->EMAIL);
		$this->assertIdentical($this->user->getPassword(),            $this->HASH);
		$this->assertIdentical($this->user->getSalt(),                $this->SALT);
		$this->assertIdentical($this->user->getAuthenticationToken(), $this->AUTH_TOKEN);
	}

	// test updating a User in mySQL
	public function testUpdateUser() {
		// verify mySQL connected
		$this->assertNotNull($this->mysqli);

		// create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// insert the user to mySQL
		$this->user->insert($this->mysqli);

		// update the user and post the changes to mySQL
		$newEmail = "jake@cortez.org.mx";
		$this->user->setEmail($newEmail);
		$this->user->update($this->mysqli);

		// compare the fields
		  $this->assertNotNull($this->user->getUserId());
        $this->assertTrue($this->user->getUserId() > 0);
        $this->assertIdentical($this->user->getEmail(),               $newEmail);
        $this->assertIdentical($this->user->getPassword(),            $this->HASH);
        $this->assertIdentical($this->user->getSalt(),                $this->SALT);
        $this->assertIdentical($this->user->getAuthenticationToken(), $this->AUTH_TOKEN);
		// create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// insert the user to mySQL
		$this->user->insert($this->mysqli);

		// verify the User was inserted
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);

		// delete the user
		$this->user->delete($this->mysqli);
		$this->user = null;

		//  try to get user and say we didn't get a thing
		$hopefulUser = User::getUserByEmail($this->mysqli, $this->EMAIL);
		$this->assertNull($hopefulUser);
	}

	// test grabbing a User from mySQL
	public function testGetUserByEmail() {
		// verify mySQL connected
		$this->assertNotNull($this->mysqli);

		// create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

		// insert the user to mySQL
		$this->user->insert($this->mysqli);

		// get the user using the static method
		$staticUser = User::getUserByEmail($this->mysqli, $this->EMAIL);

		// compare the fields
		$this->assertNotNull($staticUser->getUserId());
		$this->assertTrue($staticUser->getUserId() > 0);
		$this->assertIdentical($staticUser->getUserId(),              $this->user->getUserId());
		$this->assertIdentical($staticUser->getEmail(),               $this->EMAIL);
		$this->assertIdentical($staticUser->getPassword(),            $this->HASH);
		$this->assertIdentical($staticUser->getSalt(),                $this->SALT);
		$this->assertIdentical($staticUser->getAuthenticationToken(), $this->AUTH_TOKEN);
	}
}
?>

