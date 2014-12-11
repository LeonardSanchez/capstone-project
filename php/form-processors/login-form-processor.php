<?php
session_start();
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../lib/csrf.php");
require_once("login.php");

try {

	$mysqli = MysqliConfiguration::getMysqli();
	$sessionName = $_POST["csrfName"];
	$sessionToken = $_POST["csrfToken"];
	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false) {
		throw(new RuntimeException("Make sure cookies are enabled"));
	}
	//filter, validate, & sanitize email and password
	$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
	if(isset($_SESSION['userId'])) {

		$user = User::getUserByEmail($mysqli, $email);
		if($user === null) {
			throw(new ErrorException("User not found"));
			echo "<div class=\"alert alert-danger\" role=\"alert\"><p>User not found!/p></div>";
		}
		if($user->getAuthenticationToken() === null) {
			throw(new ErrorException("Not Valid"));
			echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Not Valid/p></div>";
		}
		$passwordHash = hash_pbkdf2("sha512", $password, $user->getSalt(), 2048, 128);
		if(!($passwordHash === $user->getPassword())) {
			throw(new UnexpectedValueException("Email or Password is not correct"));
			echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Email or Password Not Valid/p></div>";
		} else {
			$_SESSION["userId"] = $user->getUserId();
			echo "<div class=\"alert alert-success\" role=\"alert\">Successful Sign In</div>







?>