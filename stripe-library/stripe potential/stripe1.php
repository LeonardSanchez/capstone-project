<?php


$cartTotal = 10.00;

$priceInCents = $cartTotal * 100;
?>
<html>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<html>
<form action="" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_zqXDIk9h00Tk0kLxXw0UrENB"
    data-amount="<?php echo $priceInCents; ?>"
    data-name="RGEvents"
    data-description=""
    data-image="../../images/redgreenchilelarge.jpg">
  </script>
</form>
</html>





