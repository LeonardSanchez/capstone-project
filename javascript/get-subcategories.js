$(document).ready(function(){
$("#parentCategory").change(function()	{
	var parentCategory = document.getElementById("parentCategory").value;
		// setup form validation
		$("#parentCategory").validate({

			// rules that are dictated
			rules:	{
				parentCategory:	{
					required: true
				}
			},

			messages:	{
				parentCategory: "Please select "
			},

			submitHandler: function(form)	{
				$("#parentCategory").ajaxSubmit	({
					type: "GET",
					url: "../form-processors/get-subcategories.php",
					success:	function(ajaxOutput)	{

						$("#subcategoryArea").replace(ajaxOutput);
						$("#subcategory").prop("disabled", false);
					}
				})
			}
		});

	});
	});