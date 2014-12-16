// open a new window
module("tabs", {
	setup: function() {
		F.open("../../php/forms/login-form.php");
	}
});

// global variables for form values
var VALID_EMAIL       = "bslevin87@gmail.com";
var VALID_PASSWORD    = "margeisgood123";

// define a function to perform the actual unit tests
function testValidFields() {
	// fill in the form values
	F("#email").visible(function() {
		this.type(VALID_EMAIL);
	});
	F("#password").visible(function() {
		this.type(VALID_PASSWORD);
		});

		// click the button once all the fields are filled in
		F("#loginSubmit").visible(function() {
			this.click();
		});

		// in forms, we want to assert the form worked as expected
		// here, we assert we got the success message from the AJAX call
		F(".alert").visible(function() {
			// the ok() function from qunit is equivalent to SimpleTest's assertTrue()
			ok(F(this).hasClass("alert-success"), "successful alert CSS");
			ok(F(this).html().indexOf("Updated Successful") >= 0, "successful message");
		});

}
// the test function *MUST* be called in order for the test to execute
	test("test valid fields", testValidFields);
