<?php
/**
 * mySQL enabled event
 * This is a mySQL enabled container for an event listing on an event ticket site
 *
 * @author Sebastian Sandoval <sbsandoval42@gmail.com>
 */
class Event{
	/**
	 * eventId for Event; this is the primary key
	 */
	private $eventId;
	/**
	 * eventCategoryId from eventCategory; used for category searching
	 */
	private $eventCategoryId;
	/**
	 * venueId to create a 1 to n relationship; foreign key
	 */
	private $venueId;
	/**
	 * eventName for Event; Indexed for searching
	 */
	private $eventName;
	/**
	 * eventDateTime for Event; Indexed for date search and filtering
	 */
	private $eventDateTime;
	/**
	 * ticketPrice for Event checkout
	 */
	private $ticketPrice;

	/**
	 * constructor for Event
	 *
	 */
	public function __construct($newEventId, $newEventCategoryId, $newVenueId,
										 $newEventName, $newEventDateTime, $newTicketPrice){
		try{
			$this->setEventId($newEventId);
			$this->setEventCategoryId($newEventCategoryId);
			$this->setVenueId($newVenueId);
			$this->setEventName($newEventName);
			$this->setEventDateTime($newEventDateTime);
			$this->setTicketPrice($newTicketPrice);
		}	catch(UnexpectedValueException $unexpectedValue)	{
			/** Throw exception to user */
			throw(new UnexpectedValueException("unable to construct event", 0 , $unexpectedValue));
		}	catch(RangeException $range)	{
			throw(new RangeException("unable to construct event", 0 , $range));
		}
	}

	/**
	 * get eventId
	 * PRIMARY KEY
	 */
	public function getEventId() {
		return($this->eventId);
	}

	/**
	 * set eventId
	 * PRIMARY KEY
	 */
	public function setEventId($newEventId)	{
		/**
		 * set to null if it does not exist
		 */
		if($newEventId === null)	{
			$this->eventId = null;
			return;
		}

		/**
		 * filter to ensure eventId is an int
		 */
		if(filter_var($newEventId, FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("eventId $newEventId is not numeric"));
		}

		/**
		 * ensure eventId
		 */
		$newEventId = intval($newEventId);
		if($newEventId <= 0)	{
			throw(new RangeException("eventId $newEventId is not positive"));
		}

		/** passed all assign to eventId */
		$this->eventId = $newEventId;
	}

	/**
	 * get eventCategoryId
	 */
	public function getEventCategoryId()	{
		return($this->eventCategoryId);
	}

	/**
	 * set eventCategoryId
	 */
	public function setEventCategoryId($newEventCategoryId)	{
		/**
		 * set to null if eventCategoryId does not exist
		 */
		if($newEventCategoryId === null)	{
			$this->eventCategoryId = null;
			return;
		}

		/**
		 * validate eventCategoryId as int
		 */
		if(filter_var($newEventCategoryId, FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("eventCategoryId $newEventCategoryId is not numeric"));
		}

		/**
		 * ensure the eventCategoryId is positive
		 */
		$newEventCategoryId = intval(($newEventCategoryId));
		if($newEventCategoryId <= 0)	{
			throw(new RangeException("eventCategoryId $newEventCategoryId is not positive"));
		}

		/**
		 * passed all set to eventCategoryId
		 */
		$this->eventCategoryId = $newEventCategoryId;
	}

	/**
	 *get venueId
	 * FOREIGN KEY
	 */
	public function getVenueId(){
		return($this->venueId);
	}

	/**
	 * set venueId
	 * FOREIGN KEY
	 */
	public function setVenueId($newVenueId){
		/**
		 * set to null if venueId does not exist
		 */
		if($newVenueId === null)	{
			$this->venueId = null;
			return;
		}

		/**
		 * validate venueId as an int
		 */
		if(filter_var($newVenueId, FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("venueId $newVenueId is not numeric"));
		}

		/**
		 * ensure the venueId is positive
		 */
		$newVenueId = intval($newVenueId);
		if($newVenueId <= 0)	{
			throw(new RangeException("venueId $newVenueId is not positive"));
		}

		/**
		 * all tests pass assign to venueId
		 */
		$this->venueId = $newVenueId;
	}

	/**
	 * get eventName
	 */
	public function getEventName(){
		return($this->eventName);
	}

	/**
	 * set eventName
	 */
	public function setEventName($newEventName)	{
		/**
		 * ensure the eventName is a string
		 */
		if(is_string($newEventName) === false)	{
			throw(new UnexpectedValueException("eventName $newEventName is not a string"));
		}

		/**
		 * passed; assign to eventName
		 */
		$this->eventName = $newEventName;
	}

