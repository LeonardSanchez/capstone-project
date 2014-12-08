<?php
/**
* Shopping cart form
*
 * This form will be used to collect quantity of tickets desired and allow the user to see a preview of the order before checkout
*
 * Created by Brendan Slevin
*/
// Make sure to start a session
session_start();
// require the transaction class so we can pull the ticket id which will have the event price and such
require_once("../classes/event.php");
// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require for the csrf protection
require_once("../forms/csrf.php");

// assign the session to our cart
$_SESSION["cart"]=$cart;

$cart = array(

);
if (quantity < 0){
	throw(RangeException("This is a negative quantity."));
	(qunatity === 0)
		unset
}

// empty cart
unset($_SESSION["cart"]);
?>

<form method="post" action="quien-sabe.php">
	<input type="hidden" name="eventId" value="<?php echo $event->getEventId(); ?>" />
	<select name="quantity">
		<option value="1" selected>1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
	</select>
	<button type="submit">Add to Cart</button>
</form>