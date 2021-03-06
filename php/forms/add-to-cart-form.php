<?php
require_once("../forms/csrf.php");
require_once("../classes/event.php");

?>

<td>
	<form id="addToCartForm" class="addToCartForm" action="../capstone-project/php/form-processors/add-to-cart-form-processor.php" method="post">
		<?php echo generateInputTags(); ?>
		<input type="hidden" name="eventId" id="eventId" value="<?php echo $event->getEventId(); ?>" />
		<input type="hidden" name="eventName" value="<?php echo $event->getEventName(); ?>" />
		<input type="hidden" name="eventDateTime" value="<?php echo $event->getEventDateTime()->format("Y-m-d H:i:s"); ?>" />
		<input type="hidden" name="ticketPrice" value="<?php echo $event->getTicketPrice(); ?>" />
		<label for="qty">Ticket Quantity: </label>
		<select id="qty" name="qty">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>


		<button class="btn btn-success" id="addToCart" type="submit">Add To Cart</button>
	</form></td>

	<?php echo "<p id=\"outputAddToCart". $event->getEventId() . "\" class=\"col-sm-6\"></p>"; ?>

