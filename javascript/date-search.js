// validate the form using jquery
$(document).ready(function()	{

	// setup form validation
	$("#dateSearchForm").validate({

		// rules that are dictated
		rules:	{
			startDate:	{
				required:	true
			},
			endDate:		{
				required:	true
			}
		},

		messages:	{
			event: "Please enter an Event to search by"
		},

		submitHandler: function(form)	{
			$(form).ajaxSubmit	({
				type: "GET",
				url: "../form-processors/date-search-form-processor.php",
				date: $(form).serialize(),
				success:	function(ajaxOutput)	{
					$("#outputDateSearch").html(ajaxOutput);
				}
			})
		}
	});
});