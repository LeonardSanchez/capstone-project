// validate the form using jQuery
$(document).ready(function() {

	// setup the form validation
	$("#citySearchForm").validate({

		// rules that dictate what is (in)valid
		rules: {
			city: {
				pattern: /^[^";@#\$&\*]+$/,
				required: true
			}
			},

		messages: {
			city: {
				pattern: "Illegal characters detected. Please re-enter a valid City.",
				required: "Please enter a city"
			}
		},

		submitHandler: function(form) {
			$(form).ajaxSubmit ({
				type: "GET",
				url: "../form-processors/city-search-form-processor.php",
				success: function(ajaxOutput) {
					$("#outputCitySearch").html(ajaxOutput);
				}
			});
		}
	});
}) ;

