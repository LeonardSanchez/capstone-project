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

	$_SESSION["userId"] = $newUser->getUserId();
	$_SESSION["email"] = $newUser->getEmail();
	$_SESSION["profile"] = $newProfile->getProfileId();
	$_SESSION["firstName"] = $newProfile->getFirstName();
	$_SESSION["lastName"] = $newProfile->getLastName();
	$_SESSION["dateOfBirth"] = $newProfile->getDateOfBirth();

	echo "<div class='alert alert-success' role='alert'> <a href='#' class='alert-link'>Your account has been authenticated. You are now logged in to RGEvents.com.</a></div><p><a href='../../index.php'>RGEvents Home</a> </p>";

} catch(Exception $exception) {
	echo "<div class='alert alert-danger' role='alert'><a href='#' class='alert-link'>" . $exception->getMessage(). "</a></div>";
}

?>