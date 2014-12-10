<?php
session_start();
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../classes/profile.php");
require_once("../classes/user.php");

try {
	// require mySQLI
	$mysqli = MysqliConfiguration::getMysqli();

	echo "<p>Authenticating your account</p>";
	$authToken = $_GET['authToken'];
	$newUser = User::getUserByAuthToken($mysqli, $authToken);
	$newProfile = Profile::getProfileByUserId($mysqli, $newUser->getUserId());



?>