<?php
/**
 * class for transaction
 *
 * created by Brendan
 **/
class Transaction
{
	/**
	 * transaction id for the transaction; this is the primary key
	 **/
	private $transactionId;
	/**
	 * the profile id links to the transaction class/table and is a foreign key
	 **/
	private $profileId;
	/**
	 * the ticket id links to the transaction class and is a foreign key
	 */
	private $ticketId;
	/**
	 * the monetary amount for the transaction
	 **/
	private $amount;
	/*
	 * the date that the transaction was approved
	 **/
	private $dateApproved;


	/**
	 * constructor for the Transaction class
	 *
	 * @param mixed $newTransactionId (or null if new transaction)
	 * @param float $newAmount
	 * @param mixed $newDateApproved
	 * @param mixed $newProfileId
	 * @param mixed $newTicketId
	 * @throws UnexpectedValueException when a parameter is not the right type
	 * @throws RangeException when a parameter is invalid
	 **/
	public function __construct($newTransactionId, $newProfileId, $newTicketId, $newAmount, $newDateApproved)
	{
		try {
			$this->setTransactionId($newTransactionId);
			$this->setProfileId($newProfileId);
			$this->setTicketId($newTicketId);
			$this->setAmount($newAmount);
			$this->setDateApproved($newDateApproved);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to caller
			throw(new UnexpectedValueException("Unable to construct Transaction", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to caller
			throw(new RangeException("Unable to construct Transaction", 0, $range));
		}
	}

	/**
	 * gets the value of transaction id
	 *
	 * @return mixed transaction id (or null if new)
	 **/
	public function getTransactionId()
	{
		return ($this->transactionId);
	}

	/**
	 * sets the value of the transaction id
	 *
	 * @param mixed $newTransactionId transaction id (or null if new)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if transaction id is not positive
	 **/
	public function setTransactionId($newTransactionId)
	{
		// set allow the transaction id to be null if a new object
		if($newTransactionId === null) {
			$this->transactionId = null;
			return;
		}

		// ensure the transaction id is an integer
		if(filter_var($newTransactionId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Transaction id $newTransactionId is not numeric"));
		}

		// convert the transaction id not an integer and enforce it's positive
		$newTransactionId = intval($newTransactionId);
		if($newTransactionId <= 0) {
			throw(new RangeException("transaction id $newTransactionId is not positive"));
		}

		// take the transaction id out of quarantine and assign it
		$this->transactionId = $newTransactionId;

	}

	/**
	 * gets the value of amount
	 *
	 * @return float amount
	 **/
	public function getAmount()
	{
		return ($this->amount);
	}

	/**
	 * sets the value of the amount
	 *
	 * @param float $newAmount amount
	 * @throws UnexpectedValueException if not a double
	 * @throws RangeException if amount is not positive
	 **/
	public function setAmount($newAmount)
	{
		// ensure the amount is a double
		if(filter_var($newAmount, FILTER_VALIDATE_FLOAT) === false) {
			throw(new UnexpectedValueException("amount $newAmount is not a float"));
		}

		// convert the amount to a double and enforce it's positive
		$newAmount = floatval($newAmount);
		if($newAmount <= 0) {
			throw(new RangeException("amount $newAmount is not positive"));
		}

		// take the amount out of quarantine and assign it
		$this->amount = $newAmount;

	}

	/**
	 * gets the value of the date
	 *
	 * @return mixed date approved
	 **/
	public function getDateApproved()
	{
		return ($this->dateApproved);
	}

	/**
	 * sets the value of the date created
	 *
	 * @param mixed $newDateApproved object or string with the date created
	 * @throws RangeException if the date is not a valid date
	 **/
	public function setDateApproved($newDateApproved)
	{
		// allow the date to be null if a new object
		if($newDateApproved === null) {
			$this->dateApproved = null;
			return;
		}

		// allow a DateTime object to be directly assigned
		if(gettype($newDateApproved) === "object" && get_class($newDateApproved) === "DateApproved") {
			$this->dateApproved = $newDateApproved;
			return;
		}

		// treat the date as a mySQL date string
		$newDateApproved = trim($newDateApproved);
		if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newDateApproved, $matches)) !== 1) {
			throw(new RangeException("$newDateApproved is not a valid date"));
		}

		// verify the date is really a valid calendar date
		$year = intval($matches[1]);
		$month = intval($matches[2]);
		$day = intval($matches[3]);
		if(checkdate($month, $day, $year) === false) {
			throw(new RangeException("$newDateApproved is not a Gregorian date"));
		}

		// take the date out of quarantine
		$newDateApproved = DateTime::createFromFormat("Y-m-d H:i:s", $newDateApproved);
		$this->dateApproved = $newDateApproved;
	}

	/**
	 * gets the value of the profile id
	 *
	 * @return mixed profile id
	 **/
	public function getProfileId()
	{
		return ($this->profileId);
	}

