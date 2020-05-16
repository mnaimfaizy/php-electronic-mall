<?php include_once("includes/header.php"); ?>

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
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
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
						</div>
						<!-- END BEGIN STYLE CUSTOMIZER --> 
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Dashboard
						</h3>
						<ul class="breadcrumb">
							<?php $breadcrumb = breadcrumb();
                                echo $breadcrumb; 
                            ?>
                        </ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
                    	<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue">
								<div class="visual">
									<i class="icon-user"></i>
								</div>
								<div class="details">
									<div class="number" id="count_customers">
										
									</div>
									<div class="desc">									
										Registered Customers
									</div>
								</div>
								<a class="more" href="customer_list.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
                        
                        <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="icon-shopping-cart"></i>
								</div>
								<div class="details">
									<div class="number" id="count_orders">
									</div>
									<div class="desc">Orders</div>
								</div>
								<a class="more" href="orders.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
                    	<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="details">
                                	<div class="number" id="count_brands"></div>
									<div class="desc">Brands</div>
								</div>
								<a class="more" href="#">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
                        <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="icon-sitemap"></i>
								</div>
								<div class="details">
									<div class="number" id="count_categories">
									</div>
									<div class="desc">Categories</div>
								</div>
								<a class="more" href="#">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
			</div>
			</div>
            <div class="row-fluid">
					<div class="span6">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>Recent Orders</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
									</thead>
									<tbody id="load_orders">
									
									</tbody>
								</table>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
                    <div class="span6">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>PayPal Orders</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
									</thead>
									<tbody id="load_paypal_orders">
									
									</tbody>
								</table>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
               </div>
               <div class="row-fluid">
                    <div class="span12">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet">
							<div class="portlet-title">
								<h4><i class="icon-bell"></i>Order By Status</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" onClick="load_orders()" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th><i class="icon-bar-chart"></i> Status</th>
											<th class="hidden-phone"><i class="icon-plus-sign"></i> Qty</th>
                                            <th class="hidden-phone"><i class="icon-money"></i> Total</th>
											<th><i class="icon-shopping-cart"></i> Shipping</th>
										</tr>
									</thead>
									<tbody>
                                    	<?php $sql = "SELECT status, COUNT(order_id) AS quantity, SUM(grand_total) AS total, SUM(shipping_cost) AS Shipping FROM orders WHERE status='Complete'";
											$result = $database->query($sql);
											$row = $database->fetch_array($result);
											
											$paypal_sql = "SELECT status, COUNT(paypal_id) AS quantity, SUM(mc_gross) AS total, SUM(mc_shipping) AS shipping FROM paypal_checkout WHERE status='Completed'";
											$paypal_result = $database->query($paypal_sql);
											$paypal = $database->fetch_array($paypal_result);
										?>
										<tr>
											<td class="highlight">
												<div class="success"></div>
												<a href="#">
												<?php if(isset($row['status']) || isset($paypal['status'])) { echo @$row['status'] = $paypal['status']; } else { echo 'Complete'; } ?></a>
											</td>
											<td class="hidden-phone"><?php if(isset($row['quantity']) || isset($paypal['quantity'])) { echo $row['quantity'] + $paypal['quantity']; } else { echo '0'; } ?></td>
											<td><?php if(isset($row['total']) || isset($paypal['total'])) { echo $row['total'] + $paypal['total']; } else { echo '0'; } ?>$</td>
											<td><?php if(isset($row['Shipping']) || isset($paypal['shipping'])) { echo $row['Shipping'] + $paypal['shipping']; } else { echo '0'; }?>$</td>
										</tr>
                                        
										<tr>
                                        <?php $sql = "SELECT status, COUNT(order_id) AS quantity, SUM(grand_total) AS total, SUM(shipping_cost) AS Shipping FROM orders WHERE status='Open'";
											$result = $database->query($sql);
											$row = $database->fetch_array($result);
											$paypal_sql = "SELECT status, COUNT(paypal_id) AS quantity, SUM(mc_gross) AS total, SUM(mc_shipping) AS shipping FROM paypal_checkout WHERE status='Open'";
											$paypal_result = $database->query($paypal_sql);
											$paypal = $database->fetch_array($paypal_result);
										?>
											<td class="highlight">
												<div class="info"></div>
												<a href="#">
												<?php if(isset($row['status']) || isset($paypal['status'])) { echo @$row['status'] = @$paypal['status']; } else { echo 'Open'; } ?> </a>
											</td>
											<td class="hidden-phone"><?php if(isset($row['quantity']) || isset($paypal['quantity'])) { echo $row['quantity'] + $paypal['quantity']; } else { echo '0'; } ?></td>
											<td><?php if(isset($row['total']) || isset($paypal['total'])) { echo $row['total'] + $paypal['total']; } else { echo '0'; } ?>$</td>
											<td><?php if(isset($row['Shipping']) || isset($paypal['shipping'])) { echo $row['Shipping'] + $paypal['shipping']; } else { echo '0'; }?>$</td>
										</tr>
										<tr>
                                        <?php $sql = "SELECT status, COUNT(order_id) AS quantity, SUM(grand_total) AS total, SUM(shipping_cost) AS Shipping FROM orders WHERE status='Processed'";
											$result = $database->query($sql);
											$row = $database->fetch_array($result);
											
											$paypal_sql = "SELECT status, COUNT(paypal_id) AS quantity, SUM(mc_gross) AS total, SUM(mc_shipping) AS shipping FROM paypal_checkout WHERE status='Processed'";
											$paypal_result = $database->query($paypal_sql);
											$paypal = $database->fetch_array($paypal_result);
										?>
											<td class="highlight">
												<div class="important"></div>
												<a href="#"><?php if(isset($row['status']) || isset($paypal['status'])) { echo $row['status'] = $paypal['status']; } else { echo 'Processed'; } ?> </a>
											</td>
											<td class="hidden-phone"><?php if(isset($row['quantity']) || isset($paypal['quantity'])) { echo $row['quantity'] + $paypal['quantity']; } else { echo '0'; } ?></td>
											<td><?php if(isset($row['total']) || isset($paypal['total'])) { echo $row['total'] + $paypal['total']; } else { echo '0'; } ?>$</td>
											<td><?php if(isset($row['Shipping']) || isset($paypal['shipping'])) { echo $row['Shipping'] + $paypal['shipping']; } else { echo '0'; }?>$</td>
										</tr>
                                        <tr>
                                        <?php $sql = "SELECT status, COUNT(order_id) AS quantity, SUM(grand_total) AS total, SUM(shipping_cost) AS Shipping FROM orders WHERE status='Canceled'";
											$result = $database->query($sql);
											$row = $database->fetch_array($result);
											
											$paypal_sql = "SELECT status, COUNT(paypal_id) AS quantity, SUM(mc_gross) AS total, SUM(mc_shipping) AS shipping FROM paypal_checkout WHERE status='Canceled'";
											$paypal_result = $database->query($paypal_sql);
											$paypal = $database->fetch_array($paypal_result);
										?>
											<td class="highlight">
												<div class="danger"></div>
												<a href="#"><?php if(isset($row['status']) || isset($paypal['status'])) { echo $row['status'] = $paypal['status']; } else { echo 'Canceled'; } ?> </a>
											</td>
											<td class="hidden-phone"><?php if(isset($row['quantity']) || isset($paypal['quantity'])) { echo $row['quantity'] + $paypal['quantity']; } else { echo '0'; } ?></td>
											<td><?php if(isset($row['total']) || isset($paypal['total'])) { echo $row['total'] + $paypal['total']; } else { echo '0'; } ?>$</td>
											<td><?php if(isset($row['Shipping']) || isset($paypal['shipping'])) { echo $row['Shipping'] + $paypal['shipping']; } else { echo '0'; }?>$</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
				</div>
                    
            <div style="margin: 20px 0px;"></div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>