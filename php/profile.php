<?php
/**
 * mySQL Enabled User
 *
 * @author Leonard Sanchez <leonard@cnm.edu>
 * @see Profile
 **/
class Profile
{
	/**
	 * profile id for the Profile; this is the primary key
	 **/
	private $profileId;
	/**
	 * user id for the Profile; this is a foreign key
	 **/
	private $userId;
	/**
	 * first name for the Profile;
	 **/
	private $firstName;
	/**
	 * last name for the Profile;
	 **/
	private $lastName;
	/**
	 * date of birth for the profile
	 */
	private $dateOfBirth;
	/**
	 * gender for the profile
	 */
	private $gender;
	/**
	 * constructor for Profile
	 *
	 * @param mixed  $newProfileId   profile id (or null if new object)
	 * @param mixed  $newUserId      user id
	 * @param string $newFirstName   first name
	 * @param string $newLastName    last name
	 * @param string $newDateOfBirth date of birth
	 * @param string $newGender      gender
	 *
	 **/
	public function __construct($newProfileId, $newUserId, $newFirstName, $newLastName, $newDateOfBirth, $newGender)
	{
		try {
			$this->setProfileId($newProfileId);
			$this->setUserId($newUserId);
			$this->setFirstName($newFirstName);
			$this->setLastName($newLastName);
			$this->setDateOfBirth($newDateOfBirth);
			$this->setGender($newGender);
		} catch(UnexpectedValueException $unexpectedValue) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Profile", 0, $unexpectedValue));
		} catch(RangeException $range) {
			//rethrow to the caller
			throw(new RangeException("Unable to construct Profile", 0, $range));
		}
	}
	/**
	 * gets the value of profile id
	 *
	 * @return mixed profile id (or null if new object)
	 **/
	public function getProfileId()
	{
		return ($this->profileId);
	}
	/**
	 * sets the value of profile id
	 *
	 * @param mixed $newProfileId profile id (or null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id isn't positive
	 **/
	public function setProfileId($newProfileId)
	{
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
	 * gets the value of user id
	 *
	 * @return mixed user id
	 **/
	public function getUserId()
	{
		return ($this->userId);
	}
	/**
	 * sets the value of user id
	 *
	 * @param mixed $newUserId user id
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if user id isn't positive
	 **/
	public function setUserId($newUserId)
	{
		// first, ensure the user id is an integer
		if(filter_var($newUserId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("user id $newUserId is not numeric"));
		}
		// second, convert the user id to an integer and enforce it's positive
		$newUserId = intval($newUserId);
		if($newUserId <= 0) {
			throw(new RangeException("user id $newUserId is not positive"));
		}
		// finally, take the user id out of quarantine and assign it
		$this->userId = $newUserId;
	}
	/**
	 * gets the value of first name
	 *
	 * @return string value of first name
	 **/
	public function getFirstName()
	{
		return ($this->firstName);
	}
	/**
	 *sets the value of first name
	 *
	 * @param string $newFirstName first name
	 * @throws UnexpectedValueException if the input doesn't appear to be a First Name
	 **/
	public function setFirstName($newFirstName)
	{
		// sanitize the First Name as a likely First Name
		$newFirstName = trim($newFirstName);
		if(($newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("firstName $newFirstName does not appear to be a first name"));
		}
		//then just take first name out of quarantine
		$this->firstName = $newFirstName;
	}
	/**
	 * gets the value of last name
	 *
	 * @return string value of last name
	 **/
	public function getLastName()
	{
		return ($this->lastName);
	}
	/**
	 *sets the value of last name
	 *
	 * @param string $newLastName last name
	 * @throws UnexpectedValueException if the input doesn't appear to be a Last Name
	 **/
	public function setLastName($newLastName)
	{
		// sanitize the Last Name as a likely Last Name
		$newLastName = trim($newLastName);
		if(($newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("lastName $newLastName does not appear to be a last name"));
		}
		//then just take last name out of quarantine
		$this->lastName = $newLastName;
	}
	/**
	 * gets the value of date of birth
	 */
	public function getDateOfBirth()	{
		return($this->dateOfBirth);
	}
	/**
	 * sets the value of date of birth
	 *
	 * @param mixed $newDateOfBirth object or string with the date of birth
	 * @throws RangeException if date is not a valid date
	 */
	public function setDateOfBirth($newDateOfBirth)
	{
		// zeroth, allow the date to be null if new object
		if($newDateOfBirth === null) {
			$this->dateOfBirth = null;
			return;
		}
		// first, allow a DateTime object to be directly assigned
		if(gettype($newDateOfBirth) === "object" && get_class($newDateOfBirth) === "DateTime") {
			$this->dateOfBirth = $newDateOfBirth;
			return;
		}
		// second, treat the date as a mySQL date string
		$newDateOfBirth = trim($newDateOfBirth);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $newDateOfBirth, $matches)) !== 1) {
			throw(new RangeException("$newDateOfBirth is not a valid date"));
		}
		// third, verify the date is really a valid calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		if(checkdate($month, $day, $year) === false) {
			throw(new RangeException("$newDateOfBirth is not a Gregorian date"));
		}
		// finally, take the date out of quarantine
		$newDateOfBirth = DateTime::createFromFormat("Y-m-d", $newDateOfBirth);
		$newDateOfBirth->setTime(0, 0, 0);
		$this->dateOfBirth = $newDateOfBirth;
	}
	/**
	 * gets the value of gender
	 *
	 * @return string value of gender
	 */
	public function getGender() {
		return($this->gender);
	}
	/**
	 *sets the value of gender
	 *
	 * @param string $newGender gender
	 * @throws UnexpectedValueException if the input doesn't appear to be a gender identifier
	 **/
	public function setGender($newGender) {
		// sanitize the Gender as a likely Gender identifier
		$newGender = trim($newGender);
		if(($newGender = filter_var($newGender, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("gender $newGender does not appear to be a gender"));
		}
		//then just take the Gender out of quarantine
		$this->gender = $newGender;
	}
	/**
	 *  inserts this Profile to mySQL
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
		// convert dates to strings
		if($this->dateOfBirth === null) {
			$dateOfBirth = null;
		} else {
			$dateOfBirth = $this->dateOfBirth->format("Y-m-d H:i:s");
		}
		// create query template
		$query = "INSERT INTO profile(userId, firstName, lastName, dateOfBirth, gender) VALUES(?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}
		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("issss", $this->userId, $this->firstName,
			$this->lastName, $dateOfBirth, $this->gender);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}
		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
		// update the null profileId with what mySQL just gave me
		$this->profileId = $mysqli->insert_id;
	}
	/**
	 * deletes this Profile from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function delete(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}
		// enforce the profileId is not null (i.e., don't delete a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}
		// create query template
		$query = "DELETE FROM profile WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$wasClean = $statement->bind_param("i", $this->profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("unable to bind paramaters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}
	/**
	 * updates this Profile in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}
		// enforce the profileId is not null (i.e., don't update a profile that hasn't been inserted)
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("Unable to update a profile that does not exist"));
		}
		// convert dates to strings
		if($this->dateOfBirth === null) {
			$dateOfBirth = null;
		} else {
			$dateOfBirth = $this->dateOfBirth->format("Y-m-d H:i:s");
		}
		// create query template
		$query = "UPDATE profile SET userId = ?, firstName = ?, lastName = ?, dateOfBirth = ?, gender = ? WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}
		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("issssi", $this->userId, $this->firstName,
			$this->lastName, $dateOfBirth, $this->gender, $this->profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}
		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}
	/**
	 * gets the Profile by ProfileId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $profileId profileId to search for
	 * @return mixed Profile found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getProfileByProfileId(&$mysqli, $profileId) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}
		// sanitize the profileId before searching
		$profileId = filter_var($profileId, FILTER_VALIDATE_INT);

		// create query template
		$query = "SELECT profileId, userId, firstName, lastName, dateOfBirth, gender FROM profile WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}
		// bind the email to the place holder in the template
		$wasClean = $statement->bind_param("i", $profileId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}
		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
		//get result from the SELECT query *pounds fists*
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}
		// since this is a primary key, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into a Profile object normally
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc() returns a row as an associative array
		// convert the associative array to a Profile

		if($row !== null) {
			try {
				$profileId = new Profile($row["profileId"], $row["userId"], $row["firstName"], $row["lastName"], $row["dateOfBirth"], $row["gender"]);
				$profileIds[] = $profileId;
			} catch(Exception $exception)
			{
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Profile", 0, $exception));
			}
			// if we got here, the Profile is good - return it
			return ($profileId);
		} else {
			// 404 Profile not found - return null instead
			return (null);
		}
	}
	/** gets the Profile by First Name
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $firstName firstName to search fo
	 * @return mixed Profile found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function  getProfileByFirstName(&$mysqli, $firstName) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}
		//sanitize the First Name before searching
		$firstName = trim($firstName);
		if(($firstName = filter_var($firstName, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("firstName $firstName does not appear to be a first name"));
		}
		// create query template
		$query 		= "SELECT profileId, userId, firstName, lastName, dateOfBirth, gender FROM profile WHERE firstName = ?";
		$statement	= $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}
		// bind the firstName to the place holder in the template
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
		// since this is not a unique field, this can return many results. So...
		// 1) if there's more than 1 result, we can make all into Profile objects
		// 2) if there's no result, we can just return null
		while(($row = $result->fetch_assoc()) !== null); // fetch_assoc() returns a row as an associative array
		// convert the associative array to a Profile
		if($row !== null) {
			try {
				$profileId = new Profile($row["profileId"], $row["userId"], $row["firstName"], $row["lastName"], $row["dateOfBirth"], $row["gender"]);
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Profile", 0, $exception));
			}
			// if we got here, the Profile is good - return it
			return ($profileId);
		} else {
			// 404 Profile not found - return null instead
			return (null);
		}
	}
}
?>