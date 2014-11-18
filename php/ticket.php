<?php
/**
 * mySQL Enabled Event
 *
 * This is a mySQL enabled container for Ticket for rgevents.com. It can be easily extended to include mor fields if necessary.
 *
 * @author James Mistalski <james.mistalski@gmail.com>
 * @see Profile
 */

class Ticket
{
	/**
	 * ticket id for the Ticket; this is the primary key
	 */
	private $ticketId;
	/**
	 * profile id for the Ticket; this is a foreign key
	 */
	private $profileId;
	/**
	 * event id for the Ticket; this is a foreign key
	 */
	private $eventId;
	/**
	 * transaction id for the Ticket; this is a foreign key
	 */
	private $transactionId;

	/**
	 * PLACEHOLDER FOR PHASE 2
	 * seat for the Ticket
	 */
	/**private $seat;


	/**
	 * constructor for Ticket
	 *
	 * @param mixed  $newTicketId      ticket id (or null if new object), this is the primary key
	 * @param mixed  $newProfileId     profile id, a foreign key
	 * @param mixed  $newEventId       event id, a foreign key
	 * @param mixed  $newTransactionId transaction id, a foreign key
	 * // PLACE HOLDER FOR PHASE 2 @param string $newSeat          seat
	 */
	public function __construct($newTicketId, $newProfileId, $newEventId, $newTransactionId)
	{
		try {
			$this->setTicketId($newTicketId);
			$this->setProfileId($newProfileId);
			$this->setEventId($newEventId);
			$this->setTransactionId($newTransactionId);
			// PLACE HOLDER FOR PHASE 2 $this->setSeat($newSeat);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Ticket", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to the caller
			throw(new RangeException("Unable to construct Ticket", 0, $range));
		}
	}

	/**
	 * gets the value of ticket id
	 *
	 * @return mixed ticket id (or null if new object)
	 */
	public function getTicketId()
	{
		return ($this->ticketId);
	}

	/**
	 * sets the value of ticket id
	 *
	 * @param mixed $newTicketId ticket id (or null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if ticket id isn't positive
	 */
	public function setTicketId($newTicketId)
	{
		// zeroth, set allow the ticket id to be null if a new object
		if($newTicketId === null) {
			$this->ticketId = null;
		}

		// first, ensure the ticket id is an integer
		if(filter_var($newTicketId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("ticket id $newTicketId is not numeric"));
		}

		// second, convert the ticket id to an integer and enforce it's positive
		$newTicketId = intval($newTicketId);
		if($newTicketId <= 0) {
			throw(new RangeException("ticket id $newTicketId is not positive"));
		}

		// finally, take the ticket id out of quarantine and assign it
		$this->ticketId = $newTicketId;
	}

	/**
	 * gets value of profile id
	 *
	 * @return mixed profile id
	 */
	public function getProfileId() {
		return ($this->profileId);
	}

	/**
	 * sets the value of profile id
	 *
	 * @param mixed $newProfileId profile id
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if profile id is not positive
	 */
	public function setProfileId($newProfileId) {

		// first, ensure the profile id is an integer
		if(filter_var($newProfileId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("profile id $newProfileId is not numeric"));
		}

		// second, convert the profile id to an integer and enforce it is positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("profile id $newProfileId is not positive"));
		}

		//finally, take the profile id out of quarantine and assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * gets value of event id
	 *
	 * @return mixed event id
	 */
	public function getEventId() {
		return ($this->eventId);
	}

	/**
	 * sets the value of event id
	 *
	 * @param mixed $newEventId event id
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if event id is not positive
	 */
	public function setEventId($newEventId) {

		// first, ensure the event id is an integer
		if(filter_var($newEventId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("event id $newEventId is not numeric"));
		}

		// second, convert the event id to an integer and enforce it is positive
		$newEventId = intval($newEventId);
		if($newEventId <= 0) {
			throw(new RangeException("event id $newEventId is not positive"));
		}

		//finally, take the event id out of quarantine and assign it
		$this->eventId = $newEventId;
	}

	/**
	 * gets value of transaction id
	 *
	 * @return mixed transaction id
	 */
	public function getTransactionId() {
		return ($this->transactionId);
	}

	/**
	 * sets the value of transaction id
	 *
	 * @param mixed $newTransactionId transaction id
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if transaction id is not positive
	 */
	public function setTransactionId($newTransactionId) {

		// first, ensure the transaction id is an integer
		if(filter_var($newTransactionId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("transaction id $newTransactionId is not numeric"));
		}

		// second, convert the transaction id to an integer and enforce it is positive
		$newTransactionId = intval($newTransactionId);
		if($newTransactionId <= 0) {
			throw(new RangeException("transaction id $newTransactionId is not positive"));
		}

		//finally, take the transaction id out of quarantine and assign it
		$this->transactionId = $newTransactionId;
	}

	/**
	 * THIS IS A PLACE HOLDER FOR SEAT TO BE INCLUDED IN PHASE 2 OF SITE
	 *
	 * gets the value of seat
	 *
	 * @return string value of seat
	 */
	/**public function getSeat() {
		return ($this->seat);
	}
	 */

	/**
	 * sets the value of seat
	 *
	 * @param string $newSeat for seat
	 * @throws UnexpectedValueException if the input doesn't appear to be a seat
	 */
	/**public function setSeat($newSeat) {

		// sanitize the Seat as a likely seat assignment
		$newSeat = trim($newSeat);
		if(($newSeat = filter_var($newSeat, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("seat $newSeat does not appear to be a seat assignment"));
		}

		// then just take the seat out of quarantine
		$this->seat = $newSeat;
	}
	*/

	/**
	 * insert this Ticket to mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function insert(&$mysqli) {

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the ticketId is null (i.e. don't insert a ticket that already exists)
		if($this->ticketId !== null) {
			throw(new mysqli_sql_exception("not a new ticket"));
		}

		// create query template
		// ADD SEAT DURING PHASE 2
		$query = "INSERT INTO ticket(ticketId, profileId, eventId, transactionId) VALUES(?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		// ADD SEAT DURING PHASE 2
		$wasClean = $statement->bind_param("iiii", 	$this->ticketId,			$this->profileId,		$this->eventId,
																		$this->transactionId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			echo $statement->error . "<br />";
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null ticketId with what mySQL just gave me
		$this->ticketId = $mysqli->insert_id;

	}

	/**
	 * deletes this Ticket from mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function delete(&$mysqli) {

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the ticketId is not null (i.e. don't delete a ticket that hasn't been inserted)
		if($this->ticketId === null) {
			throw(new mysqli_sql_exception("Unable to delete a ticket that does not exist"));
		}

		// create query template
		$query		= "DELETE FROM ticket WHERE ticketId = ?";
		$statement	= $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->ticketId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}

	/**
	 * updates this Ticket in mySQL
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */
	public function update(&$mysqli) {

		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the ticket id is not null (i.e. don't update a ticket that hasn't been inserted)
		if($this->ticketId === null) {
			throw(new mysqli_sql_exception("Unable to update a ticket that does not exist"));
		}

		// create query template
		// ADD SEAT DURING PHASE 2
		$query		= "UPDATE ticket SET profileId = ?, eventId = ?, transactionId = ?, WHERE ticketId = ?";
		$statement	= $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		// ADD SEAT DURING PHASE 2
		$wasClean = $statement->bind_param("iiii",	$this->profileId,	$this->eventId, $this->transactionId, $this->ticketId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind the parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute statement"));
		}
	}



}