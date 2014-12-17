<?php
session_start();
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../forms/csrf.php");
require_once("../classes/event-category.php");

//try {
	// require mySQLI
	$mysqli = MysqliConfiguration::getMysqli();

	// verify the CSRF tokens
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
		throw(new Exception("external source violation"));
	}


?>