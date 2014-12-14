// open a new window with the form
module("tabs", {
		setup: function() {
			F.open("../../add-to-cart.php");
		}
});
// global variables for form values
var VALID_EVENTID = "149";
var VALID_EVENTNAME = "A Christmas Carol";
var VALID_EVENTDATETIME = "12/09/2015";
var VALID_TICKETPRICE = "$25.00";
var VALID_QUANTITY = "5";
// define a function to perform the actual unit tests
function testValidFields() {
			// fill in the form values
			F("#eventId").visible(function() {
					this.type(VALID_EVENTID);
			});
			F("#eventName").visible(function() {
					this.type(VALID_EVENTNAME);
			});
			F("#eventDateTime").visible(function() {
					this.type(VALID_EVENTDATETIME);
			});
			F("#ticketPrice").visible(function() {
					this.type(VALID_TICKETPRICE);
			});
			F("#ticketQuanitiy").visible(function(){
					this.type(VALID_TICKETQUANTITY);
			});
			// click the button once all the fields are filled in
			F("addToCartSubmit").visible(function() {
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