// open a new window with the form
module("tabs", {
	setup: function() {
		F.open("../../city-search.php");
	}
});
// global variables for form values
var VALID_VENUEADDRESS1    = "301 Central Ave Ne. Albuquerque, NM 87102";
var VALID_VENUEADDRESS2    = "123 Elm st.Albuquerque, NM 87110";
var VALID_VENUECITY        = "Albuquerque";
var VALID_VENUEPHONE       = "505 867-5309";
var VALID_VENUEWEBSITE     = "www.kimotheatre.com"

// define a function to perform the actual unit tests
function testValidFields() {
	// fill in the form values
	F("#venueAddress1").visible(function() {
		this.type(VALID_VENUEADDRESS1);
	});
	F("#venueAddress2").visible(function() {
		this.type(VALID_VENUEADDRESS2);
	});
	F("venueCity").visible(function() {
		this.type(VALID_VENUECITY);
	});
	F("#venuePhone").visible(function() {
		this.type(VALID_VENUEPHONE);
	});
	F("#venueWebsite").visible(function() {
		this.type(VALID_VENUEWEBSITE);
	}
	// click the button once all the fields are filled in
	F("citySearchSubmit").visible(function() {
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

