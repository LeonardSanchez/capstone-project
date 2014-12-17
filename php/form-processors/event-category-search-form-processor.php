<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
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
$eventCategoryId = (filter_input(INPUT_GET, "subcategory", FILTER_SANITIZE_STRING));

// grab mysql data
$events = Event::getEventByEventCategoryId($mysqli, $eventCategoryId);

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
	echo "<tr><td><strong>" . $event->getEventName() . "</strong></td><td>" .
		$eventCategory->getEventCategory()	.	"</td><td>"	.
		$venue->getVenueName()	.	"</td><td>"	.
		$event->getEventDateTime()->format("m-d-Y h:i")	.	"</td><td>$"	.
		$event->getTicketPrice() 	.	"</td>"	.	"";
	include("../forms/add-to-cart-form.php");
	echo "</tr>";
}