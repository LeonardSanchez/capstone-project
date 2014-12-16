<?php

require_once("/etc/apache2/capstone-mysql/rgevents.php");

// name the function
function getCategory()
{
	$mysqli = MysqliConfiguration::getMysqli();
// grab the data out of mySQL to populate the category drop down list for all Parent Categories
	$results = "SELECT eventCategory, eventCategoryId FROM eventCategory WHERE parentCategory IS NULL ORDER BY eventCategory";
	foreach($mysqli->query($results) as $row) {
		echo "<option value=$row[eventCategory]selected>$row[eventCategory]</option>";
	}

}
?>