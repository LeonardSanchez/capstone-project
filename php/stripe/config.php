<?php
/**
 * Configuration for Stripe
 *
 * This file is here for configuring stripe to process payments.
 * As well, this file was copied directly from stripes website
 * Created by Brendan
 */

require_once('./lib/Stripe.php');

$stripe = array(
	"secret_key"      => "sk_test_10RALcMRpUK6T8px2D1QDXFW",
	"publishable_key" => "pk_test_zqXDIk9h00Tk0kLxXw0UrENB"
);

Stripe::setApiKey($stripe['secret_key']);
?>


