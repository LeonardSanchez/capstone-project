<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
foreach($_SESSION['cartItems'] as $processItem ) {
	// check quantity for update
	if(array_key_exists(("r".$processItem['eventId']), $_POST)=== false)	{
	} else if($_POST["r".$processItem['eventId']] === $processItem['eventId']) {
		unset($_SESSION['cartItems'][$processItem['eventId']]);
	}
}
?>
<head><meta http-equiv="refresh" content="0; url=../forms/shopping-cart-form.php" /></head>