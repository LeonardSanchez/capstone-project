// validate the form using jQuery
$(document).ready(function() {
	// set up the form validation
	$("#contactForm").validate({

		// rules that dictate what is (in)valid
		rules: {
			name:  {
				required: true
			},
			email: {
				required: true,
				email   : true
			},
			message: {
				required: true,
				maxlength: 512
			}
		},

		// messages that are displayed to the user
		messages: {
			name: "Please enter your name",
			email: "Please enter a valid email",
			message: {
				required: "Please enter a message to send",
				maxlength: "Maximum of 500 characters allowed in message"
			}
		},

		submitHandler  : function(form) {
			$(form).ajaxSubmit({
				type   : "POST",
				url    : "../form-processors/contact-us-form-processor.php",
				data: $(form).serialize(),
				success: function(ajaxOutput) {
					$("#outputContactUs").html(ajaxOutput);

					if($(".alert-success").length >= 1)
					{
						$(form).reset();
					}
				}
			});
		}
	});
});