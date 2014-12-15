<?php
if(session_status() === PHP_SESSION_NONE)	{
	session_start();
}
require_once("php/forms/csrf.php");
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

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><h4><strong>Red or Green Events</strong>	-	Find Events With A Local Flavor</h4></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="php/forms/shopping-cart-form.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account<span class="caret"></span></a>
						<ul id="account-list-options" class="dropdown-menu" role="menu">
							<li><a href="php/forms/login-form.php">Log In</a></li>
							<li><a href="php/forms/update-profile.php">Update Profile</a></li>
							<li><a href="php/forms/signup-form.php">Sign Up</a></li>
							<li><a href="php/forms/log-out.php/">Log Out</a></li>
							</ul>
				</li>
			</ul>
			<form class="navbar-form navbar-right" id="citySearchForm" method="get" action="php/form-processors/city-search-form-processor.php">
				<input type="text" id="city" name="city" style="background-color: beige" class="form-control" placeholder="Search Venues By City...">
			</form>
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
				<div class="col-xs-6 col-md-2" style="background-color: ActiveBorder">
					<ul class="nav nav-sidebar" id="leftnav1">
						<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
						<br>
						<h5><strong>Find Local Events</strong></h5>
						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title">Select Event Category</h3>
							</div>
						</div>
						<li><a href="php/forms/event-name-search.php">Search By Events</a></li>
						<li><a href="php/forms/venue-search-form.php">Search By Venues</a></li>
						<li><a href="php/forms/event-category-search.php">Search Event Categories (THIS WILL BE A DROP DOWN)</a></li>
						<li><a href="#">Search Event Sub-Categories (THIS WILL BE A DROP DOWN)</a></li>
						<li><a href="php/forms/city-search.php">Search By City</a></li>
						<article>Search Events By Date
							<form id="dateSearchForm" method="get" action="../form-processors/date-search-form-processor.php">
								<label for="startDate">Start Date</label>
								<input type="text" id="startDate" name="startDate" placeholder="mm-dd-yyyy"/><br/>
								<label for="endDate">End Date</label>
								<input type="text" id="endDate" name="endDate" placeholder="mm-dd-yyyy"><br/>
								<button id="search" type="submit">Search</button>
							</form>
							<p id="outputDateSearch"></p>
						</article>
						<li><a href="php/forms/date-search.php">Search Events By Date</a></li>
					</ul>
					<br>
					<ul class="nav nav-sidebar">
						<li><a href="php/forms/contact-form.php">Contact Us</a></li>

					</ul>
				</div>

				<div class="col-xs-12 col-md-10" id="indexContent">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
						</ol>
						<div class="carousel-inner" role="listbox">
							<div class="item">
								<img data-src="holder.js/1140x500/auto/#777:#555/text:FEATURED VENUE: THE KIMO THEATRE" alt="FEATURED VENUE: THE KIMO THEATRE"  src="images/thekimotheater-front.jpg" data-holder-rendered="true">
							</div>
							<div class="item">
								<img data-src="holder.js/1140x500/auto/#666:#444/text:FEATURED " alt="Second slide" src="images/reelbigfishsunshine.jpg" data-holder-rendered="true">
							</div>
							<div class="item">
								<img data-src="holder.js/1140x500/auto#555:#333/text:Third slide" alt="Third slide [1140x500]" data-holder-rendered="true">
							</div>
						</div>
						<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
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
