<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
// require Event class once for getEventByEventDateTime
require_once("../classes/event.php");
// require EventCategory class for event category
require_once("../classes/event-category.php");
// require Venue class for venue name
require_once("../classes/venue.php");
//require mysqli
require_once("/etc/apache2/capstone-mysql/rgevents.php");

$mysqli = MysqliConfiguration::getMysqli();

//if(@isset($_GET["venue"]) === false) {
//	throw(new RuntimeException("Form variables incomplete or missing"));
//}

// use filter_input to sanitize the venue name
$venueName = filter_input(INPUT_GET, 'venue', FILTER_SANITIZE_STRING);

$venues = Venue::getVenueByVenueName($mysqli, $venueName);
foreach($venues as $venue)	{
	if(filter_var($venue->getVenueId(),FILTER_VALIDATE_INT)===false)	{
		throw(new UnexpectedValueException("venue Id is not an int"));
	}
	$venueId	=	$venue->getVenueId();

	$events	=	Event::getEventByVenueId($mysqli, $venueId);

	$resultCount = count($events);
	foreach($events as $event) {
		// set linked eventCategoryId to separate variable
		$eventCategoryId = $event->getEventCategoryId();
		// grabbing eventCategory from EventCategory class
		$eventCategory = EventCategory::getEventCategoryByEventCategoryId($mysqli, $eventCategoryId);
		// set linked venueId to separate variable
		$venueId = $event->getVenueId();
		// grabbing venueName from Venue class
		$venue = Venue::getVenueByVenueId($mysqli, $venueId);
		// display results
		echo "<tr><td><strong>" . $event->getEventName() . "</strong></td><td>" .
			$eventCategory->getEventCategory() . "</td><td>" .
			$venue->getVenueName() . "</td><td>" .
			$event->getEventDateTime()->format("m-d-Y h:i") . "</td><td>$" .
			$event->getTicketPrice() . "</td>";
		include("../forms/add-to-cart-form.php");
		echo "</tr>";
}}