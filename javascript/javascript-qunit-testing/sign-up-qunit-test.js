// open a new window
module("tabs", {
	setup: function() {
		F.open("../../sign-up.php");
	}
});

// global variables for form values
var VALID_FIRSTNAME   = "Homer";
var VALID_LASTNAME    = "Simpson";
var VALID_DATEOFBIRTH = "11/11/2011";
var VALID_GENDER      = "M";
var VALID_EMAIL       = "homer@cnm.edu";
var VALID_PASSWORD    = "margeisgood123";
var CONFIRM_VALID_PASSWORD  = "margeisgood123";

// define a function to perform the actual unit tests
function testValidFields() {
	// fill in the form values
	F("#firstName").visible(function() {
		this.type(VALID_FIRSTNAME);
	});
	F("#lastName").visible(function() {
		this.type(VALID_LASTNAME);
	});
	F("#dateOfBirth").visible(function() {
		this.type(VALID_DATEOFBIRTH);
	});
	F("#gender").visible(function() {
		this.type(VALID_GENDER);
	});
	F("#email").visible(function() {
		this.type(VALID_EMAIL);
	});
	F("#password").visible(function() {
		this.type(VALID_PASSWORD);
	});
	F("confirmValidPassword").visible(function(){
		this.type(VALID_PASSWORD);

		// click the button once all the fields are filled in
		F("#profileSubmit").visible(function() {
			this.click();
		});

		// in forms, we want to assert the form worked as expected
		// here, we assert we got the success message from the AJAX call
		F(".alert").visible(function() {
			// the ok() function from qunit is equivalent to SimpleTest's assertTrue()
			ok(F(this).hasClass("alert-success"), "successful alert CSS");
			ok(F(this).html().indexOf("Updated Successful") >= 0, "successful message");
		});
	})

// the test function *MUST* be called in order for the test to execute
	test("test valid fields", testValidFields);}

