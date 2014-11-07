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
	 * constructor for Barcode
	 *
	 * @param mixed $newBarcodeId barcode id (or null if new object)
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws RangeException when a parameter is invalid
	 **/
	public function __construct($newBarcodeId) {
		try {
			$this->setBarcodeId($newBarcodeId);
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
	 * @param mixed $newBarcodeId barcode id (or null if new object)
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