/**
 * Created by Leonard on 12/1/2014.
 */
<?php
session_start();
require_once("/etc/apache2/capstone-mysql/prework.php");
require_once("../lib/csrf.php");
require_once("profile.php");
require_once("Mail.php");

try {
	// verify the form was submitted OK
	if (@isset($_POST["firstName"]) === false || @isset($_POST["lastName"]) === false || @isset($_POST["dateOfBirth"]) === false || @isset($_POST["gender"]) === false @isset($_POST["email"]) === false) {
		throw(new RuntimeException("Form variables incomplete or missing"));
	}

    // verify the CSRF tokens
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false) {
		throw(new Exception("external source violation"));
	}

    // create a new object and insert it to mySQL
    $authToken = bin2hex(openssl_random_pseudo_bytes(16));
    $profile   = new Profile(null, $_POST["firstName"], $_POST["lastName"], $_POST["dateOfBirth"], $_POST["gender"], $_POST["email"], $authToken, null, null);
    $mysqli    = MysqliConfiguration::getMysqli();
    $profile->insert($mysqli);

    // email the user with an activation message
    $to   = $profile->getEmail();
    $from = "leonard@cnm.edu";

    // build headers
    $headers                 = array();
    $headers["To"]           = $to;
    $headers["From"]         = $from;
    $headers["Repy-To"]      = $from;
    $headers["Subject"]      = $profile->getFirstName() . " " . $profile->getLastName() . " ". $profile->getDateOfBirth . " " . $profile->getGender ." " . $profile->getEmail . "Welcome back to Red or Green Events";
    $headers["MIME-Version"] = "1.0";
    $headers["Content-Type"] = "text/html; charset=UTF-8";

    // build message
    $pageName = end(explode("/", $_SERVER["PHP_SELF"]));
    $url      = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"];
    $url      = str_replace($pageName, "activate.php", $url);
    $url      = "$url?authToken=$authToken";
    $message  = <<< EOF
<html>
    <body>
        <h1>Welcome back to Red or Green Events!</h1>
        <hr />
        <p>Welcome back to Red or Green Events! <a href="$url">$url</a>.</p>
    </body>
</html>
EOF;

    // send the email
    error_reporting(E_ALL & ~E_STRICT);
    $mailer =& Mail::factory("sendmail");
    $status = $mailer->send($to, $headers, $message);
    if(PEAR::isError($status) === true)
	 {
		 echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Yo MAMA!</strong> Unable to send mail message:" . $status->getMessage() . "</div>";
	 }
	 else
	 {
		 echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Profile Login successful!</strong> Welcome back to Red or Green Events!</div>";
	 }

} catch(Exception $exception) {
	echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Yo MAMA!</strong> Unable to find profile: " . $exception->getMessage() . "</div>";
}
?>

/**
 * Created by PhpStorm.
 * User: Leonard
 * Date: 12/1/2014
 * Time: 1:34 PM
 */ 