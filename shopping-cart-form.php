<?php
require_once("php/forms/csrf.php");
require_once("php/classes/event.php");
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("php/form-processors/update-subtotal.php");
require_once("php/forms/event-cat-search-functions.php");
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

<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<!-- create and add a favicon for our site <link rel="icon" href="#"> -->
	<title>RGEvents Main</title>
	<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- load .js files for RGEvents -->
	<link type="text/css" rel="stylesheet" href="site-css.css" />
	<script src="javascript/date-search.js"></script>
	<script src="javascript/event-name.js"></script>
	<script src="javascript/event-venue-search.js"></script>
	<script type="text/javascript" src="javascript/login.js"></script>
	<script type="text/javascript" src="javascript/sign-up.js"></script>
	<script type="text/javascript" src="javascript/shopping-cart.js"></script>

</head>

<body>

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color: #D1BBA1">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" id="navbarName" href="index.php"><h3 style="color: #ffffff"><strong><span style="color: #C53337">Red</span> or <span style="color: green">Green</span> Events</strong>	-	Find Events With A Local Flavor</h3></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="shopping-cart-form.php"><span class="glyphicon glyphicon-shopping-cart" style="color: #C53337" aria-hidden="true"></span></a></li>
					<li class="dropdown">
						<a href="#" id="myaccdrop" class="dropdown-toggle" data-toggle="dropdown" role="button" style="color: #fffffff" aria-expanded="false">My Account<span class="caret"></span></a>
						<ul id="account-list-options" class="dropdown-menu" role="menu" style="background-color: #C53337">
							<li><a href="login.php">Log In</a></li>
							<li><a href="update-profile.php">Update Profile</a></li>
							<li><a href="signup.php">Sign Up</a></li>
							<li><a href="php/forms/log-out.php/">Log Out</a></li>
						</ul>
					</li>
				</ul>
				<form class="navbar-form navbar-right" id="venueSearchForm" method="get" action="php/form-processors/venue-search-form-processor.php">
					<input type="text" id="venue" name="venue" style="background-color: beige" class="form-control" placeholder="Search Venues...">
					<!--<span class="clearer glyphicon glyphicon-remove-circle form-control-feedback"></span> This is to clear out the field but it is not residing IN the search box-->
				</form>
				<form class="navbar-form navbar-right" id="eventNameSearchForm" method="get" action="php/form-processors/event-name-search-form-processor.php">
					<input type="text"  id="eventName" name="eventName" style="background-color: beige" class="form-control" placeholder="Search Events...">
				</form>
			</div>
		</div>
	</nav>
	<!-- end of top nav bar -->


	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-7 col-md-3">
				<br>
				<br>
				<ul class="nav nav-sidebar" id="leftnav1">
					<br>
					<br>
					<div class="panel panel-success">
						<div class="panel-heading" style="background-color: #C53337">
							<h3 class="panel-title" style="color: #ffffff">Find Local Events</h3>
						</div>
					</div>

					<article>
						<h5><strong>Search By Event Date</strong></h5>
						<form id="dateSearchForm" method="get" action="php/form-processors/date-search-form-processor.php">
							<label for="startDate" class="sr-only"></label>
							<input type="text" id="startDate" name="startDate" class="form-control" placeholder="Start Date: mm-dd-yyyy"/><br/>
							<label for="endDate" class="sr-only"></label>
							<input type="text" id="endDate" name="endDate" class="form-control" placeholder="End Date: mm-dd-yyyy"><br/>
							<button id="search" class="btn btn-rgevents" type="submit">Search</button>
						</form>
						<!--					<p id="outputDateSearch"></p>-->
					</article>
					<br>
					<article>
						<h5><strong>Search By Event Category</strong></h5>
						<form id="eventCatSearchForm" name="catSubCat" method="post" action="php/form-processors/event-category-search-form-processor.php">
							<?php echo generateInputTags(); ?>
							<label for="eventCatSearch" class="sr-only"></label>
							<p>Choose Category</p>
							<select class="form-control" style="background-color: beige" name="cat" id="s1">
								<option value=''>Select One</option>"
								<option><?php getCategory() ?></option>
							</select>
							<br>
							<div class="search">
								<button id="search" class="btn btn-rgevents" type="submit">Search</button>
							</div>
						</form>
					</article>
				</ul>
				<br>
				<ul class="nav nav-sidebar">
					<li>
						<a id="contactbutton" class="btn btn-contact" href="contact-us.php">Contact Us</a>
					</li>

				</ul>
				<br>
				<br>
				<ul class="nav nav-sidebar">
					<li>
						<a id="aboutusbutton" class="btn btn-about" href="about.php">About Us</a>
					</li>
				</ul>
			</div>

			<div class="col-xs-13 col-md-8" id="indexContent">
				<?php echo generateInputTags();?>
				<br>
				<br>
				<br>
				<h1><span style="color: #C53337">Shopping</span> <span style="color: green">Cart</span>: <?php echo $itemCount; ?> Item(s)</h1> <br /> <br />
				<table class="table table-striped">
					<?php
					if($itemCount === 0)	{
						echo "<h4>Shopping cart is empty</h4>";
					} else {
						echo	"<thead><tr><th>Item #</th><th>Item</th><th>Quantity</th><th>Remove</th><th>Item Total</th></tr>";
						foreach($_SESSION["cartItems"] as $item) {
							echo "<tbody><tr><td><h3>".$itemCount."</h3></td><form id=\"updateItem" . $item['eventId'] . "\" action=\"php/form-processors/update-cart-form-processor.php\" method=\"POST\">";
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
								"<td><h3><form id=\"removeItem" . $item['eventId'] . "\" action=\"php/form-processors/remove-item.php\" method=\"post\"><input id=\"r" . $item['eventId'] . "\" name=\"r" . $item['eventId'] . "\" type=\"hidden\" value=\"" .
								$item['eventId'] . "\"><button class=\"glyphicon glyphicon-trash\" aria-hiddent=\"true\" type=\"submit\"></button></h4></form></td><td><h3>$ ".$_SESSION['cartItems'][$item["eventId"]]["itemSubtotal"]."</h3></td></tr>";
							$itemCount = $itemCount-1;
						}
					}
					echo "</tbody>";
					?>
				</table>
				<?php
				echo "<form id=\"checkout\" action='php/form-processors/stripe1.php' method='post'><label for=\"subtotal\">Cart Subtotal	:</label><input type=\"hidden\" value=\"".$_SESSION['cartSubtotal']."\"<h3>$".
					$_SESSION['cartSubtotal']."</h3></form>";
				include("php/form-processors/stripe1.php");
				?>

				<br/><form id="clearCart" action="php/form-processors/clear-cart.php" method="POST"><button type="submit" class="btn btn-danger">Clear Cart</button> </form>
				<br/>
			</div>

			<div class="col-xs-4 col-md-1">
				<div class="rightFiller">

				</div>
			</div>
		</div>
	</div>
	</body>
</html>
