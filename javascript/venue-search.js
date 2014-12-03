// validate the form using jQuery
$(document).ready(function()
{
	// setup the form validation
	$("#venueSearchForm").validate({
		// debug option in jQuery's validator
		debug: true,
		// rules dictate what is (in)valid
		rules: {
			venue: {
				required: true,
				venue: true
			}
		},

		// messages are what are displayed to the user
		messages: {
			venue: "Please enter a Venue to search by"
			},

		submitHandler: function(form)
		{
			$(form).ajaxSubmit ({
					type: "GET",
					url: "venue-search-form.php",
					data: $(form).serialize(),
					success: function(ajaxOutput) {
						$("#outputArea").html(ajaxOutput);
					}
				});
		}
	})
});