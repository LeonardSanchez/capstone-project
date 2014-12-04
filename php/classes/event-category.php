<?php
/**
 * mySQL enabled eventCategory
 * This is a mySQL enabled container for event categories on a ticket site
 *
 * @author Sebastian Sandoval <sbsandoval42@gmail.com>
 */
class EventCategory {
	/**
	 * eventCategoryId for eventCategory; PRIMARY KEY
	 */
private $eventCategoryId;
	/**
	 * eventCategory for eventCategory
	 */
private $eventCategory;
	/**
	 * parentCategory for eventCategory; can be null
	 */
private $parentCategory;


	/**
	 * constructor for Event Category
	 * @param mixed $newEventCategoryId event category id (or null if new object)
	 * @param string $newEventCategory event category
	 */
	public function __construct($newEventCategoryId, $newEventCategory, $newParentCategory)	{
		try	{
			$this->setEventCategoryId($newEventCategoryId);
			$this->setEventCategory($newEventCategory);
			$this->setParentCategory($newParentCategory);
		}
		catch(UnexpectedValueException $unexpectedValue)	{
			// rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct event-category", 0, $unexpectedValue));
		} catch(RangeException $range)	{
			// rethrow to the caller
			throw(new RangeException("Unable to construct event-category", 0, $range));
		}
	}

	/**
	 * gets the value of event category id
	 *
	 * @return mixed event category id (or null if new object)
	 */
	public function getEventCategoryId()	{
		return($this->eventCategoryId);
	}

	/**
	 * sets the value of event category id
	 * @param $newEventCategoryId
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if event category id isn't positive
	 */
	public function setEventCategoryId($newEventCategoryId)	{
		// zeroth, set allow the event category id to be null if a new object
		if($newEventCategoryId === null)	{
			$this->eventCategoryId = null;
			return;
		}

		// first, ensure the event category id is an integer
		if(filter_var($newEventCategoryId, FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("eventCategoryId $newEventCategoryId is not numeric"));
		}

		// second, convert the event category id to an integer and enforce its positive
		$newEventCategoryId = intval($newEventCategoryId);
		if($newEventCategoryId <= 0)	{
			throw(new RangeException("eventCategoryId $newEventCategoryId is not positive"));
		}

		// finally, take the event category id out of quarantine
		$this->eventCategoryId = $newEventCategoryId;
	}

	/**
	 * get the value of event category
	 * @return string value of event category
	 */
	public function getEventCategory()	{
		return($this->eventCategory);
	}

	/**
	 * sets the value of event category
	 * @param  string $newEventCategory event category
	 * @throws UnexpectedValueException if the input doesn't appear to be an event category string
	 */
	public function setEventCategory($newEventCategory)	{
		// zeroth, set allow the event category to be null if new object
		if($newEventCategory === null)	{
			$this->eventCategory = null;
			return;
		}

		// first, ensure the event category is a string
		if(is_string($newEventCategory) === false)	{
			throw(new RangeException("eventCategory $newEventCategory is not a string"));
		}

		// finally, take the event category out of quarantine and assign it
		$this->eventCategory = $newEventCategory;
	}

	/**
	 * get the value of parent category
	 * @return int value of parent category
	 */
	public function getParentCategory() {
		return($this->parentCategory);
	}

	/**
	 * sets the value of parent category
	 * @param int $newParentCategory parent category
	 * @throws UnexpectedValueException if the input doesn't appear to be a parent category int
	 */
	public function setParentCategory($newParentCategory) {
		// zeroth, set allow the parent category to be null if it is a parent category
		if($newParentCategory === null) {
			$this->parentCategory = null;
			return;
		}

		// first, ensure the parent category is an integer
		if(filter_var($newParentCategory, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("parentCategory $newParentCategory is not numeric"));
		}

		// second, convert the parentCategory to an integer and enforce it's positive
		$newParentCategory = intval($newParentCategory);
		if($newParentCategory <= 0) {
			throw(new RangeException("parentCategory $newParentCategory is not positive"));
		}

		// finally, take the parentCategory out of quarantine
		$this->parentCategory = $newParentCategory;
	}

