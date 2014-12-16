<?php
if(!isset($_SESSION))
{
	session_start();
}
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../classes/user.php");
require_once("../classes/profile.php");
require_once("../forms/csrf.php");
require_once("Mail.php");

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
	var_dump($csrfName, $csrfToken);

	if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
		throw(new Exception("external source violation"));
	}

	$firstName 			= filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
	$lastName 			= filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
	$dateOfBirth		= filter_input(INPUT_POST, 'dateOfBirth', FILTER_SANITIZE_STRING);
	$dateOfBirth		= DateTime::createFromFormat("m-d-Y", $dateOfBirth);
	$gender				= filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
	$email				= filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	$password			= filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	$confirmPassword	= filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_STRING);


	// create a new object and insert it to mySQL
	$authToken = bin2hex(openssl_random_pseudo_bytes(16));
	$salt = bin2hex(openssl_random_pseudo_bytes(32));
	$passwordHash = hash_pbkdf2("sha512", $password, $salt, 2048, 128);
	$user = new User(null, $email, $passwordHash, $salt, $authToken);
	$user->insert($mysqli);
	$profile = new Profile(null, $user->getUserId(), $firstName, $lastName, $dateOfBirth, $gender);
	$profile->insert($mysqli);

	// email the user with an activation message
	$to 	= $user->getEmail();
	$from	= "james.mistalski@gmail.com";

	// build headers
	$headers 					= array();
	$headers["To"] 			= $to;
	$headers["From"] 			= $from;
	$headers["Reply-To"] 	= $from;
	$headers["Subject"] 		= $profile->getFirstName() . " " . $profile->getLastName() . ", Activate your RGEvents Login";
	$headers["MIME-Version"] = "1.0";
	$headers["Content-Type"] = "text/html; charset=UTF-8";

	// build message
	$pageName 	= end(explode("/", $_SERVER["PHP_SELF"]));
	$url 			= "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"];
	$url 			= str_replace($pageName, "activate.php", $url);
	$url 			= "$url?authToken=$authToken";
	$message 	= <<< EOF
<html>
    <body>
        <h1>Welcome to Red or Green Events!</h1>
        <hr />
        <p>Thank you for signing up for a Red or Green Events Login. Visit the following link to complete your registration process: <a href="$url">$url</a>.</p>
    </body>
</html>
EOF;
	// send the email
	error_reporting(E_ALL & ~E_STRICT);
	$mailer =& Mail::factory("sendmail");
	$status = $mailer->send($to, $headers, $message);
	if(PEAR::isError($status) === true)
	{
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to send mail message:" . $status->getMessage() . "</div>";
	}
	else
	{

	echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Sign up successful!</strong> Please check your Email to complete the signup process.</div>";
}

} catch(Exception $exception) {
	$_SESSION[$csrfName]=$csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to sign up: " . $exception->getMessage() . "</div>";
}
?>
