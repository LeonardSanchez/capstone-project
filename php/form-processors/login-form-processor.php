<?php
if(!isset($_SESSION))
{
	session_start();
}
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../classes/login.php");
require_once("../classes/user.php");
require_once("../classes/profile.php");
require_once("../forms/csrf.php");

try {

// connect to mySQL
	$mysqli = MysqliConfiguration::getMysqli();
// verify the CSRF tokens
if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
	throw(new Exception("external source violation"));
}
//obtain email from $_SESSION
	$email = $_POST["email"];
	$password = $_POST["password"];

//obtain user by email
	$user = User::getUserByEmail($mysqli, $email);

	if(isset($user) === false) {
//use bootstrap div alert
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>No Such User Found/p></div>";
	}
//verify the correct password

	if (isset($password) === false) {
// use bootstrap div to alert
		echo "<div class=\"alert alert-danger\" role=\"alert\"><p>Invalid Password/p></p></div>";
	}


}
?>
}