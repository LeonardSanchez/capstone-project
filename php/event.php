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
	 * venueId to create a 1 to n relationship; foreign key
	 */
	private $venueId;
	/**
	 * eventCategoryId from eventCategory; used for category searching
	 */
	private $eventCategoryId;
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
	public function __construct($newEventId, $newVenueId, $newEventCategoryId,
										 $newEventName, $newEventDateTime, $newTicketPrice){
		try{
			$this->setEventId($newEventId);
			$this->setVenueId($newVenueId);
			$this->setEventCategoryId($newEventCategoryId);
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
		 *
		 */
		if(gettype($newEventDateTime) === "object" && get_class($newEventDateTime) === "Date")	{
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
		$filterOptions = array("options" => array("regexp" => "/^[\d]{1,7}(\.\d\d)$/"));
		if(filter_var($newTicketPrice, FILTER_VALIDATE_REGEXP, $filterOptions) === false)	{
			throw(new RangeException("ticketPrice $newTicketPrice is not a dollar value"));
		}

		$this->ticketPrice = $newTicketPrice;
	}

	public function insert(&$mysqli)	{
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("not a valid mysqli object"));
		}

		if($this->eventId !== null) {
			throw(new mysqli_sql_exception("not a new event"));
		}

		$query = "INSERT INTO event(eventName, eventDateTime, ticketPrice) VALUES(?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$wasClean = $statement->bind_param("ssd", $this->eventName, $this->eventDateTime, $this->ticketPrice);

		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		$this->eventId = $mysqli->insert_id;

	}

	public function delete(&$mysqli)	{
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		if($this->eventId === null)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$query = "DELETE FROM event WHERE eventId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$wasClean = $statement->bind_param("i", $this->eventId);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

	}
	public function update(&$mysqli)	{
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		if($this->eventId)	{
			throw(new mysqli_sql_exception("Unable to update an event that does not exist"));
		}

		$query = "UPDATE event SET eventName = ?, eventDateTime = ?, ticketPrice = ? WHERE eventId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$wasClean = $statement->bind_param("ssd", $this->eventName, $this->eventDateTime, $this->ticketPrice);

		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	public function getEventByEventName(&$mysqli, $eventName)	{
		if(gettype($mysqli) !== "object"	||	get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		$eventName	=	trim($eventName);
		$eventName	=	filter_var($eventName, FILTER_SANITIZE_STRING);

		$query = "SELECT eventId, eventCategoryId, venueId, eventName, eventDateTime, ticketPrice FROM event WHERE eventName = ?";
		$statement = $mysqli->prepare($query);
	}

}
?>