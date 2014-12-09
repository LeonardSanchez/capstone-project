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

	// get the event id
	$eventId = isset($_POST['eventId']) ? $_POST['eventId'] : "";
	$eventName = isset($_POST['eventName']) ? $_POST['eventName'] : "";
	$eventDateTime = isset($_POST['eventDateTime']) ? $_POST['eventDateTime'] : "";
	$ticketPrice = isset($_POST['ticketPrice']) ? $_POST['ticketPrice'] : "";
	$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : "";

	/*
	 * check if the 'cart' session array was created
	 * if it is NOT, create the 'cart' session array
	 */
	if(!isset($_SESSION['cart_items'])) {
		$_SESSION['cart_items'] = array();
	}

	// check if the item is in the array, if it is, do not add
	if(array_key_exists($eventId, $_SESSION['cart_items'])) {
		// redirect to event search results and tell the user it was added to cart
		header('Location: event-category-search.php?action=exists&eventId' . $eventId . '&eventName=' . $eventName);
	} // else, add the item to the array
	else {
		$_SESSION['cart_items'][$eventId] = $eventName;

		// redirect to event search results and tell the user it was added to cart
		header('Location: event-search-form.php?action=added&eventId' . $eventId . '&eventName=' . $eventName);
	}
} catch (Exception $exception){
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to update cart: " . $exception->getMessage() . "</div>";

}
?>