<?php

// require the needed class to run search against
require_once("../php/classes/venue.php");
// require mySQLI
require_once("/etc/apache2/capstone-mysql/rgevents.php");
$mysqli = MysqliConfiguration::getMysqli();

// use filter_input to sanitize the venue name
$venueName = filter_input(INPUT_GET, 'venue', FILTER_SANITIZE_STRING);
// once sanitized, the variable is ready to go

// third, grab the mySQL data
$venues = Venue::getVenueByVenueName($mysqli, $venueName);

// the obvious solution: use a foreach loop!
foreach($venues as $venue) {
	echo 	"<p><strong>" . $venue->getVenueName() . "</strong><br />" .
			$venue->getVenueAddress1() . "<br />" .
			$venue->getVenueAddress2() . "<br />" .
			$venue->getVenueCity() . ", " . $venue->getVenueState() . " " . $venue->getVenueZipCode() . "<br />" .
			$venue->getVenuePhone() . "</p>";
}
?>