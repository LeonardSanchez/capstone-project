
// validate the form using jquery
$(document).ready(function()	{
	// setup form validation
	$("#parentCategory").change({
		$("#getSubcategory").
		// rules that are dictated
		//rules:	{
		//	parentCategory:	{
		//		//required: true
		//	}
		//},
		//
		//messages:	{
		//	parentCategory: "Please select"
		//},

		submitHandler: function(form)	{
			$(form).ajaxSubmit	({
				type: "GET",
				url: "https://bootcamp-coders.cnm.edu/~ssandoval/capstone-project/php/form-processors/get-subcategories.php",
				success:	function(ajaxOutput)	{
					$("#subcategory").html(ajaxOutput).prop("disabled", false);

				}
			})
		}
	});
});