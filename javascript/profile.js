// validate the form using jQuery
$(document).ready(function() {
	// set up the form validation
	$("#profile").validate({
		// debug option in jQuery's validator
		debug: true,
		// rules that dictate whats (in)valid
		rules: {
			FirstName      : {
				required : true,
				FirstName: true
			},
			LastName       : {
				required: true,
				LastName: true
			},
			dateOfBirth    : {
				required   : true,
				dateOfBirth: true
			},
			gender         : {
				required: true,
				gender  : true
			},
			email          : {
				required: true,
				email   : true
			},
			password       : {
				required: true,
				password: true
			},
			confirmPassword: {
				required: true,
				equalTo : "password"
			},
			// messages that are displayed to the user
			messages       : {
				firstName      : "Please enter a valid name in the field",
				lastName       : "Please enter a valid name in the field",
				dateOfBirth    : "Please enter a valid date of birth",
				gender         : "Please enter a valid gender",
				email          : "Please enter a valid email",
				password       : "Please enter a valid password",
				confirmPassword:
				{
					// confirmPassword was empty
					required: "Please confirm the password",
					// passwords did not match
					equalTo : "Passwords did not match"
				}
			},
			submitHandler  : function(form) {
				$(form).ajaxSubmit({
					type   : "POST",
					url    : "profile.php",
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
			return (false);
		}
		else {
			return (true);
		}
	}
})