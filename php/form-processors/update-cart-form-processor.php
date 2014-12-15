<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require for the csrf protection


foreach($_SESSION['cartItems'] as $processItem ) {
	// check quantity for update
		if(array_key_exists(("ticketQuantity".$processItem['eventId']), $_POST)=== false) {
		} else if($_POST["ticketQuantity" . $processItem['eventId']] !== $processItem['qty']) {
				$_SESSION['cartItems'][$processItem['eventId']]['qty'] = $_POST["ticketQuantity" . $processItem['eventId']];
			}
}
?>
<head><meta http-equiv="refresh" content="0; url=../forms/shopping-cart-form.php" /></head>