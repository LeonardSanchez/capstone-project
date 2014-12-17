<?php
if(session_status() === PHP_SESSION_NONE)	{
	session_start();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>Event Name Search</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap.3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../../javascript/date-search.js"></script>
	</head>

	<body>
	<div class="container">
		<div class="col-lg-4">
		<form id="dateSearchForm" method="get" action="../form-processors/date-search-form-processor.php">
			<label for="startDate" class="sr-only">Start Date</label>
			<input type="text" id="startDate" name="startDate" class="form-control" placeholder="mm-dd-yyyy"/><br/>
			<label for="endDate" class="sr-only">End Date</label>
			<input type="text" id="endDate" name="endDate" class="form-control" placeholder="mm-dd-yyyy"><br/>
		</div>
				</div>
			<button id="search" class="btn btn-lg btn-primary btn-block" type="submit">Search</button>
		</form>
		<p id="outputDateSearch"></p>
	</body>
</html>