// validate the form using jquery
$(document).ready(function()	{

	// setup form validation
	$("#eventNameSearchForm").validate({

		// rules that are dictated
		rules:	{
			eventName:	{
				required: true
			}
		},

		messages:	{
			event: "Please enter an Event to search by"
		},

		submitHandler: function(form)	{
			$(form).ajaxSubmit	({
				type: "GET",
				url: "../form-processors/event-name-search-form-processor.php",
				date: $(form).serialize(),
				success:	function(ajaxOutput)	{
					$("#outputEventSearch").html(ajaxOutput);
				}
			})
		}
	});
});

