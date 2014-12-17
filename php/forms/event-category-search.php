<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
require_once("../forms/csrf.php");
require_once("../classes/event-category.php");

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
	<script type="text/javascript" src="../../javascript/get-subcategories.js"
</head>

<body>
	<form id="eventCatSearchForm" name="catSubCat" method="get" action="../form-processors/get-subcategories.php">
		<?php echo generateInputTags(); ?>
		<label for="eventCatSearch">Search By Event Category</label><br/>
			<label for="parentCategory">Choose Category</label>
			<select name="parentCategory" id="parentCategory">
				<option selected disabled>Main Category</option>
				<?php require_once("/etc/apache2/capstone-mysql/rgevents.php");$mysqli = MysqliConfiguration::getMysqli();
				$parentCategories = EventCategory::getEventCategoryByAllParentEvents($mysqli);
				if(isset($parentCategories)===true)	{
					foreach($parentCategories as $parentCategory)	{
						echo "<option value=\"".$parentCategory->getEventCategoryId()."\">" . $parentCategory->getEventCategory() . "</option>";
					}
				}
				?>
			</select>
		<input type="submit"/>
	</form>
	<form>
			<label >Select Sub-Category</label>
			<select name="subcategory" id='subcategory' disabled>
				<option disabled>Sub-Category</option>
				<span id="subcategoryArea"></span>
			</select>
		<div class="search">
		<input id="catSearch" type="submit" value="Submit">
		</div>
	</form>


</body>