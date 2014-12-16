<?php
if(session_status() === PHP_SESSION_NONE)	{
	session_start();
}
// require the transaction class so we can pull the ticket id which will have the event price and such
require_once("../classes/event.php");
require_once("../forms/date-search.php");


// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require for the csrf protection
require_once("../forms/csrf.php");
var_dump($_POST);

try {
	// require mySQLI
	$mysqli = MysqliConfiguration::getMysqli();

	// verify the form was submitted OK
	if(@isset($_POST["eventId"]) === false) {
		throw(new RuntimeException("Form variable incomplete or missing"));
	}

	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
		throw(new Exception("external source violation"));
	}

	// check the event id
	if(($eventId = isset($_POST["eventId"])) === false) {
		throw(new ErrorException("Event Id not found"));
	}

	$_SESSION["cartItems"][$_POST["eventId"]] = array('eventId' => $_POST['eventId'], 'eventName' => $_POST['eventName'], 'eventDateTime' => $_POST['eventDateTime'],
												'ticketPrice' => $_POST['ticketPrice'], 'qty' => $_POST['qty']);
	if(isset($_SESSION["cartItems"]))
	echo "<div class=\"alert alert-success\" role=\"alert\">Item added to cart</div><a href='../forms/shopping-cart-form.php'>Cart</a> ";

} catch (Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to update cart: " . $exception->getMessage() . "</div>";
}
?>
<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
<!--<head><meta http-equiv="refresh" content="0; url=../forms/shopping-cart-form.php" /></head>-->