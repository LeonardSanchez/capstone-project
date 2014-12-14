<?php

require_once("/etc/apache2/capstone-mysql/rgevents.php");
$mysqli = MysqliConfiguration::getMysqli();
@$eventCategoryId=$_POST['eventCategoryId'];

// grab the data out of mySQL to populate the sub-category drop down list for all Child Categories
$results = "SELECT eventCategory FROM eventCategory WHERE parentCategory = 'eventCategoryId'";
$row=$mysqli->prepare($results);
$row->execute();
$result=$row->fetch_all(MYSQLI_ASSOC);

$eventCatSearch= array('data'=>$result);
echo json_encode($eventCatSearch);
?>