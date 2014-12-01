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
	 * constructor for Event Category
	 * @param mixed $newEventCategoryId event category id (or null if new object)
	 * @param string $newEventCategory event category
	 */
	public function __construct($newEventCategoryId, $newEventCategory)	{
		try	{
			$this->setEventCategoryId($newEventCategoryId);
			$this->setEventCategory($newEventCategory);
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
	 * @throws UnexpectedValueException if the input doesn't appear to be a event category string
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
		$query = "INSERT INTO eventCategory(eventCategory) VALUES(?)";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("s", $this->eventCategory);
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
		$query = "UPDATE eventCategory SET eventCategory = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}


		// bind member variables to the place holders in the template
		$wasClean = $statement->bind_param("s", $this->eventCategory);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}

	/**
	 * gets the EventCategory by EventCategory
	 *
	 * @param resour
	 *
	 * ce $mysqli pointer to mySQL connection, by reference
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
		$query = "SELECT eventCategoryId, eventCategory FROM eventCategory WHERE eventCategory = ?";
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
		$result = $statement->get_result();
		if($result === false)	{
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// create an array to return all instances of search match
		$eventCategories = array();
		while(($row = $result->fetch_assoc()) !== null)	{
			try	{
				$eventCategory = new EventCategory($row["eventCategoryId"], $row["eventCategory"]);
				$eventCategories[]	=	$eventCategory;
			}
			catch(Exception $exception)	{
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to eventCategory", 0, $exception));
			}
		}

		// get the count of number of matches from array
		$numberOfEventCategories = count($eventCategories);
		if($numberOfEventCategories === 0)	{
			return(null);
		} else if($numberOfEventCategories === 1){
			return($eventCategories[0]);
		}	else	{
			return($eventCategories);
		}
	}
}
?>