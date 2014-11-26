<?php
/**
 * mySQL Enabled Barcode
 *
 * This is a mySQL enabled container for Barcode data for Red or Green Events
 *
 * @author Brendan Slevin
 **/
class Barcode
{
	/**
	 * barcode id for the barcode; this is the primary key
	 **/
	private $barcodeId;

	/**
	 * ticket id for the barcode; this is a foreign key
	 **/
	private $ticketId;

	/**
	 * constructor for Barcode
	 *
	 * @param mixed $newBarcodeId barcode id (or null if new barcode)
	 * @param mixed $newTicketId  ticket id (maybe null if new ticket)
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws RangeException when a parameter is invalid
	 **/
	public function __construct($newBarcodeId, $newTicketId)
	{
		try {
			$this->setBarcodeId($newBarcodeId);
			$this->setTicketId($newTicketId);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to caller
			throw(new UnexpectedValueException("Unable to construct Barcode", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to caller
			throw(new RangeException("Unable to construct Barcode", 0, $range));
		}
	}

	/**
	 * gets the value of barcode id
	 *
	 * @return mixed barcode id (or null if new object)
	 **/
	public function getBarcodeId()
	{
		return ($this->barcodeId);
	}

	/**
	 * sets the value of barcode id
	 *
	 * @param mixed $newBarcodeId barcode id (or null if new barcode)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if barcode id isn't positive
	 **/
	public function setBarcodeId($newBarcodeId)
	{
		// set allow the barcode id to be null if a new object
		if($newBarcodeId === null) {
			$this->barcodeId = null;
			return;
		}

		// ensure the barcode id is an integer
		if(filter_var($newBarcodeId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("barcode id $newBarcodeId is not numeric"));
		}

		// convert convert the barcode id to an integer and enforce it's positive
		$newBarcodeId = intval($newBarcodeId);
		if($newBarcodeId <= 0) {
			throw(new RangeException("barcode id $newBarcodeId is not positive"));
		}

		// take the barcode id out of quarantine and assign it
		$this->barcodeId = $newBarcodeId;

	}

	/**
	 * gets the value of ticket id
	 *
	 * @return mixed ticket id (or null if new ticket)
	 **/
	public function getTicketId()
	{
		return ($this->ticketId);
	}

	/**
	 *sets the value of the ticket id
	 *
	 * @param mixed $newTicketId
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if ticket id is not positive
	 **/
	public function setTicketId($newTicketId)
	{
		// allow the ticket id to be null if a new object
		if($newTicketId === null) {
			$this->ticketId = null;
			return;
		}

		// ensure the ticket id is an integer
		if(filter_var($newTicketId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("ticket id $newTicketId is not numeric"));
		}

		// convert convert the ticket id to an integer and enforce it's positive
		$newTicketId = intval($newTicketId);
		if($newTicketId <= 0) {
			throw(new RangeException("ticket id $newTicketId is not positive"));
		}

		// take the ticket id out of quarantine and assign it
		$this->ticketId = $newTicketId;

	}

	/**
	 * insert this Barcode into mySQL
	 *
	 * @param resource mySQL pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors
	 **/
	public function insert(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the barcodeId is null (don't insert a barcode that already exists)
		if($this->barcodeId !== null) {
			throw(new mysqli_sql_exception("not a new barcode"));
		}

		// create query table
		$query = "INSERT INTO barcode(ticketId) VALUES(?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("i", $this->ticketId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null barcodeId with what mySQL just gave us
		$this->barcodeId = $mysqli->insert_id;


	}

	/**
	 * delete this transaction from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function delete(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not an mysqli object"));
		}

		// enforce the barcode id is not null
		if($this->barcodeId === null) {
			throw(mysqli_sql_exception("Unable to delete barcode that does not exist"));
		}

		// create query template
		$query = "DELETE FROM barcode WHERE barcodeId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->barcodeId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * updates this barcode in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function update(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not an mysqli object"));
		}

		// enforce the barcodeId is not null
		if($this->barcodeId === null) {
			throw(new mysqli_sql_exception("Unable to update a barcode that doesn't exist"));
		}

		// create query template
		$query = "UPDATE barcode SET ticketId = ? WHERE barcodeId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ii", $this->ticketId, $this->barcodeId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	public static function getBarcodeByTicketId(&$mysqli, $ticketId)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the ticketId before searching
		$ticketId = filter_var($ticketId, FILTER_SANITIZE_NUMBER_INT);

		// create query template
		$query = "SELECT barcodeId, ticketId FROM barcode WHERE ticketId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the ticketId to the place holder in the template
		$wasClean = $statement->bind_param("i", $ticketId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}

		// get the result from the SELECT query
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is a foreign key, this will return one result at most
		// if there's a result, we can make it into a Barcode object normally
		// if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch assoc() returns a row as an associative array

		// convert the associative array to a Barcode
		if($row !== null) {
			try {
				$barcode = new Barcode($row["barcodeId"], $row["ticketId"]);
			} catch(Exception $exception) {
				// if row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Barcode", 0, $exception));
			}

			// if we get here, the Barcode is good return it
			return ($barcode);
		} else {
			// 404 Barcode not found return null
			return (null);
		}

	}
}
?>