<?php
session_start();
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

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><h4><strong>Red or Green Events</strong>	-	Your Guide To New Mexico Events and Attractions</h4></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="php/forms/shopping-cart-form.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a></li>
				<li><a href="php/forms/login-form.php">Login</a></li>
				<li><a href="php/forms/profile-form.php">Update Profile</a></li>
				<li><a href="php/forms/signup-form.php">Sign Up!</a></li>
				<li><a href="#">Log Out</a></li>
			</ul>
			<form class="navbar-form navbar-right">
				<input type="text" class="form-control" placeholder="Search By City...">
			</form>
			<form class="navbar-form navbar-right">
				<input type="text" class="form-control" placeholder="Search Venues...">
			</form>
			<form class="navbar-form navbar-right">
				<input type="text" class="form-control" placeholder="Search Events...">
			</form>
		</div>
	</div>
</nav>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar" style="background-color: ActiveBorder">
			<ul class="nav nav-sidebar">
				<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
				<br>
				<h5><strong>Find Local Events</strong></h5>
				<li><a href="php/forms/event-name-search.php">Search By Events</a></li>
				<li><a href="php/forms/venue-search-form.php">Search By Venues</a></li>
				<li><a href="php/forms/event-category-search.php">Search Event Categories (THIS WILL BE A DROP DOWN)</a></li>
				<li><a href="#">Search Event Sub-Categories (THIS WILL BE A DROP DOWN)</a></li>
				<li><a href="php/forms/city-search.php">Search By City</a></li>
				<li><a href="php/forms/date-search.php">Search Events By Date</a></li>
			</ul>
			<br>
			<ul class="nav nav-sidebar">
				<li><a href="">PLACEHOLDER</a></li>
				<li><a href="">PLACEHOLDER</a></li>
				<li><a href="">PLACEHOLDER</a></li>
			</ul>
		</div>
	</div>
</div>



<!-- Bootstrap core JavaScript
 ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
<script src="../../assets/js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
