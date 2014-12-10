<?php
require_once("../forms/csrf.php");
require_once("../classes/event.php");
require_once("/etc/apache2/capstone-mysql/rgevents.php");
// require_once("../form-processors/add-to-cart-form-processor.php");
var_dump(session_status());
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
      <form id="shoppingCart" action="../classes/transaction.php" method="POST">
			<?php echo generateInputTags();?>
			<h1>Shopping Cart: <?php echo $itemCount; ?></h1> <br /> <br /><p class=\"col-sm-6\">
				<?php
					foreach($_SESSION["cartItems"] as $item)	{
						var_dump($item['qty']);
						echo "<h5>" . $item['eventName'] . "</h5><br/>"	. $item['eventDateTime']	.	"<br/>"	.
							$item['ticketPrice']	.	"<br/>";
							echo	"<label for=\"ticketQuantity"	.	$item['eventId']	.
								"\">Ticket Quantity: </label><select name=\"ticketQuantity"	.	$item['eventId']	.
								"\" id=\"ticketQuantity"	.	$item['eventId']	.	"\">";

						for($i=1;$i<=10;$i++)	{
							if($i != $item['qty']) {
								echo "<option value=\"" . $i . "\">" . $i . "</option>";
							}	else	{
								echo "<option value=\"" . $i . "\" selected>" . $i . "</option>";
							}
							}
						echo "</select></p>";
					}
				?>
				</p>
			<input id="checkout" type="button" value="Checkout" onclick="checkout()" />
		</form>
		<input id="empty" type="button" value="Empty Cart" onclick="emptyCart()" />
		<input id="remove" type="button" value="remove" onclick="removeFromCart()"/>
		<input id="update" type="button" value="Update Cart" onclick="updateCart()" />
		<input id="continueShopping" type="button" value="Continue Shopping" onclick="continueShopping()" />
	</body>
</html>
