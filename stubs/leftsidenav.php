

			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-7 col-md-3" style="background-color: ActiveBorder">
						<br>
						<br>
						<ul class="nav nav-sidebar" id="leftnav1">
							<br>
							<br>
							<div class="panel panel-success">
								<div class="panel-heading" style="background-color: #C53337">
									<h3 class="panel-title" style="color: #ffffff">Find Local Events</h3>
								</div>
							</div>

							<article>
								<h5><strong>Search By Event Date</strong></h5>
								<form id="dateSearchForm" method="get" action="php/form-processors/date-search-form-processor.php">
									<label for="startDate" class="sr-only"></label>
									<input type="text" id="startDate" name="startDate" class="form-control" placeholder="Start Date: mm-dd-yyyy"/><br/>
									<label for="endDate" class="sr-only"></label>
									<input type="text" id="endDate" name="endDate" class="form-control" placeholder="End Date: mm-dd-yyyy"><br/>
									<button id="search" class="btn btn-rgevents" type="submit">Search</button>
								</form>
								<p id="outputDateSearch"></p>
							</article>

							<!--							<aside>-->
							<!--								<h5><strong>Search By Event Category</strong></h5>-->
							<!--								<form id="eventCatSearchForm" name="catSubCat" method="post" action="php/form-processors/event-category-search-form-processor.php">-->
							<!--									--><?php //echo generateInputTags(); ?>
							<!--									<label for="eventCatSearch" class="sr-only"></label>-->
							<!--									<p>Choose Category</p>-->
							<!--									<select class="form-control" name="cat" id="s1" onchange=AjaxFunction()>-->
							<!--										<option value=''>Select One</option>"-->
							<!--										<option>--><?php //getCategory() ?><!--</option>-->
							<!--									</select>-->
							<!--									<div class="search">-->
							<!--										<button id="search" class="btn btn-rgevents" type="submit">Search</button>-->
							<!--									</div>-->
							<!--								</form>-->
							<!--							</aside>-->
						</ul>
						<br>
						<ul class="nav nav-sidebar">
							<li>
								<a id="contactbutton" class="btn btn-contact" href="php/forms/contact-form.php">Contact Us</a>
							</li>

						</ul>
					</div>