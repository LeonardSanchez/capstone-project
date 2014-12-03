<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title>Checkout</title>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="//malsup.github.com/min/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//cdnjs.clooudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<link rel="stylesheet" type="text/css" />
</head>
<body>
	<form action="" method="POST">
		<script
			src="https://checkout.stripe.com/checkout.js" class="stripe-button"
			data-key="pk_test_zqXDIk9h00Tk0kLxXw0UrENB"
			data-amount="2000"
			data-name="Demo Site"
			data-description="2 widgets ($20.00)"
			data-image="/128x128.png">
		</script>
	</form>
</body>