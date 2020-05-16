	<!-- BEGIN FOOTER -->
	<div class="footer">
		<?php echo date("Y", time()); ?> &copy; E-mall shopping center.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
    
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="assets/plugins/ckeditor/ckeditor.js"></script>		
	<script src="assets/plugins/breakpoints/breakpoints.js"></script>			
	<script src="assets/plugins/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <!-- This script loads States while a country is selected, Using AJAX -->
    <script src="assets/js/load_states.js"></script>
    <!-- This script is to check files and display errors -->
	<script src="js/checkmultiple.js" type="text/javascript"></script>
    <!-- This script is used for file upload -->
    <script type="text/javascript" src="assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
    <!-- This script is used for full callender page -->
	<!--<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>-->	
	<script type="text/javascript" src="assets/plugins/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
    <script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
    <!-- This script is used for datepicker on the form field -->
    <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/date.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->
    <!-- This script is for Editable Tables -->
	<script type="text/javascript" src="assets/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/plugins/data-tables/DT_bootstrap.js"></script>
    <!-- End of Editable Tables Scripts -->
    <!-- This script is for Form Validation -->
    <script type="text/javascript" src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
   	<script type="text/javascript" src="assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
    <!-- End of Form validation Scripts -->
	<script src="assets/js/app.js"></script>
    <script>
		jQuery(document).ready(function() {	
			
			setInterval(load_orders, 1000);
			setInterval(load_paypal_orders, 1000);
			setInterval(count_customers, 1000);
			setInterval(count_orders, 1000);
			setInterval(count_categories, 1000);
			setInterval(count_brands, 1000);
			setInterval(notifications, 1000);
			setInterval(product_review, 1000);
			function load_orders() {
				$.ajax({ // create an ajax request to load_orders.php
					type: "GET",
					url: "ajax/load_paypal_orders.php",
					dataType: "html", // expect html to be returned
					success: function(response) {
						$("#load_paypal_orders").html(response);
						//alert(response);	
					}
				});	
			}
			
			function load_paypal_orders() {
				$.ajax({ // create an ajax request to load_orders.php
					type: "GET",
					url: "ajax/load_orders.php",
					dataType: "html", // expect html to be returned
					success: function(response) {
						$("#load_orders").html(response);
						//alert(response);	
					}
				});	
			}
			
			function count_customers() {
				$.ajax({ // create an ajax request to load_orders.php
					type: "GET",
					url: "ajax/count_customers.php",
					dataType: "html", // expect html to be returned
					success: function(response) {
						$("#count_customers").html(response);
						//alert(response);	
					}
				});	
			}
			
			function count_orders() {
				$.ajax({ // create an ajax request to load_orders.php
					type: "GET",
					url: "ajax/count_orders.php",
					dataType: "html", // expect html to be returned
					success: function(response) {
						$("#count_orders").html(response);
						//alert(response);	
					}
				});	
			}
			
			function count_categories() {
				$.ajax({ // create an ajax request to load_orders.php
					type: "GET",
					url: "ajax/count_categories.php",
					dataType: "html", // expect html to be returned
					success: function(response) {
						$("#count_categories").html(response);
						//alert(response);	
					}
				});	
			}
			
			function count_brands() {
				$.ajax({ // create an ajax request to load_orders.php
					type: "GET",
					url: "ajax/count_brands.php",
					dataType: "html", // expect html to be returned
					success: function(response) {
						$("#count_brands").html(response);
						//alert(response);	
					}
				});	
			}
			
			function notifications() {
				$.ajax({ // create an ajax request to load_orders.php
					type: "GET",
					url: "ajax/notifications.php",
					dataType: "html", // expect html to be returned
					success: function(response) {
						$("#header_notification_bar").html(response);
						//alert(response);	
					}
				});	
			}
			
			function product_review() {
				$.ajax({ // create an ajax request to load_orders.php
					type: "GET",
					url: "ajax/product_review.php",
					dataType: "html", // expect html to be returned
					success: function(response) {
						$("#header_inbox_bar").html(response);
						//alert(response);	
					}
				});	
			}
			
			
		});
	</script>
    <script type="text/javascript">
		var field = document.getElementById('filename');
		field.addEventListener('change', countFiles, false);
		
		function countFiles(e) {
			if (this.files != undefined) {
				var elems = this.form.elements,
					submitButton,
					len = this.files.length, 
					max = document.getElementsByName('MAX_FILE_SIZE')[0].value,
					maxfiles = this.getAttribute('data-maxfiles'),
					maxpost = this.getAttribute('data-postmax'),
					displaymax = this.getAttribute('data-displaymax'),
					filesize,
					toobig = [],
					total = 0,
					message = '';
		
				for (var i = 0; i < elems.length; i++) {
					if (elems[i].type == 'submit') {
						submitButton = elems[i];
						break;
					}
				}
				
				for (i = 0; i < len; i++) {
					filesize = this.files[i].size;
					if (filesize > max) {
						toobig.push(this.files[i].name);
					}
					total += filesize;
				}
				if (toobig.length > 0) {
					message = 'The following file(s) are too big:\n'
							+ toobig.join('\n') + '\n\n';
				}
				if (total > maxpost) {
					message += 'The combined total exceeds ' + displaymax + '\n\n';
				}
				if (len > maxfiles) {
					message += 'You have selected more than ' + maxfiles + ' files';
				}
				if (message.length > 0) {
					submitButton.disabled = true;
					document.getElementById('submit').disabled = true;
					alert(message);
				} else {
					submitButton.disabled = false;
					document.getElementById('submit').disabled = false;
				}
			}
		}
	</script>
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			<?php if($page_name == 'index.php') { ?> App.setPage("index"); <?php } ?>
			<?php if($page_name == 'product_category.php') { ?> App.setPage("product_category"); <?php } ?>
			<?php if($page_name == 'product_sub_category.php') { ?> App.setPage("product_sub_category"); <?php } ?>
			<?php if($page_name == 'brand.php') { ?> App.setPage("brand"); <?php } ?>
			<?php if($page_name == 'shipping.php') { ?> App.setPage('shipment'); <?php } ?>
			<?php if($page_name == 'product.php') { ?> App.setPage('product'); <?php } ?>
			<?php if($page_name == 'product_list.php') { ?> App.setPage('product_list'); <?php } ?>
			<?php if($page_name == 'new_user.php') { ?> App.setPage('new_user'); <?php } ?>
			<?php if($page_name == 'shipping.php') { ?> App.setPage('shipping'); <?php } ?>
			<?php if($page_name == 'customer_list.php') { ?> App.setPage('customer_list'); <?php } ?>
			<?php if($page_name == 'orders.php') { ?> App.setPage('orders'); <?php } ?>
			<?php if($page_name == 'user_list.php') { ?> App.setPage('user_list'); <?php } ?>
			
			App.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>