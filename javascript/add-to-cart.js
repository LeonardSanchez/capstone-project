// validate the form using jQuery
$(document).ready(function(){

	// setup the form validation
	$("#addToCart").validate({

		// rules dictate what is (in)valid
		rules: {
			qty: {
				required: true,
				range: [1,10]
			}
		},

		messages: {
			qty: {
				required: "Please enter a ticket qty",
				range: "You must select a qty of 1-10 tickets"
			}
		},

		submitHandler: function(form)
		{
			$(form).ajaxSubmit({
				type: "POST",
				url: "../form-processors/event-name-search-form-processor.php",
				success: function(ajaxOutput) {
					$("#outputAddToCart").html(ajaxOutput);
				}
			});
		}
	});

});