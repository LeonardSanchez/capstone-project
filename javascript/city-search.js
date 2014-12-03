// validate the form using jQuery
$(document).ready(function() {

	// setup the form validation
	$("citySearchForm").validate({
		// debug option in jQuery's validator
		debug: true,
		// rules that dictate what is (in)valid
		rules: {
			city: {

			pattern: /^[^";@#\$&\*]+$/
			}
			},

		messages: {
			city: {
				pattern: "Illegal characters detected",
				required: "Please enter a city"
			}
		},

		submitHandler: function(form) {
			$(form).ajaxSubmit ({
				type: "GET",
				url: "city-search.php",
				success: function(ajaxOutput) {
					$("outputArea").html(ajaxOutput);
				}
			});
		}
	})
});

