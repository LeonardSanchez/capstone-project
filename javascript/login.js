// validate the form using jQuery
$(document).ready(function() {
	// set up the form validation
	$("#login").validate({
		// debug option in jQuery's validator
		debug: true,
		// rules that dictate whats (in)valid
		rules: {
			email          : {
				required: true,
				email   : true
			},
			password       : {
				required: true,
				password: true
			},

			// messages that are displayed to the user
			messages       : {
				email          : "Please enter a valid email",
				password       : "Please enter a valid password"

			},
			submitHandler  : function(form) {
				$(form).ajaxSubmit({
					type   : "POST",
					url    : "login.php",
					data   : $(form).serialize(),
					success: function(ajaxOutput) {
						$("outputArea").css("display", "");
						$("outputArea").html(ajaxOutput);

						if($(".alert-success").length >= 1) {
							$(form).reset();
						}
					}
				});
			}


		}
	})
})