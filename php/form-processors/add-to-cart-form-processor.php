<?php
/**
 * Add to cart form
 *
 * This form will be used to add any quantity of tickets to shopping cart before checkout
 *
 */
// Make sure to start a session
session_start();
// require the transaction class so we can pull the ticket id which will have the event price and such
require_once("../classes/event.php");
// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require for the csrf protection
require_once("../forms/csrf.php");


?>
<form method="post" action="add-to-cart.php">
	<input type="hidden" name="eventId" value="<?php echo $event->getEventId(); ?>" />
	<select name="quantity">
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
	</select>
	Ticket Price Each</h3>
	<br />

	</select>
	<button type="submit">Add to Cart</button>
	<h3>Add to Cart</h3>
	<input id="Add to cart" type="button" value="Add to cart" onclick="addToCart();"/>
	<input id="empty" type="button" value="Empty Cart" onclick="emptyCart();" />
	<input id="remove" type="button" value="Remove from" onclick="removeFromCart();"/>
	<input id="update" type="button" value="Update Cart" onclick="updateCart();" />
	<input id="continueShopping" type="button" value="Continue Shopping" onclick="continueShopping();" />
	<input id="checkout" type="button" value="Checkout" onclick="checkout();" />




</form>


