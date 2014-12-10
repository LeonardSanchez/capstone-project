// validate the form using jQuery
$(document).ready(function() {
	// set up the form validation
	$("#signupForm").validate({
		// debug option in jQuery's validator
		debug: true,
		// rules that dictate whats (in)valid
		rules: {
			firstName      : {
				required: true
			},
			lastName       : {
				required: true
			},
			dateOfBirth    : {
				required: true
			},
			gender         : {
				required : true,
				maxlength: 1
			},
			email          : {
				required: true,
				email   : true
			},
			password       : {
				required : true,
				password : true,
				minlength: 8
			},
			confirmPassword: {
				required: true,
				equalTo : "#password"
			}
		},
			// messages that are displayed to the user
			messages: {
				firstName      : "Please enter your first name in the field",
				lastName       : "Please enter your last name in the field",
				dateOfBirth    : "Please enter a valid date of birth",
				gender         : "Please enter a single character gender",
				email          : "Please enter a valid email",
				password       : "Please enter a valid password",
				confirmPassword: {
					// confirmPassword was empty
					required: "Please confirm the password",
					minlength: "Your password must be at least 8 characters",
					// passwords did not match
					equalTo : "Passwords did not match"
				}
			},
			submitHandler  : function(form) {
				$(form).ajaxSubmit({
					type   : "POST",
					url    : "../form-processors/signup-form-processor.php",
					data   : $(form).serialize(),
					success: function(ajaxOutput) {
						$("#outputSignUp").html(ajaxOutput);

						if($(".alert-success").length >= 1) {
							$(form).reset();
						}
					}
				});
			}
		});
});

	/* verifies if the passwords match
	 * input: n/a
	 * output: (boolean) true if they matched, false if not */
	function verifyPasswords() {
		var firstPassword = document.getElementById("password").value;
		var secondPassword = document.getElementById("confirmPassword").value;
		// see if they match and blame the user!
		if(firstPassword != secondPassword) {
			alert("Passwords do not match");
			return(false);
		}
		else {
			return(true);
		}
}