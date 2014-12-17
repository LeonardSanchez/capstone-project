<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
// require to connect to our server I believe
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../classes/event-category.php");
// require for the csrf protection

$mysqli = MysqliConfiguration::getMysqli();

$parentCategory = $_GET['parentCategory'];
$eventCategory	= EventCategory::getEventCategoryByEventCategoryId($mysqli, $parentCategory);
$childrenArray = $eventCategory->getEventCategoryByAllChildEvents($mysqli);
//var_dump($childrenArray);
foreach($childrenArray as $subcategory) {
	echo "<option value=\"". $subcategory->getEventCategoryId() ."\">". $subcategory->getEventCategory() ."</option>";
}