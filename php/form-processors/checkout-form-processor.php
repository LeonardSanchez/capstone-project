<?php
/**
 * Form processor for stripe checkout
 *
 * This should handle the backend of the payment including the token
 **/

// Set the secret key
Stripe::setApiKey("sk_test_10RALcMRpUK6T8px2D1QDXFW");

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];

// Create the charge on Stripe's servers - this will charge the user's card
try {
	$charge = Stripe_Charge::create(array(
			"amount" => $priceInCents,
			"currency" => "usd",
			"card" => $token,
			"description" => "payinguser@example.com")
	);
} catch(Stripe_CardError $e) {
	// The card has been declined
}


?>