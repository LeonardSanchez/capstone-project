<?php
// 1st require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// require mySQLI
require_once("/etc/apache2/capstone-mysql/rgevents.php");

class RgEventsSuite extends TestSuite {
	// the constructor for a TestSuite just sets up all the file names
	public function __construct() {
		// run the parent constructor
		parent::__construct();

		// stuff the test files into an array
		// TODO: add the files in the "forward" order
		$testFiles = array("barcode-test.php", "event-category-test.php", "event-link-test.php", "event-test.php",
								"profile-test.php", "ticket-test.php", "transaction-test.php", "user-test.php", "venue-test.php");

		// run them forward
		foreach($testFiles as $testFile) {
			$this->addFile($testFile);
		}

		// run them backward
		$testFiles = array_reverse($testFiles, false);
		foreach($testFiles as $testFile) {
			$this->addFile($testFile);
		}

		// run them randomly
		shuffle($testFiles);
		foreach($testFiles as $testFile) {
			$this->addFile($testFile);
		}
	}
}