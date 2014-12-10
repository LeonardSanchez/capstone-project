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
			<form id="editProfileForm">
				First name:       <input id="firstName"       name="firstName"       type="text" /><br />
				Last name:			<input id="lastName"        name="lastName"        type="text" /><br />
				Date of Birth:		<input id="dateOfBirth"     name="dateofBirth"     type="text" /><br />
				Gender:				<input id="gender"          name="gender"          type="text" /><br />
				Email: 				<input id="email"           name="email"           type="text" /><br />
				Password:			<input id="password"        name="password"        type="text" /><br />
				Confirm password: <input id="confirmPassword" name="confirmPassword" type="text" /><br />
			<button type= "submit">Submit</button>
			<script type ="text/javascript" src ="//ajax.googleapis.com/ajax/libs/jquery.min.js"></script>
			<script type ="text/javascript" src ="//malsup.github.com/min/jquery.validate/1.11.1/j
			</form>

	</body>
</html>
