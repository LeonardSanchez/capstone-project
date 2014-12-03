/**
 * Created by Leonard on 12/1/2014.
 */
<?php
session_start();
require_once("/etc/apache2/capstone-mysql/prework.php");
require_once("../lib/csrf.php");
require_once("signup.php");
require_once("Mail.php");

try {
   //verify that the form submitted OK
}	if (@isset($_POST["firstName"],) === false || @isset($_POST["lastName"]) === false || @isset($_POST["dateOfBirth"]) === false || @isset($_POST["gender"]) === false @isset($_POST["email"] === false {
		throw(new RuntimeException("Form variables incomplete or missing"));
	}
	//verify the CSRF tokens
	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false) {
		throw(new RuntimeException("CSRF tokens incorrect or missing. Make sure cookies are enabled"));
		}
	// create a new object and insert it into mySQL
	$authToken = bin2hex(openssl_random_pseudo_bytes(16));
	$signup    = new Signup(null, $_POST["firstName"], $_POST["lastName"], $_POST["dateOfBirth"], $_POST["gender"], $_POST["email"], $authToken, null, null);
	$mysqli    = MysqliConfiguration::getMysqli();
	$signup->insert(mysqli);

	//email the user with an activation message
	$to   = $signup->getEmail ();
	$from = "leonard@cnm.edu";

	//build headers
	$headers							= array();
	$headers["To"] 				= $to;
	$headers["From"]				= $from;
	$headers["Reply-To"]			= $from;
	$headers["Subject"] 			= $signup->getFirstName() . " " . $signup->getLastName . ", Activate your Red Or Green Events Login";
	$headers["MIME-Version"]   = "1.0";
	$headers["Content-Type"]   = "text/html; charset=UTF-8";

	//build message
	$pageName = end(explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"]));
	$url		 = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"];
	$url      = str_replace(#pageName, "activeate.php", $url);
	$url      = "url?authToken=$authToken";
	$message  = <<<EOF
<html>
	<body>
		<h1>Welcome to Red or Green Events</h1>
		<hr />
		<p>Thank you for signing up with Red or Green Events. Visit the following URL to complete your registration process. <a href="$url">$url</a>.</p>
	</body>
</html>
EOF:

	//send the email
	error_reporting(E_ALL & ~E_STRICT);
	$mailer =& Mail ::factory("sendmail");
	$status = $mailer->send($to, $headers, $message);
	if (PEAR::isError($status) === true)
	{
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>YO MAMA!</strong> Unable to send mail message: $status->getMessage(). </div>;
	}
		else
	{
		echo"<div class=\"alert alert-success\" role="alert\"><strong>Sign up successful!</strong>Welcome to red or Green Events.</div>";
		}
} catch(Exception $exception){
		echo"<div class=\"alert alert-danger\" role=\"alert\"><strong>YO MAMA!</strong>Unable to sign up: " . $exception->getMessage() . </div>";
	}
	?>