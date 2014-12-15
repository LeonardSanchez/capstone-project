// open a new window with the form
module("tabs", {
	setup: function() {
		F.open("../../event-category-search.php");
	}
});
// global variables for form values
var VALID_EVENTCATEGORYBYALLPARENTEVENTS = "music";

// define a function to perform the actual unit tests
function testValidFields() {
	// fill in the form values
	F("eventCategoryByAllParentEvents").visible(function() {
		this.type(VALID_EVENTCATEGORYBYALLPARENTEVENTS);
	});
	// click the button once all the fields are filled in
	F("eventCategorySearchSubmit").visible(function() {
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



