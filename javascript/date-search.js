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
				url: "../form-processors/date-search-form-processor.php",
				date: $(form).serialize(),
				success:	function(ajaxOutput)	{
					//$("#rowArea").html(ajaxOutput);
					window.location.href = "../../search-results.php";
					document.getElementById("rowArea").innerHTML = $(ajaxOutput);
				}
			})
		}
	});
});