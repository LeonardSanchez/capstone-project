<?php
session_start();
/**
* Shopping cart form
*
 * This form will be used to collect quantity of tickets desired and allow the user to see a preview of the order before checkout
*
 * Created by Brendan Slevin
*/
// require the transaction class so we can pull the ticket id which will have the event price and such
require_once("../classes/event.php");
// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require for the csrf protection
require_once("../forms/csrf.php");

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

if ($qty <= 0){
	throw(RangeException("This is a negative quantity."));
} else if ()
if ()
// empty cart
unset($_SESSION["cart"]);

$dropDown = "<select name="ticketQuantity">
								    <option value="1" selected>1</option>
									 <option value="2">2</option>
									 <option value="3">3</option>
									 <option value="4">4</option>
									 <option value="5">5</option>
									 <option value="6">6</option>
									 <option value="7">7</option>
									 <option value="8">8</option>
									 <option value="9">9</option>
									 <option value="10">10</option>
								  </select>";
// some potential
str_replace(">".$cart[$eventId],"selected>"$cart[$eventId],$dropdown);


?>

