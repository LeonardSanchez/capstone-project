<?php
session_start();
require_once("csrf.php");
?>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title></title>
	<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../javascript/sign-up.js"></script>
	</head>
		<body>
		<form id="signupForm">
			<?php generateInputTags() ?>;
			<div class="container">

				<form class="form-signin" role="form">
					<h2 class="form-signin-heading">Please complete the form to sign up for an account</h2>
					<label for="inputFirstName" class="sr-only">First Name</label>
					<input type="firstName" id="inputFirstName" class="form-control" placeholder="First Name">
					<label for="inputLastName" class="sr-only">Last Name</label>
					<input type="lastName" id="inputLastName" class="form-control" placeholder="Last Name">
					<label for="inputDateOfBirth" class="sr-only">Date of Birth</label>
					<input type="dateOfBirth" id="inputDateOfBirth" class="form-control" placeholder="Date of Birth (MM-DD-YYYY format)">
					<label for="inputGender" class="sr-only">Gender</label>
					<input type="gender" id="inputGender" class="form-control" placeholder="Gender (M, F, O)">
					<label for="inputEmail" class="sr-only">Email</label>
					<input type="email" id="inputEmail" class="form-control" placeholder="Email">
					<label for="inputPassword" class="sr-only">Password</label>
					<input type="password" id="inputPassword" class="form-control" placeholder="Password">
					<label for="inputConfirmPassword" class="sr-only">Confirm Password</label>
					<input type="confirmPassword" id="inputConfirmPassword" class="form-control" placeholder="Confirm Password">

					<button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>

				</div>
			</form>
		</body>
</html>
