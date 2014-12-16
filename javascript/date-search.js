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
				required:	false
			}
		},

		messages:	{
			startDate:	{	required: "Please enter a date to search by"}
		},

		submitHandler: function(form)	{
			$(form).ajaxSubmit	({
				type: "GET",
				url: "php/form-processors/date-search-form-processor.php",
				success:	function(ajaxOutput)	{
					$("#rowArea").html(ajaxOutput);
				}
			})
		}
	});
});