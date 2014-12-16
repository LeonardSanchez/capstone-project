// open a new window
module("tabs", {
	setup: function() {
		F.open("../../php/forms/contact-us.php");
	}
});

// global variables for form values

var VALID_NAME       = "Brendan";
var VALID_EMAIL      = "bslevin87@gmail.com";
var VALID_MESSAGE    = "Hello RG Events";

// define a function to perform the actual unit tests
function testValidFields() {
	// fill in the form values

   F("#name").visible(function() {
      this.type(VALID_NAME)
   });
	F("#email").visible(function() {
		this.type(VALID_EMAIL);
	});
	F("#message").visible(function() {
		this.type(VALID_MESSAGE);
	});

		// click the button once all the fields are filled in
		F("#contactUs").visible(function() {
			this.click();
		});

		// Contact Success! We assert contact with the success message from the AJAX call
		F(".alert").visible(function() {
			// the ok() function from qunit is equivalent to SimpleTest's assertTrue()
			ok(F(this).hasClass("alert-success"), "successful alert CSS");
			ok(F(this).html().indexOf("Contact Successful! Check Your Email") >= 0, "successful message");
		});
	}

// the test function *MUST* be called in order for the test to execute
	test("test valid fields", testValidFields);

