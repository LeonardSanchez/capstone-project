<?php
session_start();

require_once("/etc/apache2/capstone-mysql/rgevents.php");
require_once("../lib/csrf.php");
require_once("contact-us.php");

try {
	// verify that the frm submitted ok
	if (@isset($_POST["name"]) === false || @isset($_POST["email"]) === false || $isset($_POST["message"]) === false ||
			throw(new RuntimeException("Form variables incomplete or missing"));
	}
	// verify the csrf tokens
	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false) {
		throw(new RuntimeException("CSRF tokens incorrect or missing. Make sure cookies are enabled"));
	}
	// create a new object and insert it into mySQL
	$authToken = bin2hex(openssl_random_pseudo_bytes(32));
	$contactUs = new ContactUs(null,$_POST["name"], $_POST["email"]), $_POST["message"], $authToken, null, null);
	$mysqli    = MysqliConfiguration::getMysqli();
	$contactUs->insert($mysqli);

//email the user with a Thank you for Contacting Us Message
	$to   = $contactUs->getEmail();
	$from = $"redOrGreenEventsContactUs";
// build the headers
	$headers					= array();
	$headers["to"] 				= $to;
	$headers["from"] 				= $from;
	$headers["Reply To"]			= $from;
	$headers["Message"]			= $contactUs->getName() . " " . $contactUs->getEmail() . " " . $contactUs->getMessage . " , Thank you for contacting Red or Green events";





/**
 * Created by Leo.
 * Contact us form processor
 * Date: 12/11/2014
 * Time: 8:10 AM
 */