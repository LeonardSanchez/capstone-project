<?php
if(session_status() === PHP_SESSION_NONE)	{
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
try	{
	$mysqli = MysqliConfiguration::getMysqli();

	$startDate = filter_input(INPUT_GET, "startDate", FILTER_SANITIZE_STRING);
	$startDate	=	DateTime::createFromFormat("m-d-Y",$startDate);
	$endDate = filter_input(INPUT_GET, "endDate", FILTER_SANITIZE_STRING);
	if($endDate !== "") {
		$endDate = DateTime::createFromFormat("m-d-Y", $endDate);
	}

	// grab mysql data
	$events = Event::getEventByEventDateTime($mysqli, $startDate, $endDate);
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
		echo 	"<tr>";
		echo 	"<td><strong>" . $event->getEventName() . "</strong></td>";
		echo	"<td>" . $eventCategory->getEventCategory() . "</td>";
		echo	"<td>" . $venue->getVenueName() . "</td>";
		echo	"<td>" . $event->getEventDateTime()->format("m-d-Y h:i") . "</td>";
		echo	"<td>$" . $event->getTicketPrice() . "</td>";
		include("../forms/add-to-cart-form.php");

		// echo "<br/><br/><br/>";
	}
	echo "\");</script>";
} catch (Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to search: " . $exception->getMessage() . "</div>";
}