	/**
	 * get eventDateTime
	 */
	public function getEventDateTime()	{
		return($this->eventDateTime);
	}

	/**
	 * set eventDateTime
	 */
	public function setEventDateTime($newEventDateTime)	{
		/**
		 * if eventDateTime does not exist set to null
		 */
		if($newEventDateTime === null)	{
			$this->eventDateTime = null;
			return;
		}

		/**
		 * ensure $newEventDateTime is a DateTime object
		 */
		if(gettype($newEventDateTime) === "object" && get_class($newEventDateTime) === "DateTime")	{
			$this->eventDateTime = $newEventDateTime;
			return;
		}

		/**
		 * Check format for eventDateTime
		 */
		$newEventDateTime = trim($newEventDateTime);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newEventDateTime, $matches)) !== 1)	{
			throw(new RangeException("$newEventDateTime is not a valid date"));
		}

		/**
		 * ensure each date does not go over date values ie;2014/17/53
		 */
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		if(checkdate($month, $day, $year) === false)	{
			throw(new RangeException("$newEventDateTime is not a Gregorian date"));
		}

		$newEventDateTime = DateTime::createFromFormat ("Y-m-d H:i:s", $newEventDateTime);
		$this->eventDateTime = $newEventDateTime;
	}


	/**
	 * get ticketPrice
	 */
	public function getTicketPrice()	{
		return($this->ticketPrice);
	}

	/**
	 * set ticketPrice
	 */
	public function setTicketPrice($newTicketPrice)	{
		if($newTicketPrice === null)	{
			$this->ticketPrice = null;
			return;
		}

		/**
		 * filter for 0000000.00 dollar format
		 */
		if(filter_var($newTicketPrice, FILTER_VALIDATE_FLOAT) === false)	{
			throw(new RangeException("ticketPrice $newTicketPrice is not a dollar value"));
		}
		if($newTicketPrice < 0) {
			throw(new RangeException("ticketPrice $newTicketPrice is not a positive dollar value"));
		}

		$this->ticketPrice = floatval($newTicketPrice);
	}

	/**
	 * insert Event into mySQL database
	 */
	public function insert(&$mysqli)	{
		// ensure mysqli object
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("not a valid mysqli object"));
		}

		// check for existing events; throw exception if it exists
		if($this->eventId !== null) {
			throw(new mysqli_sql_exception("not a new event"));
		}

		// convert dates to strings
		if($this->eventDateTime === null) {
			$eventDateTime = null;
		} else {
			$eventDateTime = $this->eventDateTime->format("Y-m-d H:i:s");
		}

		/**
		 * query insert eventCategoryId, venueId, eventName, eventDateTime, ticketPrice
		 */
		$query = "INSERT INTO event(eventCategoryId, venueId, eventName, eventDateTime, ticketPrice) VALUES(?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		// check if $statement is prepared
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameters to statement
		$wasClean = $statement->bind_param("iissd", $this->eventCategoryId, $this->venueId, $this->eventName, $eventDateTime, $this->ticketPrice);

		// check if parameters were bound
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		//check if the statement was executed
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// set eventId as mysqli insert id; AUTO_INCREMENT
		$this->eventId = $mysqli->insert_id;

	}

	/**
	 * Delete an Event from mySQL database
	 * @param resource $mysqli pointer at mySQL connection, pointer by reference
	 * @throws mysqli_sql_exception when SQL errors occur
	 */
	public function delete(&$mysqli)	{
		// ensure mysqli object
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// check if event exists
		if($this->eventId === null)	{
			throw(new mysqli_sql_exception("Unable to delete an event that doesn't exist"));
		}

		// query template
		$query = "DELETE FROM event WHERE eventId = ?";
		$statement = $mysqli->prepare($query);
		// check prepared statement
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameters
		$wasClean = $statement->bind_param("i", $this->eventId);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		//execute statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

	}

	/**
	 * update a field in an event
	 * @param resource $mysqli pointer at mySQL connection, pointer by reference
	 * @throws mysqli_sql_exception when SQL errors occur
	 */
	public function update(&$mysqli)	{
		// ensure input is mysqli object
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// check if event exists
		if($this->eventId === null)	{
			throw(new mysqli_sql_exception("Unable to update an event that does not exist"));
		}

		// convert dates to strings
		if($this->eventDateTime === null) {
			$eventDateTime = null;
		} else {
			$eventDateTime = $this->eventDateTime->format("Y-m-d H:i:s");
		}

		// setup query
		$query = "UPDATE event SET eventCategoryId = ?, venueId = ?, eventName = ?, eventDateTime = ?, ticketPrice = ? WHERE eventId = ?";
		$statement = $mysqli->prepare($query);
		// prepare statement
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameters
		$wasClean = $statement->bind_param("iissdi", $this->eventCategoryId, $this->venueId, $this->eventName, $eventDateTime, $this->ticketPrice, $this->eventId);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * @param resource $mysqli pointer to mysqli connection, by reference
	 * @param string $eventName event name for search
	 * @throws mysqli_mysql_exception for sql errors
	 * @return array|object
	 */
	public function getEventByEventName(&$mysqli, $eventName)	{
		// check mysqli object
		if(gettype($mysqli) !== "object"	||	get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// trim and sanitize string
		$eventName	=	trim($eventName);
		$eventName	=	filter_var($eventName, FILTER_SANITIZE_STRING);

		// setup query
		$query = "SELECT eventId, eventCategoryId, venueId, eventName, eventDateTime, ticketPrice FROM event WHERE eventName LIKE ?";
		$statement = $mysqli->prepare($query);
		// prepare statement
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$eventName = "%$eventName%";
		$wasClean = $statement->bind_param("s", $eventName);
		// check bound parameters
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		// get results
		$result = $statement->get_result();
		if($result === false)	{
			throw(new mysqli_sql_exception("Unable to get result sets"));
		}

		// create events array for return
		$events = array();
		// get associative array
		while(($row = $result->fetch_assoc()) !== null)	{
			try	{
				// insert elements into rows
				$event		= new Event($row["eventId"], $row["eventCategoryId"], $row["venueId"],
												$row["eventName"], $row["eventDateTime"], $row["ticketPrice"]);
				// set to $events[] array
				$events[]	=	$event;
			}	catch(Exception $exception)	{
				// if the row was not able to be converted rethrow
				throw(new mysqli_sql_exception("Unable to convert row to Event", 0, $exception));
			}
		}

		// count result set and return
		$numberOfEvents = count($events);
		if($numberOfEvents === 0)	{
			return(null);
		}	else if($numberOfEvents === 1)	{
			return($events[0]);
		}	else	{
			return($events);
		}
	}

	/**
	 * @param resource $mysqli	pointer to mysqli
	 * @param DateTime $startDate start date for search
	 * @param Datetime $endDate	end date for search
	 * @return array|object
	 */
	public function getEventByEventDateTime(&$mysqli, $startDate, $endDate)	{
		// check mysqli object
		if(gettype($mysqli) !== "object"	||	get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// check DateTime object
		if(gettype($startDate) !== "object"	||	get_class($startDate) !== "DateTime")	{
			throw(new mysqli_sql_exception("input is not a Date object"));
		}
		if($startDate === null) {
			$startDate = null;
		} else {
			// format as DATE
			$startDate = $startDate->format("Y-m-d");
		}

		// repeat for endDate
		if(gettype($endDate) !== "object"	||	get_class($endDate) !== "DateTime")	{
			throw(new mysqli_sql_exception("input is not a Date object"));
		}
		if($endDate === null) {
			$endDate = null;
		} else {
			$endDate = $endDate->format("Y-m-d");
		}

		// setup query
		$query = "SELECT eventId, eventCategoryId, venueId, eventName, eventDateTime, ticketPrice FROM event WHERE CAST(eventDateTime AS DATE) >= ? AND CAST(eventDateTime AS DATE) <= ?";
		$statement = $mysqli->prepare($query);
		// check prepare statement
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameter
		$wasClean = $statement->bind_param("ss", $startDate, $endDate);

		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute mysqli statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get results
		$result = $statement->get_result();
		if($result === false)	{
			throw(new mysqli_sql_exception("Unable to get result sets"));
		}

		// create array for results
		$events = array();
		// fetch associative array and set it to events array
		while(($row = $result->fetch_assoc()) !== null)	{
			try	{
				$event		= new Event($row["eventId"], $row["eventCategoryId"], $row["venueId"],
					$row["eventName"], $row["eventDateTime"], $row["ticketPrice"]);
				$events[]	=	$event;
			}	catch(Exception $exception)	{
				// if the row was not able to be converted rethrow
				throw(new mysqli_sql_exception("Unable to convert row to Event", 0, $exception));
			}
		}

		// check number of events and return
		$numberOfEvents = count($events);
		if($numberOfEvents === 0)	{
			return(null);
		}	else if($numberOfEvents === 1)	{
			return($events[0]);
		}	else	{
			return($events);
		}
	}
}
?>