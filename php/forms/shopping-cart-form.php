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
if(array_key_exists('cartItems', $_SESSION) === true){
	$itemCount = count($_SESSION["cartItems"]);
}	else	{
	$itemCount	=	0;
}
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
			<table class="table table-striped">
				<?php
				if($itemCount === 0)	{
					echo "<h4>Shopping cart is empty</h4>";
				} else {
					echo	"<thead><tr><th>Item #</th><th>Item</th><th>Quantity</th><th>Remove</th><th>Item Total</th></tr>";
					foreach($_SESSION["cartItems"] as $item) {
						echo "<tbody><tr><td><h3>".$itemCount."</h3></td><form id=\"updateItem" . $item['eventId'] . "\" action=\"../form-processors/update-cart-form-processor.php\" method=\"POST\">";
						echo "<td><h4>" . $item['eventName'] . "</h4><h5>" . $item['eventDateTime'] . "</h5><h5>$" .
							$item['ticketPrice'] . "</h5></td>";
						echo "<td><h4><label for=\"ticketQuantity" . $item['eventId'] .
							"\">Ticket Quantity: </label><select name=\"ticketQuantity" . $item['eventId'] .
							"\" id=\"ticketQuantity" . $item['eventId'] . "\">";

						for($i = 1; $i <= 10; $i++) {
							if($i != $item['qty']) {
								echo "<option value=\"" . $i . "\">" . $i . "</option>";
							} else {
								echo "<option value=\"" . $i . "\" selected>" . $i . "</option>";
							}
						}
						echo "</select>" . "<input type=\"hidden\" id=\"" . $item['eventId'] . "\" value=\"" . $item['eventId'] . "\"><button type=\"submit\" class=\"btn btn-default\">Update</button></form></h4></td>" .
							"<td><h3><form id=\"removeItem" . $item['eventId'] . "\" action=\"../form-processors/remove-item.php\" method=\"post\"><input id=\"r" . $item['eventId'] . "\" name=\"r" . $item['eventId'] . "\" type=\"hidden\" value=\"" .
							$item['eventId'] . "\"><button class=\"glyphicon glyphicon-trash\" aria-hiddent=\"true\" type=\"submit\"></button></h4></form></td><td><h3>$ ".$_SESSION['cartItems'][$item["eventId"]]["itemSubtotal"]."</h3></td></tr>";
						$itemCount = $itemCount-1;
					}
				}
				echo "</tbody>";
				?>
			</table>
				<?php
				echo "<form id=\"checkout\" action='../form-processors/stripe1.php' method='post'><label for=\"subtotal\">Cart Subtotal	:</label><input type=\"hidden\" value=\"".$_SESSION['cartSubtotal']."\"<h3>$".
				$_SESSION['cartSubtotal']."</h3></form>";
				include("../form-processors/stripe1.php");
				?>

		<br/><form id="clearCart" action="../form-processors/clear-cart.php" method="POST"><button type="submit" class="btn btn-danger">Clear Cart</button> </form>
		<br/>
	</body>
</html>
