<?php
/**
 * mySQL Enabled Profile
 *
 * @author Leonard Sanchez <leonard@cnm.edu>
 * @see Profile
 **/
class profile {
	/**
	 * user id for the User; this is the primary key
	 **/
	private $profileId;
	/**
	 * email for the User; this is a unique field
	 **/
	private $firstName;
	/**
	 * SHA512 PBKDF2 hash of the password
	 **/
	private $lastName;
	/**
	 * salt used in the PBKDF2 hash
	 **/
	private $dateOfBirth;
	/**
	 * authentication token used in new accounts and password resets
	 **/
	private $gender;

	/**
	 * constructor for profileId
	 *
	 * @param mixed $newprofileId profile Id (or null if new object)
	 * @param string $newFirstName first name
	 * @param string $newLastName  PBKDF2 hash of the last name
	 * @param string $newDateOfBirth dateOfBirth used in the PBKDF2 hash
	 * @param mixed $newGender gender used in new accounts and password resets (or null if active User)
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws RangeException when a parameter is invalid
	 **/
	public function __construct($newProfileId, $newFirstName, $newLastName, $newDateOfBirth, $newGender) {
		try {
			$this->setProfileId($newProfileId);
			$this->setFirstName($newFirstName);
			$this->setLastName($newLastName);
			$this->setDateOfBirth($newDateOfBirth);
			$this->setGender($newGender);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct User", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to the caller
			throw(new RangeException("Unable to construct User", 0, $range));
		}
	}

	/**
	 * gets the value of profile id
	 *
	 * @return mixed profile id (or null if new object)
	 **/
	public function getProfileId() {
		return($this->profileId);
	}

	/**
	 * sets the value of profile id
	 *
	 * @param mixed $newProfileId profile id (or null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id isn't positive
	 **/
	public function setProfileId($newProfileId) {
		// zeroth, set allow the profile id to be null if a new object
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// first, ensure the profile id is an integer
		if(filter_var($newProfileId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("profile id $newProfileId is not numeric"));
		}

		// second, convert the profile id to an integer and enforce it's positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("profile id $newProfileId is not positive"));
		}

		// finally, take the profile id out of quarantine and assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * gets the value of first name
	 *
	 * @return string value of first name
	 **/
	public function getFirstName() {
		return($this->firstName);
	}

	/**
	 * sets the value of first name
	 *
	 * @param string $newFirstName first name
	 * @throws UnexpectedValueException if the input doesn't appear to be a first name
	 **/
	public function setFirstName($newFirstName) {
		// sanitize the First Name as a likely First Name
		$newFirstName = trim($newFirstName);
		if(($newFirstName = filter_var($newFirstName, FILTER_SANITIZE_EMAIL)) == false) {
			throw(new UnexpectedValueException("email $newFirstName does not appear to be a first name"));
		}

		// then just take first name out of quarantine
		$this->firstName = $newFirstName;
	}

	/**
	 * gets the value of last name
	 *
	 * @return string value of last name
	 **/
	public function getLastNamed() {
		return($this->lastName);
	}

	/**
	 * sets the value of last name
	 *
	 * @param string $newLastName SHA512 PBKDF2 hash of the password
	 * @throws RangeException when input isn't a valid SHA512 PBKDF2 hash
	 **/
	public function setLastName ($newLastName) {
		// verify the last name is 128 hex characters
		$newLastName   = trim($newLastName);
		$newLastName   = strtolower($newLastName);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{128}$/"));
		if(filter_var($newLastName, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("last name is not a valid SHA512 PBKDF2 hash"));
		}

		// finally, take the last name out of quarantine
		$this->lastName = $newLastName;
	}

	/**
	 * gets the value of date of birth
	 *
	 * @return string value of date of birth
	 **/
	public function getDateOfBirth() {
		return($this->dateOfBirth);
	}

	/**
	 * sets the value of date of birth
	 *
	 * @param string $newDateOfBirth date of birth (64 hexadecimal bytes)
	 * @throws RangeException when input isn't 64 hexadecimal bytes
	 **/
	public function setDateOfBirth ($newDateOfBirth) {
		// verify the date of birth is 64 hex characters
		$newDateOfBirth   = trim($newDateOfBirth);
		$newDateOfBirth   = strtolower($newDateOfBirth);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{64}$/"));
		if(filter_var($newDateOfBirth, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("date of birth is not 64 hexadecimal bytes"));
		}

		// finally, take the date of birth out of quarantine
		$this->dateOfBirth = $newDateOfBirth;
	}

	/**
	 * gets the value of gender
	 *
	 * @return mixed value of gender (or null if active User)
	 **/
	public function getGender() {
		return($this->gender);
	}

	/**
	 * sets the value of gender
	 *
	 * @param mixed $newGender gender (32 hexadecimal bytes) (or null if active User)
	 * @throws RangeException when input isn't 32 hexadecimal bytes
	 **/
	public function setGender($newGender) {
		// zeroth, set allow the gender to be null if an active object
		if($newGender === null) {
			$this->gender = null;
			return;
		}

		// verify the gender is 32 hex characters
		$newGender   = trim($newGender);
		$newGender   = strtolower($newGender);
		$filterOptions = array("options" => array("regexp" => "/^[\da-f]{32}$/"));
		if(filter_var($newGender, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("gender is not 32 hexadecimal bytes"));
		}

		// finally, take gender out of quarantine
		$this->gender = $newGender;
	}

	/**
	 * inserts this profile id to mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is null (i.e., don't insert a profile that already exists)
		if($this->profileId !== null) {
			throw(new mysqli_sql_exception("not a new profile"));
		}

		// create query template
		$query     = "INSERT INTO profile(firstName, lastName, dateOfBirth, gender) VALUES(?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssss", $this->firstName, $this->lastName,
			$this->dateOfBirth,  $this->gender);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null profileId with what mySQL just gave us
		$this->profileId = $mysqli->insert_id;
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

		// enforce the userId is not null (i.e., don't delete a user that hasn't been inserted)
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to delete a profile that does not exist"));
		}

		// create query template
		$query     = "DELETE FROM user WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * updates this profile in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the profileId is not null (i.e., don't update a user that hasn't been inserted)
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to update a profile that does not exist"));
		}

		// create query template
		$query     = "UPDATE user SET firstName = ?, lastName = ?, dateOfBirth = ?, gender = ? WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssssi", $this->firstName, $this->lastName,
			$this->dateOfBirth,  $this->gender,
			$this->profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * gets the profile by first name
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $firstName first name to search for
	 * @return mixed Profile found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getUserByFirstName(&$mysqli, $firstName) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the first name before searching
		$firstName = trim($firstName);
		$firstName = filter_var($firstName, FILTER_SANITIZE_FIRST_NAME);

		// create query template
		$query     = "SELECT profileId, firstName, lastName, dateOfBirth, gender FROM user WHERE firstName = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the first name to the place holder in the template
		$wasClean = $statement->bind_param("s", $firstName);
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

		// since this is a unique field, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into a profile object normally
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc() returns a row as an associative array

		// convert the associative array to a Profile
		if($row !== null) {
			try {
				$profile = new Profile($row["profileId"], $row["firstName"], $row["lastName"], $row["dateOfBirth"], $row["gender"]);
			}
			catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Profile", 0, $exception));
			}

			// if we got here, the User is good - return it
			return($profile);
		} else {
			// 404 Profile not found - return null instead
			return(null);
		}
	}
}
?>


<?php
/**
 * Created by PhpStorm.
 * User: Leonard
 * Date: 11/14/2014
 * Time: 8:27 AM
 */
