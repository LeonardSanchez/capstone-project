<?php
// mock up for the great James Mistalski of how to display an array of objects
// first, generate some fake data
require_once("../classes/venue.php");
require_once("/etc/apache2/capstone-mysql/rgevents.php");
$mysqli = MysqliConfiguration::getMysqli();
$venue1 = new Venue(null, "Unit Test Ampitheatre", 32768, "505-867-5309", "http://unittestampitheatre.net/",
							"715 Unit Test Blvd NE", null, "Burque", "NM", "87108");
$venue2 = new Venue(null, "Zach Grant Stadium", 16, "505-555-8643", "http://www.macgrant.com/",
							"1 Infinite Loop", "Box 18", "Rio Rancho", "NM", "87256");

// second, insert the fake data (poor man's setup)
$venue1->insert($mysqli);
$venue2->insert($mysqli);

// third, grab the mySQL data
$venues = Venue::getVenueByVenueState($mysqli, "NM");

// the obvious solution: use a foreach loop!
foreach($venues as $venue) {
	echo 	"<p><strong>" . $venue->getVenueName() . "</strong><br />" .
			$venue->getVenueAddress1() . "<br />" .
			$venue->getVenueAddress2() . "<br />" .
			$venue->getVenueCity() . ", " . $venue->getVenueState() . " " . $venue->getVenueZipCode() . "<br />" .
			$venue->getVenuePhone() . "</p>";
}

// delete the rows (poor man's tear down)
$venue1->delete($mysqli);
$venue2->delete($mysqli);
?>