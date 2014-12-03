<?php
/**
 * Another file from stripe that is required to process payments
 *
 * Worked on by Brendan
 */
require_once('./config.php'); ?>

<form action="charge.php" method="post">
	<script src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
			  data-key="<?php echo $stripe['publishable_key']; ?>"
			  data-amount="5000" data-description="Test Ticket"></script>
</form>