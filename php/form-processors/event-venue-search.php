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

$venueId	=	filter_input(INPUT_GET, "venueId",FILTER_VALIDATE_INT);

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
	echo "<p class=\"col-sm-6\"><strong>" . $event->getEventName() . "</strong><br/>" .
		$eventCategory->getEventCategory() . "<br/>" .
		$venue->getVenueName() . "<br/>" .
		$event->getEventDateTime()->format("m-d-Y h:i") . "<br/>$" .
		$event->getTicketPrice() . "</p>";
	include("../forms/add-to-cart-form.php");
	echo "<br/><br/><br/>";
}