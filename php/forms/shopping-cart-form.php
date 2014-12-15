<?php
require_once("../forms/csrf.php");
require_once("../classes/event.php");
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../form-processors/update-subtotal.php");
try {
	if(session_status() === PHP_SESSION_NONE) {
		session_start();
	}

} catch (Exception $exception)	{
	echo "<div>Unable to verify csrf</div>";
}
$mysqli = MysqliConfiguration::getMysqli();
$itemCount = count($_SESSION["cartItems"]);
?>

<!DOCTYPE html>
<html>
   <head lang="en">
      <meta charset="UTF-8">
      <title>Shopping Cart</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/javascript/shopping-cart.js"></script>
		<!-- link rel="stylesheet" type="text/css" / -->
   </head>
   <body>
			<?php echo generateInputTags();?>
			<h1>Shopping Cart: <?php echo $itemCount; ?> Item(s)</h1> <br /> <br />
				<?php

				if($itemCount === 0)	{
					echo "<h4>Shopping cart is empty</h4>";
				} else {
					foreach($_SESSION["cartItems"] as $item) {
						echo "<form id=\"updateItem" . $item['eventId'] . "\"action=\"../form-processors/update-cart-form-processor.php\" method=\"POST\">";
						echo "<h5>" . $item['eventName'] . "</h5>" . $item['eventDateTime'] . "<br/>$" .
							$item['ticketPrice'] . "<br/>";
						echo "<label for=\"ticketQuantity" . $item['eventId'] .
							"\">Ticket Quantity: </label><select name=\"ticketQuantity" . $item['eventId'] .
							"\" id=\"ticketQuantity" . $item['eventId'] . "\">";

						for($i = 1; $i <= 10; $i++) {
							if($i != $item['qty']) {
								echo "<option value=\"" . $i . "\">" . $i . "</option>";
							} else {
								echo "<option value=\"" . $i . "\" selected>" . $i . "</option>";
							}
						}
						echo "</select>" . "<input type=\"hidden\" id=\"" . $item['eventId'] . "\" value=\"" . $item['eventId'] . "\"><input type=\"submit\" value=\"Update\"></form>" .
							"<form id=\"removeItem" . $item['eventId'] . "\" action=\"../form-processors/remove-item.php\" method=\"post\"><input id=\"r" . $item['eventId'] . "\" name=\"r" . $item['eventId'] . "\" type=\"hidden\" value=\"" .
							$item['eventId'] . "\"><input type=\"submit\" value=\"Remove\"></form></p><hr/>".
							"<form id=\"checkout\"><label for=\"\"></label><h3>$".$_SESSION['cartSubtotal']."</h3></form>";
					}
				}
				?>

		<form id="clearCart" action="../form-processors/clear-cart.php" method="POST"><input type="submit" value="Clear Cart"> </form>
		<br/><a href="../forms/event-name-search.php">Event Name Search</a>
		<br/><a href="../forms/date-search.php">Event Date Search</a>
	</body>
</html>
