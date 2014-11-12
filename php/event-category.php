<?php
/**
 * mySQL enabled eventCategory
 * This is a mySQL enabled container for event categories on a ticket site
 *
 * @author Sebastian Sandoval <sbsandoval42@gmail.com>
 */
class EventCategory{
	/** eventCategoryId for eventCategory; PRIMARY KEY */
private $eventCategoryId;
	/** eventCategory for eventCategory */
private $eventCategory;

	public function __construct($newEventCategoryId, $newEventCategory)	{
		try	{
			$this->setEventCategoryId($newEventCategoryId);
			$this->setEventCategory($newEventCategory);
		}
		catch(UnexpectedValueException $unexpectedValue)	{
			throw(new UnexpectedValueException("Unable to construct event-category", 0, $unexpectedValue));
		} catch(RangeException $range)	{
			throw(new RangeException("Unable to construct event-category", 0, $range));
		}
	}

	public function getEventCategoryId()	{
		return($this->eventCategoryId);
	}

	public function setEventCategoryId($newEventCategoryId)	{
		if($newEventCategoryId === null)	{
			$this->eventCategoryId = null;
			return;
		}

		if(filter_var($newEventCategoryId, FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("eventCategoryId $newEventCategoryId is not numeric"));
		}

		$newEventCategoryId = intval($newEventCategoryId);
		if($newEventCategoryId <= 0)	{
			throw(new RangeException("eventCategoryId $newEventCategoryId is not positive"));
		}

		$this->eventCategoryId = $newEventCategoryId;
	}

	public function getEventCategory()	{
		return($this->eventCategory);
	}

	public function setEventCategory($newEventCategory)	{
		if($newEventCategory === null)	{
			$this->eventCategory = null;
			return;
		}

		if(is_string($newEventCategory))	{
			throw(new RangeException("eventCategory $newEventCategory is not a string"));
		}

		$this->eventCategory = $newEventCategory;
	}

	public function insert(&$mysqli)	{
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		if($this->eventCategoryId !== null)	{
			throw(new mysqli_sql_exception("Not a new event category"));
		}

		$query = "INSERT INTO eventCategory(eventCategory) VALUES(?)";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$wasClean = $statement->bind_param("s", $this->eventCategory);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		$this->eventCategoryId = $mysqli->insert_id;
	}

	public function delete(&$mysqli)	{
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("Input is not a mysqli object"));
		}

		if($this->eventCategoryId === null)	{
			throw(new mysqli_sql_exception("Unable to delete an event category that does not exist"));
		}

		$query = "DELETE FROM eventCategory WHERE eventCategoryId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$wasClean = $statement->bind_param("i", $this->eventCategoryId);
		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}

	public function update(&$mysqli)	{
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli")	{
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		if($this->eventCategoryId === null)	{
			throw(new mysqli_sql_exception("Unable to update an eventCategory that does not exist"));
		}

		$query = "UPDATE eventCategory SET eventCategory = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false)	{
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		$wasClean = $statement->bind_param("s", $this->eventCategory);

		if($wasClean === false)	{
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		if($statement->execute() === false)	{
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}
}
?>