// validate the form using jquery
$(document).ready(function()	{

	// setup form validation
	$("#venueSearchForm").validate({

		rules: {
			venue: {
				required: true,
				pattern: /^[^";@#\$&\*]+$/
			}
		},

		// messages are what are displayed to the user
		messages: {
			venue: {
				required: "Please enter a Venue to search by",
				pattern: "Illegal characters detected. Please re-enter a valid VenueName."
			}
		},

		submitHandler: function(form)	{
			$(form).ajaxSubmit	({
				type: "GET",
				url: "php/form-processors/event-venue-search.php",
				success:	function(ajaxOutput)	{
					var resultHeader = "<br><br><br><h3><span style=\"color: #C53337\">Search</span> <span style=\"color: green\">Results</span></h3><div><table class=\"table table-striped\"><thead><tr><th>Event Name</th><th>Event Category</th><th>Venue</th><th>Date & Time</th><th>Ticket Price</th><th>Buy Tickets</th></tr></thead><tbody id=\"rowArea\">";
					var resultFooter = "</tbody> </table>";
					$("#indexContent").html(resultHeader+ajaxOutput+resultFooter);
				}
			})
		}
	});
});
