// validate the form using jQuery
$(document).ready(function() {
	// set up the form validation
	$("#loginForm").validate({

		// rules that dictate what is (in)valid
		rules: {
			email   : {
				required: true,
				email   : true
			},
			password: {
				required: true,
				password: true
			}
		},

		// messages that are displayed to the user
		messages: {
			email: "Please enter a valid email",
			password: "Please enter a valid password"
		},

		submitHandler  : function(form) {
			$(form).ajaxSubmit({
				type   : "POST",
				url    : "php/form-processors/login-form-processor.php",
				data: $(form).serialize(),
				success: function(ajaxOutput) {
					$("#outputLogin").html(ajaxOutput);
				}
			});
		}

	});
});