<?php
/**
 * mySQL enabled event-link
 *
 * this is a mySQL enabled container for creating a many to many relationship
 * @author Sebastian Sandoval <sbsandoval42@gmail.com>
 */

class EventLink	{
	/**
	 * foreign key from EventCategory
	 */
	private $eventCategoryId;
	/**
	 * foreign key from Event
	 */
	private $eventId;

	/**
	 * @param int $newEventCategoryId foreign key for link from EventCategory
	 * @param int $newEventId foreign key for link from Event
	 */
	public function __construct($newEventCategoryId, $newEventId)	{
		try	{
			$this->setEventCategoryId($newEventCategoryId);
			$this->setEventId($newEventId);
		}
		// Unexpected value
		catch(UnexpectedValueException $unexpectedValue)	{
			// rethrow to caller
			throw(new UnexpectedValueException("Unable to construct EventLink", 0, $unexpectedValue));
		}
		// Not within range
		catch(RangeException $range)	{
			// rethrow to caller
			throw(new RangeException("Unable to construct EventLink", 0, $range));
		}
	}

	/**
	 * gets the value of eventCategoryId
	 *
	 * @return int eventCategoryId
	 */
	public function getEventCategoryId()	{
		// return eventCategoryId
		return($this->eventCategoryId);
	}

	/**
	 * sets the value of eventCategoryId or sets it to null if it does not exist
	 *
	 * @param int $newEventCategoryId
	 */
	public function setEventCategoryId($newEventCategoryId)	{
		// set to null if eventCategory does not exist
		if($newEventCategoryId === null)	{
			$this->eventCategoryId = null;
			return;
		}

		// validate $newEventCategoryId as an int
		if(filter_var($newEventCategoryId, FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("eventCategoryId $newEventCategoryId is not numeric"));
		}

		// enforce $newEventCategoryId is positive
		if($newEventCategoryId <= 0)	{
			throw(new RangeException("eventCategoryId $newEventCategoryId is not positive"));
		}

		// return value
		$this->eventCategoryId = $newEventCategoryId;
	}

	/**
	 * gets the value of eventId
	 *
	 * @return int eventId
	 */

	public function getEventId()	{
		return($this->eventId);
	}

	/**
	 * sets eventId or sets it to null if event does not exist
	 *
	 * @param int $newEventId
	 */
	public function setEventId($newEventId)	{
		// set to null if event does not exist
		if($newEventId === null)	{
			$this->eventId = null;
			return;
		}

		// validate $newEventId as int
		if(filter_var($newEventId, FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("eventId $newEventId is not numeric"));
		}

		// enforce $newEventId is positive
		if($newEventId <= 0) {
			throw(new RangeException("eventId $newEventId is not positive"));
		}

		// return value
		$this->eventId = $newEventId;
	}

