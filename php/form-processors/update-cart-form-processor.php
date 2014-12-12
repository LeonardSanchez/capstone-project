<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require for the csrf protection
require_once("../forms/csrf.php");

/**try {
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
}**/

foreach($_SESSION['cartItems'] as $processItem ) {
	// check quantity for update

		if($_POST["ticketQuantity" . $processItem['eventId']] !== $processItem['qty']) {
			$_SESSION['cartItems'][$processItem['eventId']]['qty'] = $_POST["ticketQuantity" . $processItem['eventId']];
	}
}
?>
<head><meta http-equiv="refresh" content="0; url=../forms/shopping-cart-form.php" /></head>