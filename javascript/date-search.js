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
					var resultHeader = "<br><br><br><h3><span style=\"color: #C53337\">Search</span> <span style=\"color: green\">Results</span></h3><div><table class=\"table table-striped\"><thead><tr><th>Event Name</th><th>Event Category</th><th>Venue</th><th>Date & Time</th><th>Ticket Price</th><th>Buy Tickets</th></tr></thead><tbody id=\"rowArea\">";
					var resultFooter = "</tbody> </table>";
					$("#indexContent").html(resultHeader+ajaxOutput+resultFooter);
				}
			})
		}
	});
});