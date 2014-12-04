<?php
session_start();
?>
<!DOCTYPE html>
<html>
   <head lang="en">
      <meta charset="UTF-8">
      <title>Shopping Cart</title>
      <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script type="text/javascript" src="//malsup.github.com/min/jquery.form.min.js"></script>
      <script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
      <script type="text/javascript" src="//cdnjs.clooudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" />
   </head>
   <body>
      <form id="shoppingCart" action="../classes/transaction.php" method="POST">
         Ticket Quantity:<select>
									 <option>0</option>
									 <option>1</option>
									 <option>2</option>
									 <option>3</option>
									 <option>4</option>
									 <option>5</option>
									 <option>6</option>
									 <option>7</option>
									 <option>8</option>
									 <option>9</option>
									 <option>10</option>
								 </select><br />
         <button id="empty" type="button">Empty Cart</button>
         <button id="update" type="button">Update Cart</button>
         <button id="continue shopping" type="button">Continue Shopping</button>
         <button id="checkout" type="submit" <a href="../checkout-stripe.php">Checkout</a></button>
      </form>
   </body>
</html>
