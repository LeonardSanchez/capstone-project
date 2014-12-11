<?php
session_start();
// require
require_once("../contactUs.php");
// require
require_once("../contact-us.php");
// require
require_once("../contactUs.php");
// require
require_once("/etc/apache2/capstone-mysql/rgevents.php");

try	{

function generateToken() {
	$token = hash("sha512", mt_rand(0, mt_getrandmax()));
	return($token);

/**
 * Created by Leo.
 * Contact us form processor
 * Date: 12/11/2014
 * Time: 8:10 AM
 */