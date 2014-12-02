<?php
// TODO: ask Dylan if a session is needed for searching
session_start();
// TODO: set up the needed "require_once"s
require_once("/etc/apache2/");
// centralized mySQL configuration class
require_once("/etc/apache2/capstone-mysql/rgevents.php");

// variable to hold the mySQL connection
private $mysqli = null;

try {
	// verify the form was submitted OK
	if(@isset($_GET["venueName"]) === false) {
		throw(new RuntimeException("Form variables incomplete or missing"));
	}

	//connect to mySQL
	$this->mysqli = MysqliConfiguration::getMysqli();

	if ($statement = $mysqli->prepare("SELECT venueName, venueCapacity, venuePhone, venueWebsite, venueAddress1, venueAddress2, venueCity, venueState, venueZipCode")) {
		$statement->bind_results($venNameArray);
		$OK = $statement->execute();
	}
	// put all of the resulting fields into a PHP array
	$result_array = MyArray();
	while($statement->fetch_assoc()) {
		$result_array[] = $venNameArray;
	}
	// convert the PHP array into JSON format, so it works with javascript
	$json_array = json_encode($result_array);
}

?>