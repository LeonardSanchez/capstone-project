
<?php
/**
 * Shopping cart form
 *
 * This form will be used to collect quantity of tickets desired and allow the user to see a preview of the order before checkout
 *
 * Created by Brendan Slevin
 */
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
// require the transaction class so we can pull the ticket id which will have the event price and such
require_once("../classes/event.php");
// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require for the csrf protection
require_once("../forms/csrf.php");
// require for add to cart data to be dropped into the cart
//require_once("../forms/add-to-cart-form.php");

try {
	// require mySQLI
	$mysqli = MysqliConfiguration::getMysqli();

	// csrf
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false) {
		throw(new Exception("external source violation"));
	}

}	catch(Exception $exception)	{
	echo "Unable to verify csrf";
}

// check to see how many remaining tickets there are for the event
// TODO: tickets remaining
//$ticket = Ticket::getTicketByEventId($mysqli, $_SESSION['cartItems']['eventId']);

/**
 * update cart
 * TODO:complete update cart
 */
try	{
	// check each cartItem for changes in cart form
	if($_POST['action']	===	"update") {
		foreach($_SESSION['cartItems'] as $processItem ) {
			// check quantity for update
			var_dump($_POST['selected']);
			if($_POST['selected'] === $processItem['eventId']) {
				if($_POST["ticketQuantity" . $_POST['selected']] !== $processItem['qty']) {
					$_SESSION['cartItems'][$processItem['eventId']]['qty'] = $_POST["ticketQuantity" . $_POST['selected']];
				}
			}
		}
	}	else if($_POST['action']	===	"remove")	{

		unset($_SESSION['cartItems'][$_POST['selected']]);

	}	else{

		throw(new UnexpectedValueException("Not a selectable action"));
	}

	// echo link back to cart
	echo "<a href='../forms/shopping-cart-form.php'>Back to cart</a>";

}	catch(Exception $exception)	{
	echo "unable to update cart";
}









/**
// make sure the quantity selected is a integer
$qty = filter_var($qty, FILTER_VALIDATE_INT);

	// verify the update was submitted OK
	//if(@isset($_POST["update"]) === false) {
		//throw(new RuntimeException("Form variable incomplete or missing"));
	//}
	// verify remove was submitted OK
	//if(@isset($_POST["remove"]) === false) {
		//throw(new RuntimeException("Form variable incomplete or missing"));
	//}


// add ticket to cart
if ($qty <= 0){
	throw(RangeException("This is a negative quantity or 0."));
}

if ($qty > 0){
	array_push($cart, $qty);
}

// remove ticket/s

*/
// empty cart
//unset($_SESSION['cartItems']);



?>

