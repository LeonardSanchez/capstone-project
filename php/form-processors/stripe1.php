<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
if(array_key_exists('email',$_SESSION)===false)	{
	echo "<p>Please sign in to purchase</p>";
} else	{

	$cartTotal = $_SESSION['cartSubtotal'];

	$priceInCents = $cartTotal * 100;
?>
<html>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<form action="../form-processors/checkout-form-processor.php" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js"
    data-key="pk_test_zqXDIk9h00Tk0kLxXw0UrENB"
    data-amount="<?php echo $priceInCents; ?>"
    data-name="RGEvents"
    data-description=""
    data-image="../../images/redgreenchilelarge.jpg">
  </script>
	<button type="submit" class="btn btn-success">Checkout with Card</button>
</form>
</html>
<?php	}	?>