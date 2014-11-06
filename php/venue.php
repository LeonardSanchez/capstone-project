<?php
/**
 * This is a mySQL enabled container for venue data for redorgreenevents.com. It can be easily updated to include more fields as necessary.
 *
 *
 */
class Venue
{
	/**
	 * venue id fo the venue this is the primary key
	 */
	public $venueId;
	/**
	 * venue name for the Venue
	 */
	private $venueName;
	/**
	 * venue capacity for the Venue
	 */
	private $venueCapacity;
	/**
	 * venue phone for the Venue
	 */
	private $venuePhone;
	/**
	 * venue website for the Venue
	 */
	private $venueWebsite;
	/**
	 * street address for the Venue
	 */
	private $address1;
	/**
	 * second line address for the Venue
	 */
	private $address2;
	/**
	 * city for the Venue
	 */
	private $city;
	/**
	 * state for the Venue
	 */
	private $state;
	/**
	 * zip code for the Venue
	 */
	private $zipCode;


	/**
	 * constructor for Venue
	 *
	 * @param int $newVenueId venue id (or null if new object)
	 * @param string $newVenueName venue name
	 * @param int $newVenueCapacity venue capacity
	 * @param string $newVenuePhone venue phone
	 * @param string $newVenueWebsite venue website
	 * @param string $newVenueAddress1 venue address first line
	 * @param string $newVenueAddress2 venue address second line
	 * @param string $newCity venue city
	 * @param string $newState venue state
	 * @param int $newZipCode venue zip code
	 */
	public function __construct($newVenueId, $newVenueName, $newVenueCapacity, $newVenuePhone, $newVenueWebsite, $newVenueAddress1, $newVenueAddress2, $newVenueCity, $newVenueState, $newVenueZipCode) {
		try {
			$this->setVenueId($newVenueId);
			$this->setVenueName($newVenueName);
			$this->setVenueCapacity($newVenueCapacity);
			$this->setVenuePhone($newVenuePhone);
			$this->setVenueWebsite($newVenueWebsite);
			$this->setVenueAddress1($newVenueAddress1);
			$this->setVenueAddress2($newVenueAddress2);
			$this->setVenueCity($newVenueCity);
			$this->setVenueState($newVenueState);
			$this->setVenueZipCode($newVenueZipCode);
		} catch(UnexpectedValueException $unexpectedValue) {
			//rethrow to the caller
			throw(new UnexpectedValueException("Unable to construct Venue", 0, $unexpectedValue));
		} catch(RangeException $range) {
			//rethrow to the caller
			throw(new RangeException("Unable to construct Venue", 0, $range));
		}
	}

	/**
	 * gets the value of venue id
	 *
	 * @return int venue id (or null if new object)
	 */
	public function getVenueId() {
		return ($this->venueId);
	}

	/**
	 * sets the value of venue id
	 *
	 * @param int $newVenueId venue id (or null if new object)
	 * @throws UnexpectedValueException if not an integer or null
	 * @throws RangeException if venue id isn't positive
	 */
	public function setVenueId($newVenueId) {
		// zeroth, set all the venue id to be null if a new object
		if($newVenueId === null) {
			$this->venueId = null;
			return;
		}

		// first, ensure the venue id is an integer
		if(filter_var($newVenueId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("venue id $newVenueId is not numeric"));
		}

		// second, convert the venue id to an integer and enforce it is positive
		$newVenueId = intval($newVenueId);
		if($newVenueId <= 0) {
			throw(new UnexpectedValueException("venue id $newVenueId is not positive"));
		}

		// finally, take the venue id out of quarantine and assign it
		$this->venueId = $newVenueId;
	}

	/**
	 * gets the value of venue name
	 *
	 * @return string value of venue name
	 */
	public function getVenueName() {
		return ($this->venueName);
	}

	/**
	 * sets the value of venue name
	 *
	 * @param string $newVenueName venue name
	 * @throws UnexpectedValueException if it doesn't appear to be a venue name
	 */
	public function setVenueName($newVenueName)
	{
		// sanitize the Venue Name as a likely Venue Name
		$newVenueName = trim($newVenueName);
		if(($newVenueName = filter_var($newVenueName, FILTER_SANITIZE_STRING)) == false) {
			throw(new UnexpectedValueException("venueName $newVenueName does not appear to be a valid venue name"));
		}

		// then take the venue name out of quarantine
		$this->venueName = $newVenueName;
	}

	/**
	 * gets the value of venue capacity
	 *
	 * @return int value of venue capacity
	 */
	public function getVenueCapacity()
	{
		return ($this->venueCapacity);
	}

	/**
	 * sets the value of venue capacity
	 *
	 * @param int $newVenueCapacity venue capacity
	 * @throws UnexpectedValueException if not an integer
	 * @throws RangeException if venue capacity isn't positive
	 */
	public function setVenueCapacity($newVenueCapacity)
	{

		// first, ensure the venue capacity is an integer
		if(filter_var($newVenueCapacity, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("venue capacity is not numeric"));
		}

		// second, convert the venue capacity to an integer and enforce it is positive
		$newVenueCapacity = intval($newVenueCapacity);
		if($newVenueCapacity <= 0) {
			throw(new UnexpectedValueException("venue capactity $newVenueCapacity is not positive"));
		}
	}

}

?>