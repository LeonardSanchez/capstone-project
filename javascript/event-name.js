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
				url: "php/form-processors/event-name-search-form-processor.php",
				success:	function(ajaxOutput)	{
					$("#rowArea").html(ajaxOutput);
				}
			})
		}
	});
});