<?php
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/venue.php");

// the VenueTest is a container for all our tests
class VenueTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli	= null;
	// variable to hold the test database row
	private $venue		= null;

	// a few "global" variables for creating test data
	private $VENUE_ID				= ?;
	private $VENUE_NAME			= ?;
	private $VENUE_CAPACITY		= ?;
	private $VENUE_
}