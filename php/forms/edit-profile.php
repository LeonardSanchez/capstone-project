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
	<script type="text/javascript" src="../../javascript/edit-profile.js"></script>
</head>
<body>
	<form id="updateProfile" method="post" action="../form-processors/edit-profile-form-processor.php">
	<?php echo generateInputTags(); ?>

		<div class="container">

            <label for="firstName">First Name</label>
            <input type="text" id="firstName" name="firstName" /><br />
            <label for="lastName">Last Name</label>
            <input type="text" id="lastName" name="lastName" /><br />
            <label for="dateOfBirth">Date of Birth</label>
			   <input type="text" id="dateOfBirth" name="dateOfBirth" /><br />
			   <label for="gender">Gender</label>
			  	<input type="text" id="gender" name="gender" /><br />
			  	<label for="email">Change Email Address</label>
			  	<input type="text" id="email" name="email" /><br />
			  	<label for="password">Change Password</label>
			  	<input type="text" id="password" name="password" /><br />
			  	<label for="confirmPassword">Confirm Changed Password</label>
			  	<input type="text" id="confirmPassword" name="confirmPassword" /><br />
			   <label for="avatar">Avatar File (JPG and PNG only)</label>
            <input type="file" id="avatar" name="avatar" /><br />
            <button type="submit">Update Profile</button>
		  </div>
	  </form>
    </body>
</html>