	public function insert(&$mysqli)	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new UnexpectedValueException("input is not a mysqli object"));
		}

		// assert this eventLink doesn't exist

		if($this->eventCategoryId === null && $this->eventId === null)	{
			throw(new UnexpectedValueException("Not a new event link"));
		}

		// create query
		$query = "INSERT INTO eventLink(eventCategoryId, eventId) VALUES(?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameters
		$wasClean = $statement->bind_param("ii", $this->eventCategoryId, $this->eventId);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute statement
		if($statement->execute() === false)	{ var_dump($statement->error); var_dump($this);
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}

	/**
	 * deletes this eventLink from mySQL
	 *
	 * @param resource $mysqli pointer to mysqli connection
	 * @throws mysqli_sql_exception when mysql related errors occur
	 */
	public function delete(&$mysqli)	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// enforce eventCategoryId and eventId are not null
		if($this->eventCategoryId === null && $this->eventId === null)	{
			throw(new mysqli_sql_exception("Unable to delete a link that does not exist"));
		}

		// create query template
		$query = "DELETE FROM eventLink WHERE eventCategoryId = ? AND eventId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameters
		$wasClean = $statement->bind_param("ii", $this->eventCategoryId, $this->eventId);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}

	/**
	 * gets eventLink by eventCategoryId
	 *
	 * @param resource $mysqli pointer to mySQL connection
	 * @param int $eventCategoryId event category id to search for
	 * @return array|object for results
	 * @return eventLink by eventCategoryId or null if no results
	 * @throws mysqli_sql_exception when mysql error occurs
	 */
	public function getEventLinkByEventCategoryId(&$mysqli, $eventCategoryId)	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// sanitize as int and ensure it is positive
		$eventCategoryId = filter_var($eventCategoryId, FILTER_SANITIZE_NUMBER_INT);
		if($eventCategoryId <= 0)	{
			throw(new RangeException("Input eventCategoryId is not positive"));
		}

		// create query template
		$query = "SELECT eventCategoryId, eventId FROM eventLink WHERE eventCategoryId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameters
		$wasClean = $statement->bind_param("i", $eventCategoryId);
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
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// create an array to return all instances of search match
		$eventLinks = array();
		while(($row =$result->fetch_assoc()) !== null)	{
			try	{
				$eventLink = new EventLink($row["eventCategoryId"], $row["eventId"]);
				$eventLinks[] = $eventLink;
			}
			catch(Exception $exception)	{
				// if the row could not be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to eventLink", 0, $exception));
			}
		}

		$numberOfEventLinks = count($eventLinks);
		if($numberOfEventLinks === 0)	{
			return(null);
		}	else	{
			return($eventLinks);
		}
	}

	/**
	 * gets eventLink by eventId
	 *
	 * @param resource $mysqli pointer to mysql connection
	 * @param int $eventId eventId that is being searched
	 * @return array|object results
	 * @return eventLink by eventId or null if no results
	 * @throws mysqli_sql_exception when mysql error occurs
	 */
	public function getEventLinkByEventId(&$mysqli, $eventId)	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		$eventId = filter_var($eventId, FILTER_SANITIZE_NUMBER_INT);
		if($eventId <= 0)	{
			throw(new RangeException("Input eventId is not positive"));
		}

		// create query template
		$query = "SELECT eventCategoryId, eventId FROM eventLink WHERE eventId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameters
		$wasClean = $statement->bind_param("i", $eventId);
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
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// create an array to return all instances of search match
		$eventLinks = array();
		while(($row =$result->fetch_assoc()) !== null)	{
			try	{
				$eventLink = new EventLink($row["eventCategoryId"], $row["eventId"]);
				$eventLinks[] = $eventLink;
			}
			catch(Exception $exception)	{
				// if the row could not be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to eventLink", 0, $exception));
			}
		}

		$numberOfEventLinks = count($eventLinks);
		if($numberOfEventLinks === 0)	{
			return(null);
		}	else	{
			return($eventLinks);
		}
	}

	/**
	 * gets eventLink by eventId
	 *
	 * @param resource $mysqli pointer to mysql connection
	 * @param int $eventCategoryId eventCategoryId that is being searched
	 * @param int $eventId eventId that is being searched
	 * @return array|object results
	 * @return eventLink by eventId or null if no results
	 * @throws mysqli_sql_exception when mysql error occurs
	 */
	public function getEventLinkByEventCategoryIdAndEventId(&$mysqli, $eventCategoryId, $eventId)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// sanitize Ids and ensure they are positive
		$eventCategoryId = filter_var($eventCategoryId, FILTER_SANITIZE_NUMBER_INT);
		if($eventCategoryId <= 0) {
			throw(new RangeException("Input eventId is not positive"));
		}
		$eventId = filter_var($eventId, FILTER_SANITIZE_NUMBER_INT);
		if($eventId <= 0) {
			throw(new RangeException("Input eventId is not positive"));
		}

		// create query template
		$query = "SELECT eventCategoryId, eventId FROM eventLink WHERE eventCategoryId = ? AND eventId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind parameters
		$wasClean = $statement->bind_param("ii", $eventCategoryId, $eventId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		// get results
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// create an array to return all instances of search match
		$eventLinks = array();
		while(($row = $result->fetch_assoc()) !== null) {
			try {
				$eventLink = new EventLink($row["eventCategoryId"], $row["eventId"]);
				$eventLinks[] = $eventLink;
			} catch(Exception $exception) {
				// if the row could not be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to eventLink", 0, $exception));
			}
		}

		$numberOfEventLinks = count($eventLinks);
		if($numberOfEventLinks === 0) {
			return (null);
		} else {
			return ($eventLinks);
		}
	}
}