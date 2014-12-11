<?php
//require_once("shopping-cart-form.php");
//require_once("../form-processors/shopping-cart-form-processor.php");
?>

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title>Checkout</title>
	<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script type="text/javascript" src="../../javascript/checkout.js"></script>
	<link rel="stylesheet" type="text/css" />
</head>
<body>
	<h2>Checkout</h2>
	<form id="checkout-form" action="checkout-stripe.php" method="post">
		<label>Cart Total</label><br />
		<?php ?>
		<label>Card Number</label><br />
		<input type="text" size="20" autocomplete="off"><br />
		<span>Please enter the number without spaces or hyphens.</span><br /><br />
		<label>CVC</label><br />
		<input type="text" size="4" autocomplete="off"><br /><br />
		<label>Expiration (MM/YYYY)</label><br />
		<input type="text" size="2">
		<span> / </span>
		<input type="text" size="4"><br /><br />
		<label>Email Address</label><br />
		<input name="email" type="email" autocomplete="off"><br />
		<button
		<div id="payment-errors"></div>
	</form>
</body>
