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
			<h1>Shopping Cart</h1> <br /> <br />
			<h3>Event Name
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
								  </select>
			Ticket Price Each</h3>
			<br />
			<input id="empty" type="button" value="Empty Cart" onclick="doFunction();" />
			<input id="update" type="button" value="Update Cart" onclick="doFunction();" />
			<input id="contiueShopping" type="button" value="Continue Shopping" onclick="doFunction();" />
			<input id="checkout" type="button" value="Checkout" onclick="doFunction();" />
      </form>
   </body>
</html>
