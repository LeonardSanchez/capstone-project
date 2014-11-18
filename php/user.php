<?php
/**
 * mySQL Enabled User and User Profile
 * @author Leonard Sanchez <Suavelen69@gmail.com, leonard@cnm.edu>
 *
 **/
class User {
	/**
	 * user id for User; this is the primary key
	 **/
	private $userId;
	/**
	 * email for the User; this is a unique field
	 **/
	private $email;
	/**
	 * SHA512 PBKDF2 hash of the password
	 **/
	private $passwordHash;
	/**
	 * salt used in the PBKDF2 hash
	 **/
	private $salt;
	/**
	 * authentication token used for  new accounts and password resets
	 **/
	private $authToken;
	/**
	 * constructors for the User
	 * @param mixed $newUserId user id (or null if new object)
	 * @param string $newEmail email
	 * @param string $newPasswordHash PBKDF2 hash of the password
	 * @param string $newSalt salt used in the PBKDF2 hash
	 * @param mixed $newAuthToken authentication token used in new accounts and password resets (or null if active User)
	 * @throws UnexpectedValueException when a parameter is wrong type
	 * @throws RangeException when a parameter is invalid
	 **/
	public function __construct($newUserId, $newEmail, $newPasswordHash, $newSalt, $newAuthToken) {
		try {
			$this->setUserId($newUserId);
			$this->setEmail($newEmail);
			$this->setPasswordHash($newPasswordHash);
			$this->setSalt($newSalt);
			$this->setAuthToken($newAuthToken);
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
	 * gets the value of passwordHash
	 * @return string value of passwordHash
	 **/
	public function getPasswordHash() {
		return($this->passwordHash);
	}
	/**
	 * sets the value of passwordHash
	 *
	 * @param string $newPasswordHash SHA512 PBKDF2 hash of the password
	 * @throws RangeException when input is not a valid SHA512 PBKDF2 hash
	 **/
	public function setPasswordHash($newPasswordHash) {
		// verify the passwordHash has 128 hex characters
		$newPasswordHash   = trim($newPasswordHash);
		$newPasswordHash   = strtolower($newPasswordHash);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{128}$/"));
		if(filter_var($newPasswordHash, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("password is not a valid SHA512 PBKDF2 hash"));
		}
		// take  password out of quarantine
		$this->passwordHash = $newPasswordHash;
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
	 *
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
	public function getAuthToken() {
		return($this->authToken);
	}
	/**
	 * sets the value of authentication token
	 * @param mixed $newAuthToken authentication token (32 hexadecimal bytes)
	 * @throws RangeException when input is not 32 hexadecimal bytes
	 **/
	public function setAuthToken($newAuthToken) {
		//  set allow the authentication token to null if an active object
		if($newAuthToken === null) {
			$this->authToken = null;
			return;
		}
		// confirm the authentication token has 32 hex characters
		$newAuthToken   = trim($newAuthToken);
		$newAuthToken   = strtolower($newAuthToken);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{32}$/"));
		if(filter_var($newAuthToken, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("authentication token $newAuthToken is not 32 hexadecimal bytes"));
		}
		// take authentication token out of quarantine
		$this->authToken = $newAuthToken;
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
		$query     = "INSERT INTO user(email, passwordHash, salt, authToken) VALUES(?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}
		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssss", $this->email, $this->passwordHash, $this->salt, $this->authToken);
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
		$query     = "UPDATE user SET email = ?, passwordHash = ?, salt = ?, authToken = ? WHERE userId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}
		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssssi", $this->email, $this->passwordHash,
			$this->salt,  $this->authToken,
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
		$query     = "SELECT userId, email, passwordHash, salt, authToken FROM user WHERE email = ?";
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
				$user = new User($row["userId"], $row["email"], $row["passwordHash"], $row["salt"], $row["authToken"]);
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