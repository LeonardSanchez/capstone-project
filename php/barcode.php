<?php
/**
 * mySQL Enabled Barcode
 *
 * This is a mySQL enabled container for Barcode data for Red or Green Events
 *
 * @author Brendan Slevin
 **/
class Barcode {
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
	 * @param mixed $newTicketId ticket id (maybe null if new ticket)
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws RangeException when a parameter is invalid
	 **/
	public function __construct($newBarcodeId, $newTicketId) {
		try {
			$this->setBarcodeId($newBarcodeId);
			$this->setTicketId($newTicketId);
		}	catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to caller
			throw(new UnexpectedValueException("Unable to construct Barcode", 0, $unexpectedValue));
		}	catch(RangeException $range) {
			// rethrow to caller
			throw(new RangeException("Unable to construct Barcode", 0, $range));
		}
	}

	/**
	 * gets the value of barcode id
	 *
	 * @return mixed barcode id (or null if new object)
	 **/
	public function getBarcodeId()	{
		return($this->barcodeId);
	}

	/**
	 * sets the value of barcode id
	 *
	 * @param mixed $newBarcodeId barcode id (or null if new barcode)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if barcode id isn't positive
	 **/
	public function setBarcodeId($newBarcodeId)	{
		// zeroth, set allow the barcode id to be null if a new object
		if($newBarcodeId === null) {
			$this->barcodeId = null;
			return;
		}

		// first, ensure the barcode id is an integer
		if(filter_var($newBarcodeId,FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("barcode id $newBarcodeId is not numeric"));
		}

		// second, convert convert the barcode id to an integer and enforce it's positive
		$newBarcodeId = intval($newBarcodeId);
		if($newBarcodeId <= 0)	{
			throw(new RangeException("barcode id $newBarcodeId is not positive"));
		}

		// finally, take the barcode id out of quarantine and assign it
		$this->barcodeId = $newBarcodeId;

	}

	/**
	 * gets the value of ticket id
	 *
	 * @return mixed ticket id (or null if new ticket)
	 **/
	public function getTicketId() {
		return($this->ticketId);
	}

	/**
	 *sets the value of the ticket id
	 *
	 * @param mixed $newTicketId
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if ticket id is not positive
	 **/
	public function setTicketId($newTicketId)	{
		// allow the ticket id to be null if a new object
		if($newTicketId === null) {
			$this->ticketId = null;
			return;
		}

		// ensure the ticket id is an integer
		if(filter_var($newTicketId,FILTER_VALIDATE_INT) === false)	{
			throw(new UnexpectedValueException("ticket id $newTicketId is not numeric"));
		}

		// convert convert the ticket id to an integer and enforce it's positive
		$newTicketId = intval($newTicketId);
		if($newTicketId <= 0)	{
			throw(new RangeException("ticket id $newTicketId is not positive"));
		}

		// take the ticket id out of quarantine and assign it
		$this->ticketId = $newTicketId;

	}

	/**
	 * insert this Barcode into mySQL
	 *
	 * @param resource $mySQL pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors
	 **/
	public function insert(&$mysqli)	{
		// handle degenerate cases
		if(gettype($mysqli)	!== "object" || get_class($mysqli)	!== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the barcodeId is null (don't insert a barcode that already exists)
		if($this->barcodeId !== null)	{
			throw(new mysqli_sql_exception("not a new barcode"));
		}


	}


}

?>