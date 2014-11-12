<?php
/**
 * unit test for event.php
 *
 * Sebastian Sandoval <sbsandoval42@gmail.com>
 */
require_once("/usr/lib/php5/simpletest/autorun.php");

require_once("../php/event.php");

require_once("/etc/apache2/capstone-mysql/rgevents.php");

class Event extends UnitTestCase	{

	private $mysqli = null;
	private $event = null;

	private $EVENT_NAME			=	"Wobsky";
	private $EVENT_DATE_TIME	=	"2014-11-24 19:30:00";
	private $TICKET_PRICE		=	7000.00;
}