// validate the form using jQuery
$(document).ready(function() {
			// set up the form validation
			$("#editProfile").validate({
				// debug option in jQuery's validator
				debug: true,
				// rules that dictate whats (in)valid
				rules: {
					changeFirstName: {
									 required: true,
									 changeFirstName: true
					},
					changeLastName: {
									 required: true,
									 changeLastName: true
					},
					changeDateOfBirth: {
						          required: true,
						          changeDateOfBirth: true
					},
					changeGender: {
						          required: true,
									 changeGender: true
					},
					changeEmail: {
									 required: true,
									 changeEmail: true
					},
					changePassword: {
									 required: true,
									 changePassword: true
					},
					confirmPassword: {
						  	  	    required: true,
									 equalTo: "changePassword"
					},
					// messages that are displayed to the user
					messages: {
								changeFirstName:      "Please enter a valid name in the field",
								changeLastName:       "Please enter a valid name in the field",
								changeDateOfBirth:    "Please enter a valid date of birth",
								changeGender:         "Please enter a valid gender",
								changeEmail:          "Please enter a valid email",
								changePassword:       "Please enter a valid password",
								confirmPassword: {
												// confirmPassword was empty
												required: "Please confirm the password",
												// passwords did not match
												equalTo:  "Passwords did not match"
								}
					},
					submitHandler: function(form) {
							$(form).ajaxSubmit({
									 type: "POST",
									 url: "edit-profile.php",
									 data: $(form).serialize(),
									 success: function(ajaxOutput) {
										 		$("outputArea").css("display","");
										 		$("outputArea").html(ajaxOutput);

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