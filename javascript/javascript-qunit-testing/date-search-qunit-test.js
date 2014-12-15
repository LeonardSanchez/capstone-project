// open a new window with the form
module("tabs", {
	setup: function() {
		F.open("../../date-search.php");
	}
});
// global variables for form values
var VALID_EVENTCATEGORY   = "Music";
var VALID_VENUENAME       = "Tingley Colliseum";
var VALID_EVENTDATETIME   = "12152015";
var VALID_TICKETPRICE     = "$25.00";


// define a function to perform the actual unit tests
function testValidFields() {
	// fill in the form values
	F("#eventCategory").visible(function() {
		this.type(VALID_EVENTCATEGORY);
	});
	F("#venueName").visible(function() {
		this.type(VALID_VENUENAME);
	});
	F("#eventDatetime").visible(function() {
		this.type(VALID_EVENTDATETIME);
	});
	F("#ticketPrice").visible(function() {
		this.type(VALID_TICKETPRICE);
	});
	// click the button once all the fields are filled in
	F("dateSearchSubmit").visible(function() {
		this.click();
	});
	// we want to assert that the form worked, and here we
	// assert we got the success message from the AJAX call
	F(".alert").visible(function() {
		// the ok() function from qunit is equivalent to simpleTest's assertTrue()
		ok(F(this).hasClass("alert-success"), "successful alert.CSS");
		ok(F(this).html().indexOf("Updated Successful") >= 0, "successful message");
	});
}
// the test function *MUST* be called for the test to work
test("test valid fields", testValidFields);


