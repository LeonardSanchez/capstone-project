<?php

// require Event class once for getEventByEventDateTime
require_once("../classes/event.php");
// require Venue class for venue name
require_once("../classes/venue.php");
// require EventCategory class for event category
require_once("../classes/event-category.php");
//require mysqli
require_once("/etc/apache2/capstone-mysql/rgevents.php");
$mysqli = MysqliConfiguration::getMysqli();

$startDate = filter_input(INPUT_GET, "startDate", FILTER_SANITIZE_STRING);
$startDate	=	DateTime::createFromFormat("m-d-Y",$startDate);
$endDate = filter_input(INPUT_GET, "endDate", FILTER_SANITIZE_STRING);
$endDate	=	DateTime::createFromFormat("m-d-Y", $endDate);

// grab mysql data
$events = Event::getEventByEventDateTime($mysqli, $startDate, $endDate);

$resultCount = count($events);
for($i = 0; $i < $resultCount; $i++)	{
	$event = $events[$i];
	// set linked eventCategoryId to separate variable
	$eventCategoryId = $event->getEventCategoryId();
	// grabbing eventCategory from EventCategory class
	$eventCategory = (EventCategory::getEventCategoryByEventCategoryId($mysqli, $eventCategoryId));
	// set linked venueId to separate variable
	$venueId = $event->getVenueId();
	// grabbing venueName from Venue class
	$venue = Venue::getVenueByVenueId($mysqli,$venueId);
	// display results
	echo "<p><strong>" . $event->getEventName() . "</strong><br/>" .
		$eventCategory->getEventCategory()	.	"<br/>"	.
		$venue->getVenueName()	.	"<br/>"	.
		$event->getEventDateTime()->format("m-d-Y H:i")	.	"<br/>$"	.
		$event->getTicketPrice() 	.	"</p>";
	echo include("../forms/add-to-cart-form.php");
	echo "<br/><br/><br/><br/><br/>";
}