	/**
	 * inserts this EventCategory to mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function insert(&$mysqli)	{

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// enforce the eventCategoryId is null (i.e. don't insert an eventCategory that already exist
		if($this->eventCategoryId !== null)	{
			throw(new mysqli_sql_exception("Not a new event category"));
		}

		// create query template
		$query = "INSERT INTO eventCategory(eventCategory, parentCategory) VALUES(?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("si", $this->eventCategory, $this->parentCategory);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		// update the null eventCategoryId with what mySQL just gave us
		$this->eventCategoryId = $mysqli->insert_id;
	}

	/**
	 * deletes this EventCategory from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function delete(&$mysqli)	{
		// handle the degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// enforce the eventCategoryId is not null (i.e. don't delete an eventCategory that hasn't been inserted)
		if($this->eventCategoryId === null)	{
			throw(new mysqli_sql_exception("Unable to delete an event category that does not exist"));
		}


		// create query template
		$query = "DELETE FROM eventCategory WHERE eventCategoryId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind member variables to the place holders in the template
		$wasClean = $statement->bind_param("i", $this->eventCategoryId);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}

	/**
	 * updates this EventCategory in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throw mysqli_sql_exception when mySQL related errors occur
	 */
	public function update(&$mysqli)	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the eventCategoryId is not null (i.e. don't update a profile that hasn't been inserted)
		if($this->eventCategoryId === null)	{
			throw(new mysqli_sql_exception("Unable to update an eventCategory that does not exist"));
		}


		// create query template
		$query = "UPDATE eventCategory SET eventCategory = ?, parentCategory = ? WHERE eventCategoryId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}


