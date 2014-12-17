<?php
/**
 * Form processor for stripe checkout
 *
 * This should handle the backend of the payment including the token
 **/
require_once("../../shopping-cart-form.php");
require_once("../classes/transaction.php");
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require("../../lib/Stripe.php");


$mysqli = MysqliConfiguration::getMysqli();

// Set the secret key
Stripe::setApiKey("sk_test_10RALcMRpUK6T8px2D1QDXFW");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

// Create a Customer
$customer = Stripe_Customer::create(array(
		"card" => $token,
		"description" => $_SESSION["email"])
);

// Create the charge on Stripe's servers - this will charge the user's card
try {
	$charge = Stripe_Charge::create(array(
			"amount" => $priceInCents,
			"currency" => "usd",
			"customer" => $customer->id)
	);

	$transaction	=	new Transaction(null, $_SESSION['profile']['profileId'], null, $_SESSION['cartSubtotal'],date("Y-m-d H:i:s"),$customer->id);
	$transaction->insert($mysqli);
	var_dump($charge);
	if($charge["paid"]	===	true)	{
		unset($_SESSION['cartItems']);
		$_SESSION["purchaseStatus"] = true;
		echo "<head><meta http-equiv=\"refresh\" content=\"0; url=../../shopping-cart-form.php\" /></head>";
	}
} catch(Stripe_CardError $e) {
	// The card has been declined
}


?>