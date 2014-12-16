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

<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color: #D1BBA1">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><h3><strong><span style="color: #C53337">Red</span> or <span style="color: green">Green</span> Events</strong>	-	Find Events With A Local Flavor</h3></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="php/forms/shopping-cart-form.php"><span class="glyphicon glyphicon-shopping-cart" style="color: #C53337" aria-hidden="true"></span></a></li>
				<li class="dropdown">
					<a href="#" id="myaccdrop" class="dropdown-toggle" data-toggle="dropdown" role="button" style="color: #6F751B" aria-expanded="false">My Account<span class="caret"></span></a>
						<ul id="account-list-options" class="dropdown-menu" role="menu" style="background-color: #C53337">
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
				<div class="col-xs-7 col-md-3" style="background-color: ActiveBorder">
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
								<p id="outputDateSearch"></p>
							</article>

<!--							<aside>-->
<!--								<h5><strong>Search By Event Category</strong></h5>-->
<!--								<form id="eventCatSearchForm" name="catSubCat" method="post" action="php/form-processors/event-category-search-form-processor.php">-->
<!--									--><?php //echo generateInputTags(); ?>
<!--									<label for="eventCatSearch" class="sr-only"></label>-->
<!--									<p>Choose Category</p>-->
<!--									<select class="form-control" name="cat" id="s1" onchange=AjaxFunction()>-->
<!--										<option value=''>Select One</option>"-->
<!--										<option>--><?php //getCategory() ?><!--</option>-->
<!--									</select>-->
<!--									<div class="search">-->
<!--										<button id="search" class="btn btn-rgevents" type="submit">Search</button>-->
<!--									</div>-->
<!--								</form>-->
<!--							</aside>-->
					</ul>
					<br>
					<ul class="nav nav-sidebar">
						<li>
							<a id="contactbutton" class="btn btn-contact" href="php/forms/contact-form.php">Contact Us</a>
						</li>

					</ul>
				</div>

				<div class="col-xs-13 col-md-8" id="indexContent">
					<br>
					<br>
					<br>
					<br>
					<h3>Welcome to <span style="color: #C53337">Red</span> or <span style="color: green">Green</span> Events!</h3><div><a href="images/redgreenchilelarge.jpg"></a></div>
					<br>
					<article style="background-image: url(https://lh5.googleusercontent.com/WHkxyZ0wYHicjPaUmccqLmx7T1TFhcDaZRA4FhBMoA=w575-h207-p-no)">
						<div id="landingData" class="landing-page" name="landing-page">
							<p>Thank you for visiting Red Or Green Events, you home for purchasing tickets to New Mexico's best events and attractions!</p>
							<br>
							<p>You will find the most popular events and attractions for the Greater Albuqeuerque, NM and surrounding areas.</p>
							<p>Please take a moment to sign up for Red Or Green Events so that you can purchase tickets.</p>
							<p>We hope that you will enjoy using Red Or Green Events. We welcome your feedback via the Contact Us form to improve your experience shoppin with us.</p>

						</div>
						<br>
						<br>


					</article>

					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
						</ol>

						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item active">
								<img src="https://lh3.googleusercontent.com/-fkmSaw5F7Rs/VI9ydOHlwdI/AAAAAAAAABo/2-vMu8cHueQ/w1050-h450-no/reelbigfishsunshine1050x450.png" alt="...">
								<div class="carousel-caption">
									<h3>FEATURED BAND: REEL BIG FISH</h3>
								</div>
							</div>
							<div class="item">
								<img src="https://lh3.googleusercontent.com/-EGe_FBgEm08/VI9yc_oqdoI/AAAAAAAAABg/SI5PfbSjoRw/w1050-h450-no/thekimotheater_front1050x450.png" alt="...">
								<div class="carousel-caption">
									<h3>FEATURED VENUE: THE KIMO THEATRE</h3>
								</div>
							</div>
							<div class="item">
								<img src="https://lh3.googleusercontent.com/-uz3vf63pQhA/VI9ydMWfTWI/AAAAAAAAABk/bKkvFzZwkhc/w1050-h450-no/thenutcrackerpopejoy1050x450.png" alt="...">
								<div class="carousel-caption">
									<h3>FEATURED STAGE SHOW: THE NUTCRACKER SUITE</h3>
								</div>
							</div>
						</div>

						<!-- Controls -->
						<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					</div> <!-- Carousel -->
				</div>
				</div>

			<div class="col-xs-4 col-md-1" id="indexContent">
				<div class="rightFiller">

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
