<?php
session_start();
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
		<link rel="stylesheet" type="text/css" />
   </head>
   <body>
      <form id="shoppingCart" action="../classes/transaction.php" method="POST">
			<h1>Shopping Cart</h1> <br /> <br />
			<h3>Event Name
         Ticket Quantity:<select>
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
								  </select>
			Ticket Price Each</h3>
			<br />
			<input id="empty" type="button" value="Empty Cart" onclick="emptyCart()" />
			<input id="remove" type="button" value="Remove from" onclick="removeFromCart()"/>
			<input id="update" type="button" value="Update Cart" onclick="updateCart()" />
			<input id="continueShopping" type="button" value="Continue Shopping" onclick="continueShopping()" />
			<input id="checkout" type="button" value="Checkout" onclick="checkout()" />
      </form>
   </body>
</html>
