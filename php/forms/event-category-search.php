<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
require_once("../forms/csrf.php");
require_once("../forms/event-cat-search-functions.php");

?>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>Event Category Search</title>
	<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../javascript/eventCatAJAX.js"></script>
	<script type="text/javascript" src="../../javascript/event-category-search.js"></script>
</head>

<body>
	<form id="eventCatSearchForm" name="catSubCat" method="post" action="../form-processors/event-category-search-form-processor.php">
		<?php echo generateInputTags(); ?>
		<label for="eventCatSearch">Search By Event Category</label>
			<p>Choose Category</p>
			<select name="cat" id="s1" onchange=AjaxFunction()>
				<option value=''>Select One</option>"
				<option><?php getCategory() ?></option>
			</select>

			<p>Choose Sub-Category</p>
			</select>
			<br>
			Select Subcategory
			<select name="subcat" id='s2'>
		<div class="search">
		<input id="catSearch" type="submit" value="Submit">
		</div>
	</form>

</body>