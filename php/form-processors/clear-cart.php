<?php
if(session_status() === PHP_SESSION_NONE)	{
	session_start();
}
	unset($_SESSION["cartItems"]);
?>
<head><meta http-equiv="refresh" content="0; url=../forms/shopping-cart-form.php" /></head>