<?php

?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>Contact</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet"/>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap.3.3.1/js/bootstrap.min.js"></script>
	</head>
	<body role="document">
	<!-- fixed navbar-->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation"></nav>
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href=".">Red or Green Events</a>
		</div>
		<div class="navbar-collapse collapse">

		</div><!--/.nav-collapse -->
	</div>
	</nav>
	<div class="container theme-showcase" role="main">
		<article>
			<div class="page-header">
				<h1>Contact Us</h1>
			</div>
			<p id="outputArea"></p>
			<form id="contactForm" method="post" action="lib/email.php">
				<p>
					<label for="name">Name</label><br />
					<input type="text" id="name" name="name" size="32" placeholder="Enter your name" />
				</p>
				<p>
					<label for="email">Email</label><br />
					<input type="email" id="email" name="email" size="32" placeholder="Enter your Email Address" />
				</p>

				<p>
					<label for="message">Message</label><br />
					<textarea id="message" name="message" cols="32" rows="8" placeholder="Enter your message here"></textarea>
				</p>
				<p>
					<label>Submit</label><br />
					<button class="btn btn-primary" type="submit">Send</button>
					<button class="btn btn-primary" type="reset">Clear</button>
				</p>
			</form>
		</article>

	</div>
	</body>
</html>

