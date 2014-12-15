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

	$oldPassword = $user->getPasswordHash();
	$currentPassword = null;
	$newPassword = null;
	$confirmPassword = null;
	//acquire passwords from POST
	$currentPassword = $_POST["currentPassword"];
	$newPassword = $_POST["newPassword"];
	$confirmPassword = $_POST["confirmPassword"];
	//hash the current password
	$salt		= $user->getSalt();
	$hash 	= hash_pbkdf2("sha512", $currentPassword, $salt, 2048, 128);
	//make sure that all fields are filled
	if(empty($currentPassword) === true || empty($newPassword) === true || empty($confirmPassword) === true){
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>All password fields must be filled</p></div>";
	}
	//confirm that current password matches old password
	elseif($hash !== $oldPassword){
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Incorrect Password</p></div>";
	}
	//make sure that the new and confirmed password match
	elseif($newPassword !== $confirmPassword){
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Passwords must match</p></div>";
	}
	else{
		//No that you made it this far set new password
		$salt		= $user->getSalt();
		$newHash 	= hash_pbkdf2("sha512", $newPassword, $salt, 2048, 128);
		$user->setPasswordHash($newHash);
		$user->update($mysqli);
		echo "<div class=\"alert alert-success\" role=\"alert\"><p>Password Changed</p></div>";
	}

}
catch (Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to update Profile: " . $exception->getMessage() . "</div>";
}
?>
