<?php
if(session_status() === PHP_SESSION_NONE)	{
	session_start();
}
require_once("../php/forms/csrf.php");

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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="../../dist/js/bootstrap.min.js"></script>
	<script src="../../assets/js/docs.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="dashboard.css" rel="stylesheet">

	<script src="../../assets/js/ie-emulation-modes-warning.js"></script>

	<link type="text/css" rel="stylesheet" href="site-css.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
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
			<a class="navbar-brand" href="../index.php"><h3><strong><span style="color: #C53337">Red</span> or <span style="color: green">Green</span> Events</strong>	-	Find Events With A Local Flavor</h3></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../php/forms/shopping-cart-form.php"><span class="glyphicon glyphicon-shopping-cart" style="color: #C53337" aria-hidden="true"></span></a></li>
				<li class="dropdown">
					<a href="#" id="myaccdrop" class="dropdown-toggle" data-toggle="dropdown" role="button" style="color: #6F751B" aria-expanded="false">My Account<span class="caret"></span></a>
					<ul id="account-list-options" class="dropdown-menu" role="menu" style="background-color: #C53337">
						<li><a href="../php/forms/login-form.php">Log In</a></li>
						<li><a href="../php/forms/update-profile.php">Update Profile</a></li>
						<li><a href="../php/forms/signup-form.php">Sign Up</a></li>
						<li><a href="../php/forms/log-out.php/">Log Out</a></li>
					</ul>
				</li>
			</ul>
			<form class="navbar-form navbar-right" id="citySearchForm" method="get" action="../php/form-processors/city-search-form-processor.php">
				<input type="text" id="city" name="city" style="background-color: beige" class="form-control" placeholder="Search Venues By City...">
			</form>
			<form class="navbar-form navbar-right" id="venueSearchForm" method="get" action="../php/form-processors/venue-search-form-processor.php">
				<input type="text" id="venue" name="venue" style="background-color: beige" class="form-control" placeholder="Search Venues...">
				<!--<span class="clearer glyphicon glyphicon-remove-circle form-control-feedback"></span> This is to clear out the field but it is not residing IN the search box-->
			</form>
			<form class="navbar-form navbar-right" id="eventNameSearchForm" method="get" action="../php/form-processors/event-name-search-form-processor.php">
				<input type="text"  id="eventName" name="eventName" style="background-color: beige" class="form-control" placeholder="Search Events...">
			</form>
		</div>
	</div>
</nav>
<!-- end of top nav bar -->