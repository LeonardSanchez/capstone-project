<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../forms/csrf.php");
require_once("../forms/login-form.php");
require_once("../classes/user.php");
require_once("../classes/profile.php");

try {

	$mysqli = MysqliConfiguration::getMysqli();

	// verify the form was submitted OK
	if(@isset($_POST["email"]) === false || @isset($_POST["password"]) === false) {
		throw(new RuntimeException("Please enter your Email or Password"));
	}

	// verify the CSRF tokens
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
		throw(new Exception("external source violation"));
	}

	// get the email and password from the login form
	$email = $_POST["email"];
	$password = $_POST["password"];

	//filter, validate, & sanitize email and password
	$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

	// get the user by email
	$user = User::getUserByEmail($mysqli, $email);
	if(isset($user) === false) {
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong>We couldn't find your Profile. Please try again.</div>";
	}
		// if the above passes then the user record was found by the supplied email, and we can match the clear text password on the login form to the passwordHash in the database
	else {
			$salt = $user->getSalt();
			$newHash = hash_pbkdf2("sha512", $password, $salt, 2048, 128);
			$existingPassword = $user->getPasswordHash();
			// verify the newHash of the input password from the login page is equivalent to the passwordHash stored in the database
			if($existingPassword === $newHash) {

				$userId = $user->getUserId();
				$profile = Profile::getProfileByUserId($mysqli, $userId);

				$_SESSION["userId"] = $user->getUserId();
				$_SESSION["email"] = $user->getEmail();
				$_SESSION["profile"]["profileId"] = $profile->getProfileId();
				$_SESSION["profile"]["firstName"] = $profile->getFirstName();
				$_SESSION["profile"]["lastName"] = $profile->getLastName();
				$_SESSION["profile"]["dateOfBirth"] = $profile->getDateOfBirth();

				header("Location:../../index.php");
			} else {
				echo "<div class=\"alert alert-danger\" role=\"alert\">Incorrect Password. Please try again.</div>";
			}
		}
} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to log in: " . $exception->getMessage() . "</div>";
}
?>