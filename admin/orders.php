<?php include_once("includes/header.php"); ?>
<?php
	global $database;
?>
<script>
	function conf(id) {
		var value = window.confirm("Are you sure! You want to delete selected Item?");
		if(value == true) {
			window.location = "delete.php?customer_id="+id;
		} else { 
			// Do something else
		}
	}
	
	function update_order_status(id) {
		var status = $("#status_"+id).val();
		//alert(status);
		$("#Loading").removeClass('hidden');
		$("#Loading").addClass('show');
		$("#Loading").fadeIn("fast"); // show when submitting
		$.post('ajax/update_order_status.php', {order_id: id, status: status}, function(data) {
				//$('div#update ul.searchresults').html(data);
				//alert(data);
				$("#Loading").fadeOut(4000); // hide when data's ready
				//$("#Loading").removeClass('show');
				//$('#Loading').addClass('hidden');
				
		});		
		return false;
	}
	function update_paypal_order_status(id) {
		var status = $("#paypal_status_"+id).val();
		//alert(status);
		$("#Loading2").removeClass('hidden');
		$("#Loading2").addClass('show');
		$("#Loading2").fadeIn("fast"); // show when submitting
		$.post('ajax/update_paypal_order_status.php', {paypal_order_id: id, status: status}, function(data) {
				$("#Loading2").fadeOut(4000); // hide when data's ready
		});		
		return false;
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
							Orders List &nbsp;				<small> Here You can view all orders which are submited by customers.</small>
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
                    <div class="span5"></div>
                    <!--<div class="span2 hidden" id="Loading">
                        <img src="images/ajax-loader.gif" />
                    </div>-->
                    <div class="span5"></div>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Custom Orders</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="span2 hidden" id="Loading">
                                    <img src="images/ajax-loader.gif" />
                                </div>
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="generate_pdf.php?page=orders" target="_blank">Save as PDF</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-hover table-bordered" id="custom_orders">
									<thead>
										<tr>
											<th>ID</th>
                                            <th>
                                            Status
                                            </th>
                                            <th>Date</th>
											<th>Customer</th>
                                            <th>IP Address</th>
                                            <th>Country</th>
                                            <th>Phone</th>
                                            <th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$sql = "SELECT order_id, bill_id, status, date_ordered, customer_name, ip_address, grand_total FROM orders ORDER BY order_id DESC"; 
											$result = $database->query($sql);
											while($customer = $database->fetch_array($result)) {
											$order_id = $customer['order_id'];
											$bill_id = $customer['bill_id'];
										?>
                                        <tr class="">
											<td><?php echo '<a href="order_detail.php?order_id=' . $order_id. '">Order #' . $customer['order_id'] . '</a>'; ?></td>
                                            <td>
                                            
                                            <?php $status = $customer['status']; ?>
                                            <select name="status" id="status_<?php echo $order_id; ?>" class="span5">
                                            	<option value="Open" 
												<?php if($status == 'Open') { echo 'selected'; } ?>> Open </option>
                                                <option value="Processed" 
                                                <?php if($status == 'Processed') { echo 'selected'; } ?>> Processed </option>
                                                <option value="Complete" 
                                                <?php if($status == 'Complete') { echo 'selected'; } ?>> Complete </option>
                                                <option value="Failed" 
                                                <?php if($status == 'Failed') { echo 'selected'; } ?>> Failed </option>
                                            </select>
                                            <button class="btn green" id="<?php echo $order_id; ?>" onClick="update_order_status(this.id)"> UPDATE </button>
                                            
											</td>
                                            <td><?php echo date("d/m/Y, h:i", $customer['date_ordered']); ?></td>
											<td><?php echo '<a href="customer_list.php"> @ ' . $customer['customer_name'] . '</a>'; ?></td>
                                            <td><?php echo $customer['ip_address'];?></td>
                                            <td><?php $ip_address = $customer['ip_address'];
											$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip_address));
											if($query && $query['status'] == 'success') {
												echo $query['country'];	
											} else {
												echo 'Localhost';
											}?></td>
                                         <td><?php $query = "SELECT phone FROM billing WHERE bill_id=$bill_id LIMIT 1";
											$queryResult = $database->query($query);
											$phone = $database->fetch_array($queryResult);
											echo $phone['phone'];
											?></td>
                                            <td><?php echo "$" . $customer['grand_total']; ?></td>
										</tr>
                                        <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
                    </div>
                    <div class="row-fluid">
                    <div class="span12">
                    <div class="span5"></div>
                    <!--<div class="span2 hidden" id="Loading">
                        <img src="images/ajax-loader.gif" />
                    </div>-->
                    <div class="span5"></div>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>PayPal Orders</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="span2 hidden" id="Loading2">
                                    <img src="images/ajax-loader.gif" />
                                </div>
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="generate_pdf.php?page=paypal" target="_blank">Save as PDF</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="paypal_orders">
									<thead>
										<tr>
											<th>ID</th>
                                            <th>Status</th>
                                            <th>Date</th>
											<th>Customer</th>
                                            <th>Country</th>
                                            <th>IP Address</th>
                                            <th>email</th>
                                            <th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$sql = "SELECT paypal_id, status, payment_date, first_name, last_name, address_country, payer_email, payment_gross, ip_address FROM paypal_checkout ORDER BY paypal_id DESC"; 
											$result = $database->query($sql);
											while($customer = $database->fetch_array($result)) {
											$paypal_order_id = $customer['paypal_id'];
										?>
                                        <tr class="">
											<td><?php echo '<a href="order_detail.php?paypal_id=' . $paypal_order_id. '">Order #' . $paypal_order_id . '</a>'; ?></td>
                                            <td><?php $status = $customer['status']; ?>
                                            <select name="status" id="paypal_status_<?php echo $paypal_order_id; ?>" class="span5">
                                            	<option value="Open" 
												<?php if($status == 'Open') { echo 'selected'; } ?>> Open </option>
                                                <option value="Processed" 
                                                <?php if($status == 'Processed') { echo 'selected'; } ?>> Processed </option>
                                                <option value="Complete" 
                                                <?php if($status == 'Complete') { echo 'selected'; } ?>> Complete </option>
                                                <option value="Failed" 
                                                <?php if($status == 'Failed') { echo 'selected'; } ?>> Failed </option>
                                            </select>
                                            <button class="btn green" id="<?php echo $paypal_order_id; ?>" onClick="update_paypal_order_status(this.id)"> UPDATE </button>
                                            </td>
                                            <td><?php echo $customer['payment_date']; ?></td>
											<td><?php echo $customer['first_name'] . " " . $customer['last_name']; ?></td>
                                            <td><?php echo $customer['address_country'];?></td>
                                            <td><?php echo $customer['ip_address']; ?></td>
                                         	<td><?php echo $customer['payer_email']; ?></td>
                                            <td><?php echo "$" . $customer['payment_gross']; ?></td>
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