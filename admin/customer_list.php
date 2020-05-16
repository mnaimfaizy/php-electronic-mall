<?php include_once("includes/header.php"); ?>
<?php
	global $database;
?>
<script>
	function conf(id) {
		var value = window.confirm("Are you sure! You want to delete selected Item?");
		if(value == true) {
			window.location = "delete.php?ip_address="+id;
		} else { 
			// Do something else
		}
	}
	
	function paypal_delete(id) {
		var value = window.confirm("Are you sure! You want to delete selected Item?");
		if(value == true) {
			window.location = "delete.php?paypal_id="+id;
		} else { 
			// Do something else
		}
	}
</script>
<?php include_once("includes/top_navigation.php"); ?>

	<!-- BEGIN CONTAINER -->	
	<div class="page-container row-fluid">
		
    <?php include_once("includes/sidebar_menu.php"); ?>
        
		<!-- BEGIN PAGE -->
		<div class="page-content">
			
            <!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
                	<!-- BEGIN span12 -->
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
							<!-- BEGIN color-mode -->
                            <div class="color-mode">
								<p>THEME COLOR</p>
								<ul class="inline">
									<li class="color-black current color-default" data-style="default"></li>
									<li class="color-blue" data-style="blue"></li>
									<li class="color-brown" data-style="brown"></li>
									<li class="color-purple" data-style="purple"></li>
									<li class="color-white color-light" data-style="light"></li>
								</ul>
								<label class="hidden-phone">
								<input type="checkbox" class="header" checked value="" />
								<span class="color-mode-label">Fixed Header</span>
								</label>							
							</div>
                            <!-- END color-mode -->
						</div>
						<!-- END BEGIN STYLE CUSTOMIZER --> 
                        
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Customers List &nbsp;				<small> Here You can view information about customers.</small>
						</h3>
						<ul class="breadcrumb">
							<?php $breadcrumb = breadcrumb();
                                echo $breadcrumb; 
                            ?>
                        </ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
                    <!-- END span12 -->
				</div>
				<!-- END PAGE HEADER-->
            
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Register Customers Information</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="generate_pdf.php?page=customers" target="_blank">Save as PDF</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="register_customers">
									<thead>
										<tr>
											<th>No</th>
											<th>Customer Name</th>
                                            <th>E-mail</th>
                                            <th>Orders</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$sql = "SELECT customer_id, customer_name, email FROM customer ORDER BY customer_id DESC"; 
											$result = $database->query($sql);
											while($customer = $database->fetch_array($result)) {
										?>
                                        <tr class="">
											<td><?php echo $no++; ?></td>
											<td><?php echo $customer['customer_name'];?></td>
                                            <td><?php echo $customer['email'];?></td>
                                            <td>
											<?php $customer_id = $customer['customer_id'];
												$query = $database->query("SELECT COUNT(*) AS total FROM orders WHERE customer_id=$customer_id");
												$total = $database->fetch_array($query);
												echo $total['total'];
											?></td>
                                            
											<td>
                                            <button type="button" class="btn btn-danger btn-small" onClick="conf(this.id)" id="<?php echo $customer['customer_id']; ?>"> <i class="icon-trash"></i> </button></td>
										</tr>
                                        <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
            	<!-- END PAGE CONTENT -->
            
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Guest Customers Information</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="generate_pdf.php?page=guest" target="_blank">Save as PDF</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="guest_customers">
									<thead>
										<tr>
											<th>No</th>
											<th>Customer Name</th>
                                            <th>IP Address</th>
                                            <th>Payment Method</th>
                                            <th>Country</th>
                                            <th>Orders</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$sql = "SELECT order_id, customer_name, ip_address, payment_method FROM orders ORDER BY order_id DESC"; 
											$result = $database->query($sql);
											while($customer = $database->fetch_array($result)) {
										?>
                                        <tr class="">
											<td><?php echo $no++; ?></td>
											<td><?php echo $customer['customer_name'];?></td>
                                            <td><?php echo $customer['ip_address'];?></td>
                                            <td><?php echo $customer['payment_method'];?></td>
                                            <td><?php $ip_address = $customer['ip_address'];
											$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip_address));
											if($query && $query['status'] == 'success') {
												echo $query['country'];	
											} else {
												echo 'Localhost';
											} ?></td>
                                            <td>
											<?php $customer_id = $customer['ip_address'];
												$query = $database->query("SELECT COUNT(*) AS total FROM orders WHERE ip_address='$ip_address'");
												$total = $database->fetch_array($query);
												echo $total['total'];
											?></td>
                                            
											<td>
                                            <button type="button" class="btn btn-danger btn-small" onClick="conf(this.id)" id="<?php echo $customer['ip_address']; ?>"> <i class="icon-trash"></i> </button></td>
										</tr>
                                        <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
            	<!-- END PAGE CONTENT -->
            
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>PayPal Customers Information</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="generate_pdf.php?page=paypal_customers" target="_blank">Save as PDF</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="paypal_customers">
									<thead>
										<tr>
											<th>No</th> 
                                            <th>Customer Name</th>                                           
                                            <th>Date</th>
                                            <th>email</th>
                                            <th>IP Address</th>
                                            <th>Country</th>
                                            <th>Orders</th>
                                            <th>Total</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$sql = "SELECT paypal_id, first_name, last_name, payment_date, payer_email, ip_address, address_country, num_cart_items, mc_gross FROM paypal_checkout ORDER BY paypal_id DESC"; 
											$result = $database->query($sql);
											while($customer = $database->fetch_array($result)) {
										?>
                                        <tr class="">
											<td><?php echo $no++; ?></td>
											<td><?php echo $customer['first_name']." ".$customer['last_name'];?></td>
                                            <td><?php echo $customer['payment_date'];?></td>
                                            <td><?php echo $customer['payer_email'];?></td>
                                            <td><?php echo $customer['ip_address'];?></td>
                                            <td><?php echo $customer['address_country']; ?></td>
                                            <td><?php echo $customer['num_cart_items']; ?></td>
                                            <td><?php echo '$'.$customer['mc_gross']; ?></td>
											<td>
                                            <button type="button" class="btn btn-danger btn-small" onClick="paypal_delete(this.id)" id="<?php echo $customer['paypal_id']; ?>"> <i class="icon-trash"></i> </button></td>
										</tr>
                                        <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
            	<!-- END PAGE CONTENT -->
            
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>