<?php
session_start();
// require event class for getEventByEventName
require_once("../classes/event.php");
//require Event-Category for getEventCategory
require_once("../classes/event-category.php");
// require Venue for getVenueName
require_once("../classes/venue.php");
// require add to cart for add to cart form

// require mysqli
require_once("/etc/apache2/capstone-mysql/rgevents.php");
$mysqli = MysqliConfiguration::getMysqli();

// use filter_input to sanitize event name
$eventName = (filter_input(INPUT_GET, "eventName", FILTER_SANITIZE_STRING));

// grab mysql data
$events = Event::getEventByEventName($mysqli, $eventName);

/**
 * return the result set to the user
 */
$resultCount = count($events);
for($i = 0; $i < $resultCount; $i++)	{
	$event = $events[$i];
	// set linked eventCategoryId to separate variable
	$eventCategoryId = $event->getEventCategoryId();
	// grabbing eventCategory from EventCategory class
	$eventCategory = EventCategory::getEventCategoryByEventCategoryId($mysqli, $eventCategoryId);
	// set linked venueId to separate variable
	$venueId = $event->getVenueId();
	// grabbing venueName from Venue class
	$venue = Venue::getVenueByVenueId($mysqli,$venueId);
	// display results
	echo "<p class=\"col-sm-6\"><strong>" . $event->getEventName() . "</strong><br/>" .
		$eventCategory->getEventCategory()	.	"<br/>"	.
		$venue->getVenueName()	.	"<br/>"	.
		$event->getEventDateTime()->format("m-d-Y h:i")	.	"<br/>$"	.
		$event->getTicketPrice() 	.	"</p>"	.	"<p class=\"col-sm-6\">";
	include("../forms/add-to-cart-form.php");
	echo "</p><br/><br/><br/><br/><br/>";
}