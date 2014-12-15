<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}

// start fresh for each load of the shopping cart
$cartTotal = 0;
// create array for subtotal will be used to get cart subtotal
$itemSubtotals	=	array();
// check if index exists
if(array_key_exists("cartItems", $_SESSION)=== false) {
	// index doesn't exist; set to 0 through cart total
	$_SESSION["cartSubtotal"] =	$cartTotal;
}else	{
	// get cart count
	$cartCount = count($_SESSION["cartItems"]);
	// if item count is greater than 0 run subtotals
	if($cartCount > 0) {
		// subtract by one for zero indexing
		$cartCount = $cartCount - 1;
		/**
		 * multiplies quantity with ticket price and returns array of subtotals
		 */
		foreach($_SESSION["cartItems"] as $item) {
			$itemSubtotal = ($item['qty'] * $item['ticketPrice']);
			$_SESSION["cartItems"][$item['eventId']]['itemSubtotal'] = $itemSubtotal;
			$itemSubtotals[] = $itemSubtotal;
		}
		/**
		 * adds subtotals for cart subtotal
		 */
		for($i = 0; $i <= $cartCount; $i++) {
			$cartTotal = $itemSubtotals[$i] + $cartTotal;
		}
		$_SESSION['cartSubtotal']	=	$cartTotal;
	}	else	{
		$_SESSION['cartSubtotal']	=	$cartTotal;
	}
}
?>

