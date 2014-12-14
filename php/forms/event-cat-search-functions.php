<?php

require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../classes/event-category.php");

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

function getSubCategory()
{
	$mysqli = MysqliConfiguration::getMysqli();

	@$eventCategoryId=$_GET['eventCategoryId'];

	// grab the data out of mySQL to populate the sub-category drop down list for all Child Categories
	$results = "SELECT eventCategory FROM eventCategory WHERE parentCategory = 'eventCategoryId'";
	foreach($mysqli->query($results) as $row) {

	}

	$main = array('data'=>$result);
	echo json_encode($main);

}
?>