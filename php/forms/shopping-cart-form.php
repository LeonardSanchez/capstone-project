<?php
session_start();
?>
<!DOCTYPE html>
<html>
   <head lang="en">
      <meta charset="UTF-8">
      <title>Shopping Cart</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
      <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script type="text/javascript" src="//malsup.github.com/min/jquery.form.min.js"></script>
      <script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
      <script type="text/javascript" src="//cdnjs.clooudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
      <link rel="stylesheet" type="text/css" />
   </head>
   <body>
      <form id="shoppingCart" action="transaction.php" method="POST">
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
								 </select> <input id="quantity" name="quantity" type="integer" /><br />
         <button type="button">Empty Cart</button>
         <button type="button">Update Cart</button>
         <button type="button">Continue Shopping</button>
         <button type="submit">Checkout</button>
      </form>
   </body>
</html>
