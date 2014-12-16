<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
require_once("csrf.php");
?>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>Login</title>
	<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../javascript/login.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="../../bootstrap/dist/css/signin.css" rel="stylesheet">
</head>
<body>
	<form id="loginForm" method="post" action="../form-processors/login-form-processor.php">
		<?php echo generateInputTags(); ?>

		<div class="container">
				<h3 class="login-section">Please Login</h3>
				<label for="email" class="sr-only">Email address</label>
				<input type="text" id="email" name="email" class="form-control" placeholder="Login with your email address">
				<label for="password" class="sr-only">Password</label>
				<input type="password" id="password" name="password" class="form-control" placeholder="Password">

				<button id="loginSubmit" class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

		</div>
	</form>

	<p id="outputLogin"></p>

</body>

</html>