	/**
	 * sets the value of the profile id
	 * @param mixed $newProfileId
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id is not positive
	 **/
	public function setProfileId($newProfileId)
	{
		// allow the profile id to be null if a new object
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// ensure the profile id is an integer
		if(filter_var($newProfileId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("profile id $newProfileId is not numeric"));
		}

		// convert the profile id to an integer and enforce that it is positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("profile id $newProfileId is not positive"));
		}

		// take the profile id out of quarantine and assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * gets the value of the ticket id
	 *
	 * @return mixed ticket id
	 **/
	public function getTicketId()
	{
		return ($this->ticketId);
	}

	/**
	 * sets the value of the ticket id
	 * @param mixed $newTicketId
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if profile id is not positive
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

		// convert the ticket id to an integer and enforce that it is positive
		$newTicketId = intval($newTicketId);
		if($newTicketId <= 0) {
			throw(new RangeException("ticket id $newTicketId is not positive"));
		}

		// take the ticket id out of quarantine and assign it
		$this->ticketId = $newTicketId;
	}

	/**
	 * inserts this transaction to mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public function insert(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the transactionId is null (don't want to insert a transaction that already exists)
		if($this->transactionId !== null) {
			throw(new mysqli_sql_exception("not a new transaction"));
		}

		// convert dates to strings
		if($this->dateApproved === null) {
			$dateApproved = null;
		} else {
			$dateApproved = $this->dateApproved->format("Y-m-d H:i:s");
		}

		// create query template
		$query = "INSERT INTO transaction(profileId, ticketId, amount, dateApproved) VALUES(?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("iids", $this->profileId, $this->ticketId, $this->amount, $dateApproved);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null transactionId with what mySQL just gave us
		$this->transactionId = $mysqli->insert_id;


	}

	/**
	 * Deletes this transaction from mySQL
	 *
	 * Here you go SCRUM Master
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function delete(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the transaction id is not null
		if($this->transactionId === null) {
			throw(new mysqli_sql_exception("Unable to delete a transaction that does not exist"));
		}

		// create query template
		$query = "DELETE FROM transaction WHERE transactionId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->transactionId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * updates this transaction in mySQL
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

		// enforce the transactionId is not null
		if($this->transactionId === null) {
			throw(new mysqli_sql_exception("Unable to update a transaction that does not exist"));
		}

		// convert dates to strings
		if($this->dateApproved === null) {
			$dateApproved = null;
		} else {
			$dateApproved = $this->dateApproved->format("Y-m-d H:i:s");
		}

		// create query template
		$query = "UPDATE transaction SET profileId = ?, ticketId = ?, amount = ?, dateApproved = ? WHERE transactionId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("iidsi", $this->profileId, $this->ticketId, $this->amount, $dateApproved, $this->transactionId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * gets the Transaction by ProfileId
	 *
	 * @param resource $mysqli    pointer to mySQL connection, by reference
	 * @param integer  $profileId profileId to search for
	 * @return mixed Transaction found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getTransactionByProfileId(&$mysqli, $profileId)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the profileId before searching
		$profileId = filter_var($profileId, FILTER_SANITIZE_NUMBER_INT);

		// create query template
		$query = "SELECT transactionId, profileId, ticketId, amount, dateApproved FROM transaction WHERE profileId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the profileId to the place holder in the template
		$wasClean = $statement->bind_param("i", $profileId);
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
		// if there's a result, we can make it into a Transaction object normally
		// if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch assoc() returns a row as an associative array

		// convert the associative array to a Transaction
		if($row !== null) {
			try {
				$transaction = new Transaction($row["transactionId"], $row["profileId"], $row["ticketId"], $row["amount"], $row["dateApproved"]);
			} catch(Exception $exception) {
				// if row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Transaction", 0, $exception));
			}

			// if we get here, the Transaction is good return it
			return ($transaction);
		} else {
			// 404 Transaction not found return null
			return (null);
		}
	}

	/**
	 * gets the Transaction by TicketId
	 *
	 * @param resource $mysqli   pointer to mySQL connection, by reference
	 * @param integer  $ticketId ticketId to search for
	 * @return mixed Transaction found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 **/
	public static function getTransactionByTicketId(&$mysqli, $ticketId)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the ticketId before searching
		$ticketId = filter_var($ticketId, FILTER_SANITIZE_NUMBER_INT);

		// create query template
		$query = "SELECT transactionId, profileId, ticketId, amount, dateApproved FROM transaction WHERE ticketId = ?";
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
		// if there's a result, we can make it into a Transaction object normally
		// if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch assoc() returns a row as an associative array

		// convert the associative array to a Transaction
		if($row !== null) {
			try {
				$transaction = new Transaction($row["transactionId"], $row["profileId"], $row["ticketId"], $row["amount"], $row["dateApproved"]);
			} catch(Exception $exception) {
				// if row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to Transaction", 0, $exception));
			}

			// if we get here, the Transaction is good return it
			return ($transaction);
		} else {
			// 404 Transaction not found return null
			return (null);
		}

	}
}
?>