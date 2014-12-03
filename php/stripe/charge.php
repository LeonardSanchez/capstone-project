<?php
/**
 * Charge for stripe
 *
 * This file comes directly from stripe's website
 *
 * Worked on by Brendan
 */

require_once(dirname(__FILE__) . '/config.php');
$token = $_POST['stripeToken'];
$customer = Stripe_Customer::create(array(
	'email' => 'customer@example.com',
	'card' => $token
));
$charge = Stripe_Charge::create(array(
	'customer' => $customer->id,
	'amount' => 5000,
	'currency' => 'usd'
));
echo '<h1>Successfully charged $50!</h1>';
?>