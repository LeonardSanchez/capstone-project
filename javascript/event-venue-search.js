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
					$("#rowArea").html(ajaxOutput);
				}
			})
		}
	});
});
