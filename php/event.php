<?php
/**
 * mySQL enabled user
 * This is a mySQL enabled container for an event listing on an event ticket site
 *
 * @author Sebastian Sandoval <sbsandoval42@gmail.com>
 */
class Event{
	/**
	 * eventId for Event; this is the primary key
	 */
	private $eventId;
	/**
	 * venueId to create a 1 to n relationship; foreign key
	 */
	private $venueId;
	/**
	 * eventCategoryId from eventCategory; used for category searching
	 */
	private $eventCategoryId;
	/**
	 * eventName for Event; Indexed for searching
	 */
	private $eventName;
	/**
	 * eventDateTime for Event; Indexed for date search and filtering
	 */
	private $eventDateTime;
	/**
	 * ticketPrice for Event checkout
	 */
	private $ticketPrice;

	/**
	 * constructor for Event
	 *
	 */
	public function __construct($newEventId, $newVenueId, $newEventCategoryId, $newEventName, $newEventDateTime, $newTicketPrice){
		try{
			$this->setEventId($newEventId);
			$this->setVenueId($newVenueId);
			$this->setEventCategoryId($newEventCategoryId);
			$this->setEventName($newEventName);
			$this->setEventDateTime($newEventDateTime);
			$this->setTicketPrice($newTicketPrice);
		}	catch(UnexpectedValueException $unexpectedValue)	{
			throw(new UnexpectedValueException("unable to construct event", 0 , $unexpectedValue));
		}	catch(RangeException $range)	{
			throw(new RangeException("unable to construct event", 0 , $range));
		}
	}

	public function getEventId() {
		return($this->eventId);
	}

	public function setEventId($newEventId)	{
		if($newEventId === null)	{
			$this->eventId = null;
			return;
		}

		if(filter_var($newEventId, FILTER_VALIDATE_INT) === false){
			throw(new UnexpectedValueException("eventId $newEventId is not numeric"));
		}


	}
}