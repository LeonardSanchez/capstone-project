<?php
session_start();
// require the needed class to run search against
require_once("../classes/venue.php");

// require mySQLI
require_once("/etc/apache2/capstone-mysql/rgevents.php");
$mysqli = MysqliConfiguration::getMysqli();

// use filter_input to sanitize the venue name
$venueName = filter_input(INPUT_GET, 'venue', FILTER_SANITIZE_STRING);
// once sanitized, the variable is ready to go

// next, grab the mySQL data
$venues = Venue::getVenueByVenueName($mysqli, $venueName);

// use a foreach loop to return the data as an array of objects
foreach($venues as $venue) {
	echo 	"<p><strong>" . $venue->getVenueName() . "</strong><br />" .
			$venue->getVenueAddress1() . "<br />" .
			$venue->getVenueAddress2() . "<br />" .
			$venue->getVenueCity() . ", " . $venue->getVenueState() . " " . $venue->getVenueZipCode() . "<br />" .
			$venue->getVenuePhone() . "<br />" .
			$venue->getVenueWebsite() . "</p>";
}
?>