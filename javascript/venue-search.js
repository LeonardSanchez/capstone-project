// validate the form using jQuery
$(document).ready(function()
{
	// setup the form validation
	$("#venueSearchForm").validate({

		// rules dictate what is (in)valid
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

		submitHandler: function(form)
		{
			$(form).ajaxSubmit ({
					type: "GET",
					url: "../form-processors/venue-search-form-processor.php",
					success: function(ajaxOutput) {
						$("#outputVenueSearch").html(ajaxOutput);
					}
				});
		}
	});
});