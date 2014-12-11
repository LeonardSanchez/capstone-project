<?php
session_start();

require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../forms/csrf.php");
require_once("Mail.php");

try {
	// verify that the frm submitted ok
	if (@isset($_POST["name"]) === false || @isset($_POST["email"]) === false || @isset($_POST["message"]) === false) {
			throw(new RuntimeException("Form variables incomplete or missing"));
	}

	// verify the CSRF tokens
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if((verifyCsrf($_POST["csrfName"], $_POST["csrfToken"])) === false) {
		throw(new Exception("external source violation"));
	}

	// user sends email to info@rgevents.com
	$to 	= "james.mistalski@gmail.com";
	$from	= filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
	$insertMessage = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);

	// build headers
	$headers 					= array();
	$headers["To"] 			= $to;
	$headers["From"] 			= $from;
	$headers["Reply-To"] 	= $from;
	$headers["Subject"] 		= $_POST["name"] . " sent a message from RGEvents.com";
	$headers["MIME-Version"] = "1.0";
	$headers["Content-Type"] = "text/html; charset=UTF-8";

	// build message
	$insertMessage = str_replace("\n", "<br />", $insertMessage);
	$message 	= <<< EOF
<html>
	<body>
        <h1>A wonderful user sent a message!</h1>
        <hr />
        <p>A user has sent an email through the Contact Us form on RGEvents.com. Please make sure to review the email, and reach out to the user if needed.</p>
  	</body>
</html>
$insertMessage
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

		echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Success! Email sent</strong></div>";
	}

} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Oh snap!</strong> Unable to send email: " . $exception->getMessage() . "</div>";
}
?>