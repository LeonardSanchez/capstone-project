// validate the form using jQuery
$(document).ready(function(){

	// setup the form validation
	$("#addToCartForm").validate({

		// rules dictate what is (in)valid
		rules: {
			qty: {
				required: true,
				range: [1,10]
			}
		},

		messages: {
			qty: {
				required: "Please enter a ticket qty",
				range: "You must select a qty of 1-10 tickets"
			}
		},

		submitHandler: function(form)
		{
			$(form).ajaxSubmit({
				type: "GET",
				url: "../php/form-processor/add-to-cart-form-processor.php",
				date: $(form).serialize(),
				success: function(ajaxoutput) {
					var eventId = document.getElementById('eventId').value;
					$("#outputDateSearch"+eventId).html(ajaxoutput);
				}
			});
		}
	});

});