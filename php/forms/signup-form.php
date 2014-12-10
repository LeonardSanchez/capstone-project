<?php
    if(!isset($_SESSION))
	 {
		 session_start();
	 }
require_once("../forms/csrf.php");
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
	<form id="signupForm" method="post" action="../form-processors/signup-form-processor.php">
		<?php echo generateInputTags(); ?>

		<div class="container">

				<h2 class="form-signin-heading">Please complete the form to sign up for an account</h2>
				<label for="firstName" class="sr-only">First Name</label>
				<input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name">
				<label for="lastName" class="sr-only">Last Name</label>
				<input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last Name">
				<label for="dateOfBirth" class="sr-only">Date of Birth</label>
				<!--FIXME: need to have Date of Birth displayed in field, but since it is set as type="date" it seems to be overriding it-->
				<input type="date" id="dateOfBirth" name="dateOfBirth" class="form-control" placeholder="Date of Birth mm-dd-yyyy">
				<label for="gender" class="sr-only">Gender</label>
				<input type="text" id="gender" name="gender" class="form-control" placeholder="Gender (M, F, O)">
				<label for="email" class="sr-only">Email</label>
				<input type="email" id="email" name="email" class="form-control" placeholder="Email">
				<label for="password" class="sr-only">Password</label>
				<input type="password" id="password" name="password" class="form-control" placeholder="Password">
				<label for="confirmPassword" class="sr-only">Confirm Password</label>
				<input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm Password">

				<button id="signupSubmit" class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
		</div>
	</form>
	<p id="outputSignUp"></p>
</body>
</html>