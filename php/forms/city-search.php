<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>City Search</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap.3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="city-search.js"></script>
	</head>
	<body>
		<form id="citySearchForm" method="get" action="../form-processors/city-search-form-processor.php">
			<label for="city">City</label>
			<input type="text" id="city" name="city" /><br />
			<button id="search" type="submit">Search</button>
		</form>
		<p id="outputArea"></p>
	</body>
</html>