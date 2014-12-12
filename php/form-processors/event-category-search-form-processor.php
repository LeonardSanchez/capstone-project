<?php
session_start();
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../forms/csrf.php");
require_once("../classes/event-category.php");

try {
	// require mySQLI
	$mysqli = MysqliConfiguration::getMysqli();

	// verify the form was submitted OK
	if(@isset($_POST["firstName"]) === false || @isset($_POST["lastName"]) === false || @isset($_POST["dateOfBirth"]) === false || @isset($_POST["gender"]) === false || @isset($_POST["email"]) === false || @isset($_POST["password"]) === false || @isset($_POST["confirmPassword"]) === false) {
		throw(new RuntimeException("Form variables incomplete or missing"));
	}

	// verify the CSRF tokens
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
		throw(new Exception("external source violation"));
	}

	$mainCatId = "SELECT eventCategoryId, eventCategory, parentCategory FROM eventCategory ORDER BY eventCategory ";
	echo "<select eventCategory"

?>