		// bind member variables to the place holders in the template
		$wasClean = $statement->bind_param("sii", $this->eventCategory, $this->parentCategory, $this->eventCategoryId);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}

	/**
	 * gets the EventCategory by EventCategoryId
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param mixed $eventCategoryId Event Category Id to search for
	 * @return array|null
	 * @return EventCategory found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public static function getEventCategoryByEventCategoryId(&$mysqli, $eventCategoryId){
		// handle degenerate cases
		if(gettype($mysqli) !== "object" | get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// sanitize the eventCategoryId before searching
		if(($eventCategoryId = filter_var($eventCategoryId, FILTER_VALIDATE_INT)) == false) {
			throw(new mysqli_sql_exception("Event Category does not appear to be an integer"));
		}

		// create query template
		$query = "SELECT eventCategoryId, eventCategory, parentCategory FROM eventCategory WHERE eventCategoryId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $eventCategoryId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		// get result from the SELECT query *pounds fists*
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is a primary key, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into an Event Category object normally
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc returns a row as an associative array

		// convert the associative array to an Event Category
		if($row !== null) {
			try {
				$eventCategory = new EventCategory($row["eventCategoryId"], $row["eventCategory"], $row["parentCategory"]);
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Event Category", 0, $exception));
			}

			// if we got here, the Event Category is good - return it
			return ($eventCategory);
		} else {
			// 404 venue not found - return null instead
			return (null);
		}
	}


	/**
	 * gets the EventCategory by EventCategory
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param string $eventCategory Event Category to search for
	 * @return array|null
	 * @return EventCategory found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public static function getEventCategoryByEventCategory(&$mysqli, $eventCategory)	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object"	|| get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// sanitize the eventCategory before searching
		$eventCategory = trim($eventCategory);
		$eventCategory = filter_var($eventCategory, FILTER_SANITIZE_STRING);

		// create query template
		$query = "SELECT eventCategoryId, eventCategory, parentCategory FROM eventCategory WHERE eventCategory = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind member variables to the place holder in the template
		$wasClean = $statement->bind_param("s", $eventCategory);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		// get result from the SELECT query
		$results = $statement->get_result();
		if($results === false)	{
			throw(new mysqli_sql_exception("Unable to get result set"));
		}
		// since this is not a unique field, this can return many results. So...
		// 1) if there's more than 1 result, we can make all into Event Category objects
		// 2) if there's no result, we can just return null
		if($results->num_rows > 0) {
			$results = $results->fetch_all(MYSQLI_ASSOC);
			if($results === false) {
				throw(new mysqli_sql_exception("Unable to get result set"));
			}
			foreach($results as $index => $row) {
				$results[$index] = new EventCategory($row["eventCategoryId"], $row["eventCategory"], $row["parentCategory"]);
			}
			return($results);
		} else {
			return(null);
		}

	}

	/**
	 * gets Event Category by Parent Category
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param int $parentCategory Parent Category to search by
	 * @return array | null
	 * @return EventCategory found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function getEventCategoryByParentCategory(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object"	|| get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// throw an exception when parentCategory is null
		if($this->parentCategory === null) {
			throw(new mysqli_sql_exception("Object is a Parent Event"));
		}

		// create query template
		$query = "SELECT eventCategoryId, eventCategory, parentCategory FROM eventCategory WHERE parentCategory = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare query"));
		}

		// bind member variables to the place holder in the statement
		$wasClean = $statement->bind_param("i", $this->parentCategory);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		// get result from the SELECT query
		$results = $statement->get_result();
		if($results === false)	{
			throw(new mysqli_sql_exception("Unable to get result set"));
		}
		// since this is not a unique field, this can return many results. So...
		// 1) if there's more than 1 result, we can make all into Event Category objects
		// 2) if there's no result, we can just return null
		if($results->num_rows > 0) {
			$results = $results->fetch_all(MYSQLI_ASSOC);
			if($results === false) {
				throw(new mysqli_sql_exception("Unable to get result set"));
			}
			foreach($results as $index => $row) {
				$results[$index] = new EventCategory($row["eventCategoryId"], $row["eventCategory"], $row["parentCategory"]);
			}
			return($results);
		} else {
			return(null);
		}
	}

	/**
	 * get Event Category by All Parent Categories
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param int $parentCategory Parent Category where values equivalent to null
	 * @return array | null
	 * @return Event Category found or null if not found
	 * @throw mysqli_sql_exception when mySQL related errors occur
	 */
	public static function getEventCategoryByAllParentEvents(&$mysqli, $parentCategory) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object"	|| get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		// sanitize the parentCategory
		if(($parentCategory = filter_var($parentCategory, FILTER_VALIDATE_INT)) == false) {
			throw(new mysqli_sql_exception("Parent Category does not appear to be an integer"));
		}

		// create query template
		$query = "SELECT eventCategoryId, eventCategory, parentCategory FROM eventCategory WHERE parentCategory IS NULL";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind member variables to place holder in statement
		$wasClean = $statement->bind_param("i", $parentCategory);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		// get result from the SELECT query
		$results = $statement->get_result();
		if($results === false)	{
			throw(new mysqli_sql_exception("Unable to get result set"));
		}
		// since this is not a unique field, this can return many results. So...
		// 1) if there's more than 1 result, we can make all into Event Category objects
		// 2) if there's no result, we can just return null
		if($results->num_rows > 0) {
			$results = $results->fetch_all(MYSQLI_ASSOC);
			if($results === false) {
				throw(new mysqli_sql_exception("Unable to get result set"));
			}
			foreach($results as $index => $row) {
				$results[$index] = new EventCategory($row["eventCategoryId"], $row["eventCategory"], $row["parentCategory"]);
			}
			return($results);
		} else {
			return(null);
		}
	}

	/**
	 * gets Event Category by All Children of Parent Categories
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @param mixed eventCategoryId Event Category Id where it equals itself
	 * @return array | null
	 * @return Event Category found or null if not found
	 * @throw mysqli_sql_exception when mySQL related errors occur
	 */
	public function getEventCategoryByAllChildEvents(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object"	|| get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		if($this->parentCategory !== null) {
			throw(new mysqli_sql_exception("Object is a Parent Event"));
		}

		// create query template
		$query = "SELECT eventCategoryId, eventCategory, parentCategory FROM eventCategory WHERE parentCategory = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind member variables to the place holders in template
		$wasClean = $statement->bind_param("i", $this->eventCategoryId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute the statement"));
		}

		// get result from the SELECT query
		$results = $statement->get_result();
		if($results === false)	{
			throw(new mysqli_sql_exception("Unable to get result set"));
		}
		// since this is not a unique field, this can return many results. So...
		// 1) if there's more than 1 result, we can make all into Event Category objects
		// 2) if there's no result, we can just return null
		if($results->num_rows > 0) {
			$results = $results->fetch_all(MYSQLI_ASSOC);
			if($results === false) {
				throw(new mysqli_sql_exception("Unable to get result set"));
			}
			foreach($results as $index => $row) {
				$results[$index] = new EventCategory($row["eventCategoryId"], $row["eventCategory"], $row["parentCategory"]);
			}
			return($results);
		} else {
			return(null);
		}
	}
}
?>