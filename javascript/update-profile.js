// validate the form using jQuery
$(document).ready(function() {
			// set up the form validation
			$("#updateProfile").validate({

				// rules that dictate whats (in)valid
				rules: {

					gender: {
									maxlength: 1
					},
					email: {
									 email: true
					},
					currentPassword: {
						password: true
					},
					newPassword: {

									 password: true
					},
					confirmPassword: {

									 equalTo: "newPassword"
					},
					// messages that are displayed to the user
					messages: {
						gender         : "Please enter a single character gender",
						email          : "Please enter a valid email",
						currentPassword: "Please enter your current password",
						newPassword: {
							password: "Please enter a valid password",
							minlength: "Your password must be at least 8 characters"
						},
						confirmPassword: {
							minlength: "Your password must be at least 8 characters",
							// passwords did not match
							equalTo : "Passwords did not match"
						}
					},
					submitHandler: function(form) {
							$(form).ajaxSubmit({
									 type: "POST",
									 url: "../form-processors/update-profile-form-processor.php",
									 data: $(form).serialize(),
									 success: function(ajaxOutput) {
										 		$("#outputProfileUpdate").html(ajaxOutput);

										 		if($(".alert-success").length >=1) {
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
	function verifyPasswords()
	{
			var firstPassword = document.getElementById("password").value;
			var secondPassword = document.getElementById("confirmPassword").value;
			// see if they match and blame the user!
			if(firstPassword != secondPassword)
			{
				alert("Passwords do not match");
				return(false);
			}
			else
			{
				return(true);
			}
	}
})