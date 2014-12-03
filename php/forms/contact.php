<!DOCTYPE html>
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
	<body>
		<form id="contactForm" method="post" action="../form-processors/contact-form-processor.php">
			<p>
				<label for="contactName">Name</label><br/>
				<input type="text" id="contactName" size="32"/>
			</p>
			<p>
				<label for="contactEmail">Email</label><br/>
				<input type="text" id="contactEmail"/>
			</p>
			<p>
				<label for="contactSubject">Subject</label><br/>
				<input type="text" id="contactSubject"/>
			</p>
			<p>
				<label for="contactMessage">Message</label><br/>
				<input type="text" id="contactMessage"/>
			</p>

			<p>

			</p>
		</form>
	</body>

</html>