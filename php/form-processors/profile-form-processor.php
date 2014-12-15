<?php
if(session_status() === PHP_SESSION_NONE) {
	session_start();
}
require_once("../classes/profile.php");
require_once("../classes/user.php");
require_once("/etc/apache2/capstone-mysql/rgevents.php");

try {

	// verify the CSRF tokens
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
		throw(new Exception("external source violation"));
	}

	// require mySQLI
	$mysqli = MysqliConfiguration::getMysqli();

	// get profileId from $_SESSION
	$profileId = $_SESSION["profile"]["profileId"];

	// get userId from $_SESSION
	$userId = $_SESSION["user"]["userId"];

	// obtain info from edit-profile-form.php and set values into object if field was updated
	$firstName = $_POST["firstName"];
	if(empty($firstName) === false) {
		$profile->setFirstName($firstName);
		$_SESSION["profile"]["firstName"] = $profile->getFirstName();
	}

	$lastName = $_POST["lastName"];
	if(empty($lastName) === false) {
		$profile->setLastName($lastName);
		$_SESSION["profile"]["lastName"] = $profile->getLastName();
	}

	$dateOfBirth = $_POST["dateOfBirth"];
	if(empty($dateOfBirth) === false) {
		$profile->setDateOfBirth($dateOfBirth);
		$_SESSION["profile"]["dateOfBirth"] = $profile->getDateOfBirth();
	}

	$gender = $_POST["gender"];
	if(empty($gender) === false) {
		$profile->setGender($gender);
		$_SESSION["profile"]["gender"] = $profile->getGender();
	}

	$email = $_POST["email"];
	if(empty($email) === false) {
		$user->setEmail($email);
		$_SESSION["user"]["email"] = $user->getEmail();
	}

	$newPassword = $_POST["newPassword"];
	if(empty($newPassword) === false) {
		$authToken = bin2hex(openssl_random_pseudo_bytes(16));
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$passwordHash = hash_pbkdf2("sha512", $_POST["newPassword"], $salt, 2048, 128);
		$user->setPasswordHash($passwordHash);
	}
	$confirmNewPassword = $_POST["confirmNewPassword"];
	if(empty($confirmNewPassword) === false) {
		$authToken = bin2hex(openssl_random_pseudo_bytes(16));
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$passwordHash = hash_pbkdf2("sha512", $_POST["confirmNewPassword"], $salt, 2048, 128);
		$user->setPasswordHash($passwordHash);{
		}
	}


	else {
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p><strong>Oh snap!</strong>No Entries to Update</p></div>";
	}

}
catch (Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to update Profile: " . $exception->getMessage() . "</div>";
}
?>
