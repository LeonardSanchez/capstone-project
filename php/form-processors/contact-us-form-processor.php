<?php
session_start();

require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../lib/csrf.php");
require_once("contact-us.php");

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
		echo "<script>
					$(document).ready(function() {
						$(':input').attr('disabled', true);
						$('#login').hide();
					});
				</script>";


/**
 * Created by Leo.
 * Contact us form processor
 * Date: 12/11/2014
 * Time: 8:10 AM
 */