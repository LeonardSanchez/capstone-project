<?php
session_start();
?>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<!-- create and add a favicon for our site <link rel="icon" href="#"> -->
	<title>Red or Green Events Main Page</title>
	<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="../../dist/js/bootstrap.min.js"></script>
	<script src="../../assets/js/docs.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="dashboard.css" rel="stylesheet">

	<script src="../../assets/js/ie-emulation-modes-warning.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Red or Green Events</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="php/forms/login-form.php">Login</a></li>
				<li><a href="php/forms/signup-form.php">Sign Up</a></li>
				<li><a href="php/forms/shopping-cart-form.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></a></li>
			</ul>
			<form class="navbar-form navbar-right">
				<input type="text" class="form-control" placeholder="Search By City...">
			</form>
			<form class="navbar-form navbar-right">
				<input type="text" class="form-control" placeholder="Search Venues...">
			</form>
			<form class="navbar-form navbar-right">
				<input type="text" class="form-control" placeholder="Search Events...">
			</form>
		</div>
	</div>
</nav>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
				<li><a href="#">Reports</a></li>
				<li><a href="#">Analytics</a></li>
				<li><a href="#">Export</a></li>
			</ul>
			<ul class="nav nav-sidebar">
				<li><a href="">Nav item</a></li>
				<li><a href="">Nav item again</a></li>
				<li><a href="">One more nav</a></li>
				<li><a href="">Another nav item</a></li>
				<li><a href="">More navigation</a></li>
			</ul>
			<ul class="nav nav-sidebar">
				<li><a href="">Nav item again</a></li>
				<li><a href="">One more nav</a></li>
				<li><a href="">Another nav item</a></li>
			</ul>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Dashboard</h1>

			<div class="row placeholders">
				<div class="col-xs-6 col-sm-3 placeholder">
					<img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail">
					<h4>Label</h4>
					<span class="text-muted">Something else</span>
				</div>
				<div class="col-xs-6 col-sm-3 placeholder">
					<img data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail">
					<h4>Label</h4>
					<span class="text-muted">Something else</span>
				</div>
				<div class="col-xs-6 col-sm-3 placeholder">
					<img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail">
					<h4>Label</h4>
					<span class="text-muted">Something else</span>
				</div>
				<div class="col-xs-6 col-sm-3 placeholder">
					<img data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail">
					<h4>Label</h4>
					<span class="text-muted">Something else</span>
				</div>
			</div>

			<h2 class="sub-header">Section title</h2>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>#</th>
						<th>Header</th>
						<th>Header</th>
						<th>Header</th>
						<th>Header</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>1,001</td>
						<td>Lorem</td>
						<td>ipsum</td>
						<td>dolor</td>
						<td>sit</td>
					</tr>
					<tr>
						<td>1,002</td>
						<td>amet</td>
						<td>consectetur</td>
						<td>adipiscing</td>
						<td>elit</td>
					</tr>
					<tr>
						<td>1,003</td>
						<td>Integer</td>
						<td>nec</td>
						<td>odio</td>
						<td>Praesent</td>
					</tr>
					<tr>
						<td>1,003</td>
						<td>libero</td>
						<td>Sed</td>
						<td>cursus</td>
						<td>ante</td>
					</tr>
					<tr>
						<td>1,004</td>
						<td>dapibus</td>
						<td>diam</td>
						<td>Sed</td>
						<td>nisi</td>
					</tr>
					<tr>
						<td>1,005</td>
						<td>Nulla</td>
						<td>quis</td>
						<td>sem</td>
						<td>at</td>
					</tr>
					<tr>
						<td>1,006</td>
						<td>nibh</td>
						<td>elementum</td>
						<td>imperdiet</td>
						<td>Duis</td>
					</tr>
					<tr>
						<td>1,007</td>
						<td>sagittis</td>
						<td>ipsum</td>
						<td>Praesent</td>
						<td>mauris</td>
					</tr>
					<tr>
						<td>1,008</td>
						<td>Fusce</td>
						<td>nec</td>
						<td>tellus</td>
						<td>sed</td>
					</tr>
					<tr>
						<td>1,009</td>
						<td>augue</td>
						<td>semper</td>
						<td>porta</td>
						<td>Mauris</td>
					</tr>
					<tr>
						<td>1,010</td>
						<td>massa</td>
						<td>Vestibulum</td>
						<td>lacinia</td>
						<td>arcu</td>
					</tr>
					<tr>
						<td>1,011</td>
						<td>eget</td>
						<td>nulla</td>
						<td>Class</td>
						<td>aptent</td>
					</tr>
					<tr>
						<td>1,012</td>
						<td>taciti</td>
						<td>sociosqu</td>
						<td>ad</td>
						<td>litora</td>
					</tr>
					<tr>
						<td>1,013</td>
						<td>torquent</td>
						<td>per</td>
						<td>conubia</td>
						<td>nostra</td>
					</tr>
					<tr>
						<td>1,014</td>
						<td>per</td>
						<td>inceptos</td>
						<td>himenaeos</td>
						<td>Curabitur</td>
					</tr>
					<tr>
						<td>1,015</td>
						<td>sodales</td>
						<td>ligula</td>
						<td>in</td>
						<td>libero</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap core JavaScript
 ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
<script src="../../assets/js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
?>