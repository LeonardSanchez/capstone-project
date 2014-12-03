// validate the form using jquery
$(document).ready(function()	{

	// setup form validation
	$("#eventName").validate({
		// debug option in validate
		debug: true,

		// rules that are dictated
		rules:	{
			event:	{
				required: true,
				event: true
			}
		},

		messages:	{
			event: "Please enter an event to search by"
		},

		submitHandler: function(form)	{
			$(form).ajaxSubmit	({
				type: "GET",
				url: "event-name-search.php",
				date: $(form).serialize(),
				success:	function(ajaxOutput)	{
					$("#outputArea").html(ajaxOutput);
				}
			})
		}
	});
});