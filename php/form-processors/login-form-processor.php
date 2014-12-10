<?php
session_start();
require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../lib/csrf.php");
require_once("login.php");
try {
	// verify the form was submitted OK
	if (@isset($_POST["email"]) === false || @isset($_POST["password"]) === false) {
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
    $profile   = new Login(null, $_POST["email"], $_POST["password"], null, null);
    $mysqli    = MysqliConfiguration::getMysqli();
    $profile->insert($mysqli);


    // build headers
    $headers                 = array();
    $headers["To"]           = $to;
    $headers["From"]         = $from;
    $headers["Repy-To"]      = $from;
    $headers["Subject"]      = $login->getEmail() . " " . $login->getPassword() . " " . "Welcome back to Red or Green Events";
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
        <h1>Welcome to Red or Green Events!</h1>
        <hr />
        <p>Welcome to Red or Green Events! <a href="$url">$url</a>.</p>
    </body>
</html>
EOF;



?>



}