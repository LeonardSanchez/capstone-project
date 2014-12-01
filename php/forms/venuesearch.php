<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Venue Search</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://malsup.github.com/jquery.form.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="venuesearch.js"></script>
	</head>
	<body>
		<form id="venueSearch" method="get" action="venue.php">
			<label for="venue">Venue</label>
			<input type="text" id="venue" name="venue" /><br />
			<button id="search" type="submit">Search</button>
		</form>
	</body>


</html>
