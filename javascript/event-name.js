// validate the form using jquery
$(document).ready(function()	{

	// setup form validation
	$("#eventNameSearchForm").validate({
		// debug option in validate
		debug: true,

		// rules that are dictated
		rules:	{
			eventName:	{
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
				url: "../php/form-processors/event-name-search.php",
				date: $(form).serialize(),
				success:	function(ajaxOutput)	{
					document.getElementById("")
				}
			})
		}
	});
});

