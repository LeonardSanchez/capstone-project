<?php
/**
 * mySQL enabled event-link
 *
 * this is a mySQL enabled container for creating a many to many relationship
 * @author Sebastian Sandoval <sbsandoval42@gmail.com>
 */

class EventLink	{
	/**
	 * foreign key from EventCategory
	 */
	private $eventCategoryId;
	/**
	 * foreign key from Event
	 */
	private $eventId;

	/**
	 * @param int $newEventCategoryId foreign key for link from EventCategory
	 * @param int $newEventId foreign key for link from Event
	 */
	public function __construct($newEventCategoryId, $newEventId)	{
		try	{
			$this->setEventCategoryId($newEventCategoryId);
			$this->setEventId($newEventId);
		}
		// Unexpected value
		catch(UnexpectedValueException $unexpectedValue)	{
			// rethrow to caller
			throw(new UnexpectedValueException("Unable to construct EventLink", 0, $unexpectedValue));
		}
		// Not within range
		catch(RangeException $range)	{
			// rethrow to caller
			throw(new RangeException("Unable to construct EventLink", 0, $range));
		}
	}

	
}