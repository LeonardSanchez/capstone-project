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
	<title>Sign Up for RGEvents</title>
	<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../javascript/sign-up.js"></script>
</head>
<body>
	<form id="signupForm" name="signupForm" method="post" action="../form-processors/signup-form-processor.php">
		<?php echo generateInputTags(); ?>

		<div class="container">

				<h3 class="signupForm">Please complete the form to sign up for a RGEvents account</h3>
				<label for="firstName" class="sr-only">First Name</label>
				<input type="text" id="firstName" name="firstName" class="form-control alert" placeholder="First Name">
				<label for="lastName" class="sr-only">Last Name</label>
				<input type="text" id="lastName" name="lastName" class="form-control alert" placeholder="Last Name">
				<label for="dateOfBirth" class="sr-only alert">Date of Birth</label>
				<!--FIXME: need to have Date of Birth displayed in field, but since it is set as type="date" it seems to be overriding it-->
				<input type="text" id="dateOfBirth" name="dateOfBirth" class="form-control alert" placeholder="Date of Birth mm-dd-yyyy">
				<label for="gender" class="sr-only alert">Gender</label>
				<input type="text" id="gender" name="gender" class="form-control alert" placeholder="Gender (M, F, O)">
				<label for="email" class="sr-only alert">Email</label>
				<input type="text" id="email" name="email" class="form-control alert" placeholder="Email">
				<label for="password" class="sr-only alert">Password</label>
				<input type="password" id="password" name="password" class="form-control alert" placeholder="Password">
				<label for="confirmPassword" class="sr-only alert">Confirm Password</label>
				<input type="password" id="confirmPassword" name="confirmPassword" class="form-control alert" placeholder="Confirm Password">

				<button id="signupSubmit" class="btn btn-lg btn-primary btn-block alert" type="submit">Sign Up</button>
		</div>
	</form>
	<p id="outputSignUp"></p>
</body>
</html>
