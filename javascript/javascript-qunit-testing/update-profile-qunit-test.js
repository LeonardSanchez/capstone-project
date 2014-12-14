// open a new window with the form
module("tabs", {
	setup: function() {
		F.open("../../update-profile.php");
	}
});
// global variables for form values
var VALID_FIRSTNAME   = "Michael";
var VALID_LASTNAME    = "Jackson";
var VALID_DATEOFBIRTH = "06/06/1966";
var VALID_GENDER      = "M";
var VALID_EMAIL		 = "MichaelJ@Yahoo.com";
var VALID_PASSWORD    = "Neverlandranchismine477";
var CONFIRM_VALID_PASSWORD  = "Neverlandismine477";
// define a function to perform the actual unit tests
function testValidFields() {
	// fill in the form values
	F("#updateFirstName").visible(function() {
		this.type(VALID_FIRSTNAME);
	});
	F("#updateLastName").visible(function() {
		this.type(VALID_LASTNAME);
	});
	F("#updateDateOfBirth").visible(function() {
		this.type(VALID_DATEOFBIRTH);
	});
	F("#updateGender").visible(function() {
		this.type(VALID_GENDER);
	});
	F("#updateEmail").visible(function() {
		this.type(VALID_EMAIL);
	});
	F("#updatePassword").visible(function() {
		this.type(VALID_PASSWORD);
	});
	F("#confirmUpdatedPassword").visible(function() {
		this.type(VALID_PASSWORD);
	});
	// click the button once all the fields are filled in
	F("editProfileSubmit").visible(function() {
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




