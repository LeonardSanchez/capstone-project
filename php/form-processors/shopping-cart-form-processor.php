
<?php
/**
 * Shopping cart form
 *
 * This form will be used to collect quantity of tickets desired and allow the user to see a preview of the order before checkout
 *
 * Created by Brendan Slevin
 */
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

	// csrf
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false) {
		throw(new Exception("external source violation"));
	}

	// assign the session to our cart
	$_SESSION["cart"]=$cart;

	// declare the cart array
	$cart = array(

	);

}

// verify the update was submitted OK
	if(@isset($_POST["update"]) === false) {
		throw(new RuntimeException("Form variable incomplete or missing"));
	}
// verify remove was submitted OK
	if(@isset($_POST["remove"]) === false) {
		throw(new RuntimeException("Form variable incomplete or missing"));
	}


// check to see how many remaining tickets there are for the event
$ticket = Ticket::getTicketByEventId($mysqli, $eventId);

// make sure the quantity selected is a integer
$qty = filter_var($qty, FILTER_VALIDATE_INT);

// add ticket to cart
if ($qty <= 0){
	throw(RangeException("This is a negative quantity or 0."));
}

if ($qty > 0){
	array_push($cart, $qty);
}

// remove ticket/s


// empty cart
unset($_SESSION["cart"]);



?>

