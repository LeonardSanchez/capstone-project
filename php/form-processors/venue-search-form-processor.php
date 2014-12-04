<?php
session_start();
// require the needed class to run search against
require_once("../classes/venue.php");
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../forms/csrf.php");

try {
	// require mySQLI
	$mysqli = MysqliConfiguration::getMysqli();

	// verify the form was submitted OK
	if(@isset($_GET["venue"]) === false) {
		throw(new RuntimeException("Form variables incomplete or missing"));
	}

	// verify the CSRF tokens
	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false) {
		throw(new RuntimeException("CSRF tokens incorrect or missing. Make sure cookies are enabled."));
	}
	// use filter_input to sanitize the venue name
	$venueName = filter_input(INPUT_GET, 'venue', FILTER_SANITIZE_STRING);
	// once sanitized, the variable is ready to go

	// next, grab the mySQL data
	$venues = Venue::getVenueByVenueName($mysqli, $venueName);

	// use a foreach loop to return the data as an array of objects
	foreach($venues as $venue) {
		echo "<p><strong>" . $venue->getVenueName() . "</strong><br />" .
			$venue->getVenueAddress1() . "<br />" .
			$venue->getVenueAddress2() . "<br />" .
			$venue->getVenueCity() . ", " . $venue->getVenueState() . " " . $venue->getVenueZipCode() . "<br />" .
			$venue->getVenuePhone() . "<br />" .
			$venue->getVenueWebsite() . "</p>";
	}
} catch(Exception $exception) {
	echo "div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong>Unable to search venue: " . $exception->getMessage() . "</div>";
}
?>