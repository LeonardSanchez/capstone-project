<?php
session_start();
// require the transaction class so we can pull the ticket id which will have the event price and such
require_once("../classes/event.php");
// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require for the csrf protection
require_once("../forms/csrf.php");

try {
	// require mySQLI
	$mysqli = MysqliConfiguration::getMysqli();

	// verify the form was submitted OK
	if(@isset($_POST["addToCart"]) === false) {
		throw(new RuntimeException("Form variable incomplete or missing"));
	}

	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false) {
		throw(new Exception("external source violation"));
	}

	// check the event id
	if($eventId = isset($_POST['eventId']) === false) {
		throw(new ErrorException("Event Id not found"));
	}

	$_SESSION['cart_items'][$eventId] = array('eventName' => $_POST['eventName'], 'eventDateTime' => $_POST['eventDateTime'], 'ticketPrice' => $_POST['ticketPrice'], 'qty' => $_POST['qty']);


} catch (Exception $exception){
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to update cart: " . $exception->getMessage() . "</div>";

}
?>