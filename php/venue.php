<?php
/**
 * This is a mySQL enabled container for venue data for redorgreenevents.com. It can be easily updated to include more fields as necessary.
 *
 *
 */
class Venue
{
	/**
	 * venue id fo the venue this is the primary key
	 */
	private $venueId;
	/**
	 * venue name for the Venue
	 */
	private $venueName;
	/**
	 * venue capacity for the Venue
	 */
	private $venueCapacity;
	/**
	 * venue phone for the Venue
	 */
	private $venuePhone;
	/**
	 * venue website for the Venue
	 */
	private $venueWebsite;
	/**
	 * street address for the Venue
	 */
	private $venueAddress1;
	/**
	 * second line address for the Venue
	 */
	private $venueAddress2;
	/**
	 * city for the Venue
	 */
	private $venueCity;
	/**
	 * state for the Venue
	 */
	private $venueState;
	/**
	 * zip code for the Venue
	 */
	private $venueZipCode;


	/**
	 * constructor for Venue
	 *
	 * @param int $newVenueId venue id (or null if new object)
	 * @param string $newVenueName venue name
	 * @param int $newVenueCapacity venue capacity
	 * @param string $newVenuePhone venue phone
	 * @param string $newVenueWebsite venue website
	 * @param string $newVenueAddress1 venue address first line
	 * @param string $newVenueAddress2 venue address second line
	 * @param string $newCity venue city
	 * @param string $newState venue state
	 * @param string $newZipCode venue zip code
	 */
	public function __construct($newVenueId, $newVenueName, $newVenueCapacity, $newVenuePhone, $newVenueWebsite, $newVenueAddress1, $newVenueAddress2, $newVenueCity, $newVenueState, $newVenueZipCode) {
		try {
			$this->setVenueId($newVenueId);
			$this->setVenueName($newVenueName);
			$this->setVenueCapacity($newVenueCapacity);
			$this->setVenuePhone($newVenuePhone);
			$this->setVenueWebsite($newVenueWebsite);
			$this->setVenueAddress1($newVenueAddress1);
			$this->setVenueAddress2($newVenueAddress2);
			$this->setVenueCity($newVenueCity);
			$this->setVenueState($newVenueState);
			$this->setVenueZipCode($newVenueZipCode);
		} catch(UnexpectedValueException $unexpectedValue) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Venue", 0, $unexpectedValue));
		} catch(RangeException $range) {
			//rethrow to the caller
			throw(new RangeException("Unable to construct Venue", 0, $range));
		}
	}

	/**
	 * gets the value of venue id
	 *
	 * @return int venue id (or null if new object)
	 */
	public function getVenueId() {
		return ($this->venueId);
	}

	/**
	 * sets the value of venue id
	 *
	 * @param int $newVenueId venue id (or null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if venue id isn't positive
	 */
	public function setVenueId($newVenueId) {
		// zeroth, set all the venue id to be null if a new object
		if($newVenueId === null) {
			$this->venueId = null;
			return;
		}

		// first, ensure the venue id is an integer
		if(filter_var($newVenueId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("venue id $newVenueId is not numeric"));
		}

		// second, convert the venue id to an integer and enforce it is positive
		$newVenueId = intval($newVenueId);
		if($newVenueId <= 0) {
			throw(new UnexpectedValueException("venue id $newVenueId is not positive"));
		}

		// finally, take the venue id out of quarantine and assign it
		$this->venueId = $newVenueId;
	}

	/**
	 * gets the value of venue name
	 *
	 * @return string value of venue name
	 */
	public function getVenueName() {
		return ($this->venueName);
	}

	/**
	 * sets the value of venue name
	 *
	 * @param string $newVenueName venue name
	 * @throws UnexpectedValueException if it doesn't appear to be a venue name
	 */
	public function setVenueName($newVenueName) {
		// sanitize the Venue Name as a likely Venue Name
		$newVenueName = trim($newVenueName);
		if(($newVenueName = filter_var($newVenueName, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("venueName $newVenueName does not appear to be a valid venue name"));
		}

		// then take the venue name out of quarantine
		$this->venueName = $newVenueName;
	}

	/**
	 * gets the value of venue capacity
	 *
	 * @return int value of venue capacity
	 */
	public function getVenueCapacity() {
		return ($this->venueCapacity);
	}

	/**
	 * sets int value of venue capacity
	 *
	 * @param int $newVenueCapacity venue capacity
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if venue capacity isn't positive
	 */
	public function setVenueCapacity($newVenueCapacity) {

		// first, ensure the venue capacity is an integer
		if(filter_var($newVenueCapacity, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("venue capacity is not numeric"));
		}

		// second, convert the venue capacity to an integer and enforce it is positive
		$newVenueCapacity = intval($newVenueCapacity);
		if($newVenueCapacity <= 0) {
			throw(new RangeException("venue capacity $newVenueCapacity is not positive"));
		}

		// finally take the venue capacity out of quarantine and assign it
		$this->venueCapacity = $newVenueCapacity;
	}

	/**
	 * gets the value of venue phone
	 *
	 * @return string value of venue phone
	 */
	public function getVenuePhone() {
		return ($this->venuePhone);
	}

	/**
	 * sets string value of venue phone
	 *
	 * @param string $newVenuePhone venue phone
	 * @param string strip out all special characters using sanitize
	 * @throws UnexpectedValueException if the input doesn't appear to be a phone number
	 * @throws RangeException when input is not a valid phone number format
	 */
	public function setVenuePhone($newVenuePhone) {
		// sanitize the VenuePhone as a likely phone number
		$newVenuePhone = trim($newVenuePhone);
		if(($newVenuePhone = filter_var($newVenuePhone, FILTER_VALIDATE_INT)) == false) {
			throw(new UnexpectedValueException("phone $newVenuePhone does not appear to be a phone number"));
		}

		// verify the venuePhone is a valid phone number with acceptable character length
		// regexp code sourced from stackoverflow.com user fatcat1111, http://stackoverflow.com/questions/123559/a-comprehensive-regex-for-phone-number-validation/
		$newVenuePhone = trim($newVenuePhone);
		$filterOptions = array("options" => array("regexp" => "^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$"));
		if(filter_var($newVenuePhone, FILTER_VALIDATE_REGEXP, $filterOptions) === false) {
			throw(new RangeException("venuePhone $newVenuePhone is not a valid phone number format"));
		}

		// finally, take the venuePhone out of quarantine
		$this->venuePhone = $newVenuePhone;
	}

	/**
	 * gets the value of venue website
	 *
	 * @return string value of venue website
	 */
	public function getVenueWebsite() {
		return ($this->venueWebsite);
	}

	/**
	 * sets string value for venue website
	 *
	 * @param string $newVenueWebsite venue website
	 * @throws UnexpectedValueException if the input doesn't appear to be an URL
	 */
	public function setVenueWebsite($newVenueWebsite) {
		// sanitize teh VenueWebsite as a likely URL
		$newVenueWebsite = trim($newVenueWebsite);
		if(($newVenueWebsite = filter_var($newVenueWebsite, FILTER_VALIDATE_URL)) == false) {
			throw(new UnexpectedValueException("venue website $newVenueWebsite does not appear to be a valid URL"));
		}

		// then just take venue website out of quarantine
		$this->venueWebsite = $newVenueWebsite;
	}

	/**
	 * gets the value of address1
	 *
	 * @return string value of address1
	 */
	public function getVenueAddress1(){
		return ($this->venueAddress1);
	}

	/**
	 * sets the value of venueAddress1
	 *
	 * @param string $newVenueAddress1 venue address1
	 * @throws UnexpectedValueException if the input doesn't appear to be an address line 1
	 */
	public function setVenueAddress1($newVenueAddress1) {
		//sanitize the VenueAddress1 as a likely address line 1
		$newVenueAddress1 = trim($newVenueAddress1);
		if(($newVenueAddress1 = filter_var($newVenueAddress1, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("venueAddress1 $newVenueAddress1 does not appear to be an address1"));
		}

		// then just take the address1 out of quarantine
		$this->venueAddress1 = $newVenueAddress1;
	}

	/**
	 * gets the value of venueAddress2
	 *
	 * @return string value of venueAddress2
	 */
	public function getVenueAddress2(){
		return ($this->venueAddress2);
	}

	/**
	 * sets the value of venueAddress2
	 *
	 * @param string $newVenueAddress2 venue address2
	 * @throws UnexpectedValueException if the input doesn't appear to be an address line 2
	 */
	public function setVenueAddress2($newVenueAddress2) {
		//sanitize the VenueAddress2 as a likely address line 1
		$newVenueAddress2 = trim($newVenueAddress2);
		if(($newVenueAddress2 = filter_var($newVenueAddress2, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("venueAddress2 $newVenueAddress2 does not appear to be an address2"));
		}

		// then just take the address2 out of quarantine
		$this->venueAddress2 = $newVenueAddress2;
	}

	/**
	 * gets the value of venueCity
	 *
	 * @return string value of venueCity
	 */
	public function getVenueCity(){
		return ($this->venueCity);
	}

	/**
	 * sets the value of venueCity
	 *
	 * @param string $newVenueCity venue city
	 * @throws UnexpectedValueException if the input doesn't appear to be a city
	 */
	public function setVenueCity($newVenueCity) {
		//sanitize the VenueCity as a likely city
		$newVenueCity = trim($newVenueCity);
		if(($newVenueCity = filter_var($newVenueCity, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("venueCity $newVenueCity does not appear to be a city"));
		}

		// then just take the city out of quarantine
		$this->venueCity = $newVenueCity;
	}

	/**
	 * gets the value of venueState
	 *
	 * @return string value of venueState
	 */
	public function getVenueState(){
		return ($this->venueState);
	}

	/**
	 * sets the value of venueState
	 *
	 * @param string $newVenueState venue state
	 * @throws UnexpectedValueException if the input doesn't appear to be a 2 character state
	 */
	public function setVenueState($newVenueState) {
		//sanitize the VenueState as a likely US state
		$newVenueState = trim($newVenueState);
		$newVenueState = strlen(2);
		if(($newVenueState = filter_var($newVenueState, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("venueState $newVenueState does not appear to be a State"));
		}

		// then just take the venueState out of quarantine
		$this->venueState = $newVenueState;
	}

	/**
	 * gets the value for venueZipCode
	 *
	 * @return string value of venueZipCode
	 */
	public function getVenueZipCode() {
		return ($this->venueZipCode);
	}

	/**
	 * sets the value of venueZipCode
	 *
	 * @param string $newVenueZipCode venue zip code
	 * @throws UnexpectedValueException if the input does not appear to be a valid zip code
	 */
	public function setVenueZipCode($newVenueZipCode) {
		//sanitize the VenueZipCode as a likely US zip code
		$newVenueZipCode = trim($newVenueZipCode);
		if(($newVenueZipCode = filter_var($newVenueZipCode, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("venueZipCode $newVenueZipCode does not appear to be a US zip code"));
		}

		// then just take the zip code out of quarantine
		$this->venueZipCode = $newVenueZipCode;
	}

	/**
	 * inserts this Venue to mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the venueId is null (i.e. don't insert a venue that already exists)
		if($this->venueId !== null) {
			throw(new mysqli_sql_exception("not a new venue"));
		}

		// create query template
		$query = "INSERT INTO venue(venueName, venueCapacity, venuePhone, venueWebsite, venueAddress1, venueAddress2, venueCity, venueState, venueZipCode) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("sisssssss", $this->venueName, $this->venueCapacity, $this->venuePhone,
			$this->venueWebsite, $this->venueAddress1, $this->venueAddress2,
			$this->venueCity, $this->venueState, $this->venueZipCode);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			echo $statement->error . "<br />";
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null venueId with what mySQL jsut gave me
		$this->venueId = $mysqli->insert_id;
	}
		/**
		 * deletes this Venue from mySQL
		 *
		 * @param resource $mysqli pointer to mySQL connection, by reference
		 * @throws mysqli_sql_exception when mySQL related errors occur
		 */
		public function delete(&$mysqli) {
			// handle degenerate cases
			if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
				throw(new mysqli_sql_exception("input is not a mysqli object"));
			}

			// create query template
			$query = "DELETE FROM venue WHERE venueId = ?";
			$statement = $mysqli->prepare($query);
			if($statement === false) {
				throw(new mysqli_sql_exception("Unable to prepare statement"));
			}

			// execute the statement
			if($statement->execute() === false) {
				throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
			}
		}

		/**
		 * update this Venue in mySQL
		 *
		 * @param resource $mysqli pointer to mySQL connection, by reference
		 * @throws mysqli_sql_exception when mySQL related errors occur
		 */
		public function update(&$mysqli) {
			// handle degenerate cases
			if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
				throw(new mysqli_sql_exception("input not a mysqli object"));
			}

			// enforce the venueId is not null (i.e., don't update a venue that hasn't been created
			if($this->venueId === null) {
				throw(new mysqli_sql_exception("Unable to update a venue that does not exist"));
			}

			// create query template
			$query = "UPDATE venue SET venueName = ?, venueCapacity = ?, venuePhone = ?, venueWebsite = ?, venueAddress1 = ?, venueAddress2 = ?, venueCity = ?, venueState = ?, venueZipCode = ? WHERE venueId = ?";
			$statement = $mysqli->prepare($query);
			if($statement === false) {
				throw(new mysqli_sql_exception("Unable to prepare statement"));
			}

			// bind the member variables to the place holders in the template
			$wasClean = $statement->bind_param("sisssssss",	$this->venueName,		$this->venueCapacity,	$this->venuePhone,
																			$this->venueWebsite,	$this->venueAddress1,	$this->venueAddress2,
																			$this->venueCity,		$this->venueState,		$this->venueZipCode);
			if($wasClean === false) {
				throw(new mysqli_sql_exception("Unable to bind parameters"));
			}

			// execute the statement
			if($statement->execute() === false) {
				throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
			}
		}

	/**
	 * gets the Venue by VenueId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $venueId venueId to search for
	 * @return mixed Venue found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function getVenueByVenueId(&$mysqli, $venueId) {

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

	}







}

?>