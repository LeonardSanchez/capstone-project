<?php
/**
 * Form processor for stripe checkout
 *
 * This should handle the backend of the payment including the token
 **/
require_once("../forms/shopping-cart-form.php");
require_once("../classes/transaction.php");
require("")
/**require_once("../../stripe-library/stripe/Stripe.php");
require_once("../../stripe-library/stripe/stripe-util/Set.php");
require_once("../../stripe-library/stripe/Util.php");
require_once("../../stripe-library/stripe/ApiRequestor.php");
require_once("../../stripe-library/stripe/Object.php");
require_once("../../stripe-library/stripe/ApiResource.php");
require_once("../../stripe-library/stripe/Charge.php");
require_once("../../stripe-library/stripe/Customer.php");*/

// Set the secret key
Stripe::setApiKey("sk_test_10RALcMRpUK6T8px2D1QDXFW");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];


// Create the charge on Stripe's servers - this will charge the user's card
try {
	$charge = Stripe_Charge::create(array(
			"amount" => $priceInCents,
			"currency" => "usd",
			"card" => $token
	));

	$transaction	=	new Transaction(null, $_SESSION['profile']['profileId'], null, $_SESSION['cartSubtotal'],date("Y-m-d H:i:s"),$token);
} catch(Stripe_CardError $e) {
	// The card has been declined
}


?>