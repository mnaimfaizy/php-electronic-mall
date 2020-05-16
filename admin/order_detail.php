<?php include_once("includes/header.php"); ?>
<?php
	global $database;
	
	if(isset($_GET['order_id'])) {
		$order_id = $_GET['order_id'];
		$sql = "SELECT * FROM orders WHERE order_id=$order_id LIMIT 1";
		$OrderResult = $database->query($sql);
		$orders = $database->fetch_array($OrderResult);	
		$bill_id = $orders['bill_id'];
		$sub_total = $orders['total'];
		$shipping_cost = $orders['shipping_cost'];
		$tax = $orders['tax'];
		$grand_total = $orders['grand_total'];
		$status = $orders['status'];
		$payment_method = $orders['payment_method'];
		$delivery_time = $orders['delivery_time'];
			$bill_sql = $database->query("SELECT * FROM billing WHERE bill_id=$bill_id LIMIT 1");
			$bill_result = $database->fetch_array($bill_sql);
			$email_address = $bill_result['email'];
			$phone = $bill_result['phone'];
			$address_1 = $bill_result['address_1'];
			@$address_2 = $bill_result['address_2'];
			$shipping_order = $bill_result['shipping_order'];
			// Find the state for Billing
			$state_id = $bill_result['state'];
			$state_sql = $database->query("SELECT Name FROM city WHERE ID=$state_id");
			$state_result = $database->fetch_array($state_sql);
			$state = $state_result['Name'];
			// Find the Country for Billing
			$contry_code = $bill_result['country'];
			$country_sql = $database->query("SELECT Name FROM country WHERE Code='$contry_code'");
			$country_result = $database->fetch_array($country_sql);
			$contry = $country_result['Name'];
			
			if($orders['shipping_id'] != 0) {
				$shipping_id = $orders['shipping_id'];
				$shipping_sql = $database->query("SELECT * FROM product_shippment WHERE shippment_id=$shipping_id");
				$shipping_result = $database->fetch_array($shipping_sql);
				$shipping_address_1 = $shipping_result['address1'];
				@$shipping_address_2 = $shipping_result['address2'];
				$shipping_phone = $shipping_result['phone'];
				// Find the state for Shipping
				$shipping_state_id = $shipping_result['state'];
				$shipping_state_sql = $database->query("SELECT Name FROM city WHERE ID=$shipping_state_id");
				$shipping_state_result = $database->fetch_array($shipping_state_sql);
				$shipping_state = $shipping_state_result['Name'];	
				// Find the country for Shipping
				$shipping_country_code = $shipping_result['country'];
				$shipping_country_sql = $database->query("SELECT Name FROM country WHERE Code='$shipping_country_code'");
				$shipping_country_result = $database->fetch_array($shipping_country_sql);
				$shipping_country = $shipping_country_result['Name'];
			}
			
		
	}
?>

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
                        <?php if(isset($_GET['order_id'])) { ?>			
						<h3 class="page-title">
							Order #<?php echo $_GET['order_id']; ?> &nbsp;
                            <small> <strong> Total: $<?php echo $orders['grand_total']; ?> / </strong> 
                   		<span style="color: #C1C1C1;"><?php echo date("m/d/Y,h:i", $orders['date_ordered']); ?></span> 
                   			</small>
                            </h3>
                         <?php } else { ?>
                         <h3 class="page-title">
							No Order selected
                         </h3>
                         <?php } ?>
						
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
            <?php if(isset($_GET['order_id'])) { ?>
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
                	<div class="span3">
                    	<!-- Customer Information Section -->
                    	<div class="portlet" style="background: #E5E5E5; border-radius: 10px; border: 1px solid #D0D0D0; box-shadow: inset 0px 0px 5px #D0D0D0; font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">
							<div class="portlet-body" style="padding: 10px;">
                            <p class="muted"> CUSTOMER INFORMATION </p>
                            <table width="100%" border="0">
                            	<tr>
                                	<td> <i class="icon-user"></i> </td>
                                    <td> <a href="#"> <?php echo $orders['customer_name']; ?> </a> </td>
                                </tr>
                                <tr>
                                	<td> <i class="icon-cloud"></i>   </td>
                                    <td> <?php echo $orders['ip_address']; ?> </td>
                                </tr>
                                <tr>
                                	<td> <i class="icon-phone"></i> </td>
                                    <td> <?php echo $phone; ?> </td>
                                </tr>
                                <tr>
                                	<td> <i class="icon-envelope"></i> </td>
                                    
                                    <td> <a href="mailto:<?php echo $email_address; ?>"> <?php echo $email_address; ?> </a> </td>
                                </tr>
                            </table>
							</div>
                            
						</div>
                       <!-- End of Customer Information Section -->
                       
                       <!-- Billing Information Section -->
                    	<div class="portlet" style="background: #E5E5E5; border-radius: 10px; border: 1px solid #D0D0D0; box-shadow: inset 0px 0px 5px #D0D0D0; font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">
							<div class="portlet-body" style="padding: 10px;">
                            <p class="muted">BILLING ADDRESS </p>
                            <table width="100%" border="0">
                            	<tr>
                                	<td> <i class="icon-tag"></i> </td>
                                    <td> <a href="#"> <?php echo $orders['customer_name']; ?> </a> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $address_1; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $state; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $contry . ", " . $contry_code; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $phone; ?> </td>
                                </tr>
                            </table>
							</div>
                            
						</div>
                       <!-- End of Billing Information Section -->
                       
                       <!-- Shipping Information Section -->
                    	<div class="portlet" style="background: #E5E5E5; border-radius: 10px; border: 1px solid #D0D0D0; box-shadow: inset 0px 0px 5px #D0D0D0; font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">
							<div class="portlet-body" style="padding: 10px;">
                            <p class="muted">SHIPPING ADDRESS </p>
                            <?php if($orders['shipping_id'] != 0) { ?>
                            <table width="100%" border="0">
                            	<tr>
                                	<td> <i class="icon-plane"></i> </td>
                                    <td> <a href="#"> <?php echo $orders['customer_name']; ?> </a> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $shipping_address_1; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $shipping_state; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $shipping_country . ", " . $shipping_country_code; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $shipping_phone; ?> </td>
                                </tr>
                            </table>
                            <?php } else { ?>
                            	<p> Shipping address is same as billing address </p>
                            <?php } ?>
							</div>
                            
						</div>
                       <!-- End of Shipping Information Section -->
                       
                    </div>
					<div class="span6">
						
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box">
							<div class="portlet-body">
								<table  class="table table-hover" >
									<thead>
										<tr>
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th class="hidden-480">Subtotal</th>
										</tr>
									</thead>
									<tbody>
                                    <?php $sql = "SELECT * FROM product_order WHERE order_id=$order_id";
										$product_result = $database->query($sql);
										while($products = $database->fetch_array($product_result)) { 
										$product_id = $products['product_id'];
										$quantity = $products['quantity'];
										$product_sql = $database->query("SELECT * FROM product WHERE product_id=$product_id");
										while($products_result = $database->fetch_array($product_sql)) {
											$product_name = $products_result['product_name'];
											$condition = $products_result['condition'];
											$price = $products_result['price'];
											// Retrive Image of product
											$image_sql = $database->query("SELECT * FROM images WHERE product_id=$product_id LIMIT 1");
											$image_result = $database->fetch_array($image_sql);
											$image_name = $image_result['image_name'];
											$caption = $image_result['caption'];
										?>
										<tr>
											<td>
                                            <span style="float: left;"><img src="../images/product_images/<?php echo $image_name; ?>" width="50" height="50" alt="<?php echo $caption; ?>" /></span> 
                                            <span style="float: left; color:blue; margin-left: 20px;">
                                            <?php echo $product_name; ?> <br/> 
                                            <span style="color: #000;"><strong>Condition</strong> <?php echo $condition; ?></span> </span></td>
											<td>$<?php echo $price; ?></td>
											<td><?php echo $quantity; ?></td>
											<td class="hidden-480">$<?php echo ($price * $quantity); ?></td>
										</tr>
                                    <?php } // End of Inner While Loop 
									} // End of outer While Loop ?>
									</tbody>
								</table>
                                <div class="pull-right" style="text-align: right;">
                                	<h3><strong> Totals </strong></h3>
                                    <table width="300">
                                    	<tr>
                                        	<td> Subtotal: </td>
                                            <td> $<?php echo $sub_total; ?> </td>
                                        </tr>
                                        <tr>
                                        	<td> Shipping cost: </td>
                                            <td> $<?php echo $shipping_cost; ?> </td>
                                        </tr>
                                        <tr>
                                        	<td> Taxes: </td>
                                            <td> $<?php echo $tax; ?> </td>
                                        </tr>
                                        <tr>
                                        	<td> <span style="font-weight:bold; font-size: 18px;">Total:</span> </td>
                                            <td> <span style="color:#009303;"> $<?php echo $grand_total; ?> </span></td>
                                        </tr>
                                    </table>
                                </div>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
                       
                        <div class="portlet box">
                         <hr />
							<div class="portlet-body">
								<h3> <strong> Customer's Note </strong> </h3>
                                <p style="text-align:justify; font-size: 16px;">  
                                <?php echo $shipping_order; ?>
                                </p> 
                            </div>
                         </div>
					</div>
                    <div class="span3">
                    	<div class="portlet" style="background: #E5E5E5; border-radius: 10px; border: 1px solid #D0D0D0; box-shadow: inset 0px 0px 5px #D0D0D0; font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">
							<div class="portlet-body" style="padding: 30px 20px;">
                            <table width="100%" cellpadding="8">
                            	<tr>
                                    <td> <span style="font-size: 15px; font-weight:bold;"> Status </span> </td>
                                    <td> <span style="color: #424BB5;"><?php echo $status; ?></span> </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <span style="font-size: 18px; font-weight:bold;"> Payment information </span> </td>
                                </tr>
                                <tr>
                                    <td> Method </td>
                                    <td> <?php echo $payment_method; ?> </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <span style="font-size: 18px; font-weight:bold;"> Shipping information </span> </td>
                                </tr>
                                <tr>
                                    <td> Delivery Time </td>
                                    <td> <?php echo $delivery_time; ?> </td>
                                </tr>
                                <tr>
                                    <td> <a href="invoice.php?order_id=<?php echo $order_id; ?>&page=order" target="_blank" class="btn green"> <i class=" icon-external-link"></i> Generate Invoice </a> </td>
                                    <td> <a href="mailto:<?php echo $email_address; ?>" class="btn blue"> <i class="icon-envelope"></i> Send Email </a> </td>
                                </tr>
                            </table>
								 
							</div>
						</div>
                    </div>
				</div>
            	<!-- END PAGE CONTENT -->
            <?php } elseif(isset($_GET['paypal_id'])) { ?>
          	<?php $paypal_id = $_GET['paypal_id'];
			$sql = "SELECT * FROM paypal_checkout WHERE paypal_id=$paypal_id LIMIT 1";
			$sql_result = $database->query($sql);
			$orders = $database->fetch_array($sql_result);
			?>
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
                	<div class="span3">
                    	<!-- Customer Information Section -->
                    	<div class="portlet" style="background: #E5E5E5; border-radius: 10px; border: 1px solid #D0D0D0; box-shadow: inset 0px 0px 5px #D0D0D0; font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">
							<div class="portlet-body" style="padding: 10px;">
                            <p class="muted"> CUSTOMER INFORMATION </p>
                            <table width="100%" border="0">
                            	<tr>
                                	<td> <i class="icon-user"></i> </td>
                                    <td> <a href="#"> <?php echo $orders['first_name']." ".$orders['last_name']; ?> </a> </td>
                                </tr>
                                <tr>
                                	<td> <i class="icon-cloud"></i>   </td>
                                    <td> <?php //echo $orders['ip_address']; ?> </td>
                                </tr>
                                <tr>
                                	<td> <i class="icon-phone"></i> </td>
                                    <td> <?php echo 'No Phone'; ?> </td>
                                </tr>
                                <tr>
                                	<td> <i class="icon-envelope"></i> </td>
                                    
                                    <td> <a href="mailto:<?php echo $orders['payer_email']; ?>"> <?php echo $orders['payer_email']; ?> </a> </td>
                                </tr>
                            </table>
							</div>
                            
						</div>
                       <!-- End of Customer Information Section -->
                       
                       <!-- Billing Information Section -->
                    	<div class="portlet" style="background: #E5E5E5; border-radius: 10px; border: 1px solid #D0D0D0; box-shadow: inset 0px 0px 5px #D0D0D0; font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">
							<div class="portlet-body" style="padding: 10px;">
                            <p class="muted">BILLING ADDRESS </p>
                            <table width="100%" border="0">
                            	<tr>
                                	<td> <i class="icon-tag"></i> </td>
                                    <td> <a href="#"> <?php echo $orders['first_name']." ".$orders['last_name']; ?> </a> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $orders['address_street']; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $orders['address_state']; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo $orders['address_country'] . ", " . $orders['address_country_code']; ?> </td>
                                </tr>
                                <tr>
                                	<td></td>
                                    <td> <?php echo 'No Phone'; ?> </td>
                                </tr>
                            </table>
							</div>
                            
						</div>
                       <!-- End of Billing Information Section -->
                       
                       <!-- Shipping Information Section -->
                    	<div class="portlet" style="background: #E5E5E5; border-radius: 10px; border: 1px solid #D0D0D0; box-shadow: inset 0px 0px 5px #D0D0D0; font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">
							<div class="portlet-body" style="padding: 10px;">
                            <p class="muted">SHIPPING ADDRESS </p>
                            	<p> Shipping address is same as billing address </p>
                            </div>
                            
						</div>
                       <!-- End of Shipping Information Section -->
                       
                    </div>
					<div class="span6">
						
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box">
							<div class="portlet-body">
								<table  class="table table-hover" >
									<thead>
										<tr>
											<th>Product</th>
											<th>Price</th>
											<th>Quantity</th>
											<th class="hidden-480">Subtotal</th>
										</tr>
									</thead>
									<tbody>
                                    <?php $sql = "SELECT * FROM payment_items WHERE paypal_id=$paypal_id";
										$product_result = $database->query($sql);
										while($products = $database->fetch_array($product_result)) { 
										$product_id = $products['product_id'];
										$quantity = $products['quantity'];
										$total = $products['mc_gross'];
										$product_sql = $database->query("SELECT * FROM product WHERE product_id=$product_id");
										while($products_result = $database->fetch_array($product_sql)) {
											$product_name = $products_result['product_name'];
											$condition = $products_result['condition'];
											$price = $products_result['price'];
											// Retrive Image of product
											$image_sql = $database->query("SELECT * FROM images WHERE product_id=$product_id LIMIT 1");
											$image_result = $database->fetch_array($image_sql);
											$image_name = $image_result['image_name'];
											$caption = $image_result['caption'];
										?>
										<tr>
											<td>
                                            <span style="float: left;"><img src="../images/product_images/<?php echo $image_name; ?>" width="50" height="50" alt="<?php echo $caption; ?>" /></span> 
                                            <span style="float: left; color:blue; margin-left: 20px;">
                                            <?php echo $product_name; ?> <br/> 
                                            <span style="color: #000;"><strong>Condition</strong> <?php echo $condition; ?></span> </span></td>
											<td>$<?php echo $price; ?></td>
											<td><?php echo $quantity; ?></td>
											<td class="hidden-480">$<?php echo $total; ?></td>
										</tr>
                                    <?php } // End of Inner While Loop 
									} // End of outer While Loop ?>
									</tbody>
								</table>
                                <div class="pull-right" style="text-align: right;">
                                	<h3><strong> Totals </strong></h3>
                                    <table width="300">
                                    	<tr>
                                        	<td> Subtotal: </td>
                                            <td> $<?php echo $total; ?> </td>
                                        </tr>
                                        <tr>
                                        	<td> Shipping cost: </td>
                                            <td> $<?php echo $orders['mc_shipping']; ?> </td>
                                        </tr>
                                        <tr>
                                        	<td> Taxes: </td>
                                            <td> $<?php echo $orders['tax']; ?> </td>
                                        </tr>
                                        <tr>
                                        	<td> <span style="font-weight:bold; font-size: 18px;">Total:</span> </td>
                                            <td> <span style="color:#009303;"> $<?php echo $orders['mc_gross']; ?> </span></td>
                                        </tr>
                                    </table>
                                </div>
							</div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
                       
					</div>
                    <div class="span3">
                    	<div class="portlet" style="background: #E5E5E5; border-radius: 10px; border: 1px solid #D0D0D0; box-shadow: inset 0px 0px 5px #D0D0D0; font-family:Constantia, 'Lucida Bright', 'DejaVu Serif', Georgia, serif;">
							<div class="portlet-body" style="padding: 30px 20px;">
                            <table width="100%" cellpadding="8">
                            	<tr>
                                    <td> <span style="font-size: 15px; font-weight:bold;"> Status </span> </td>
                                    <td> <span style="color: #424BB5;"><?php echo $orders['payment_status']; ?></span> </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <span style="font-size: 18px; font-weight:bold;"> Payment information </span> </td>
                                </tr>
                                <tr>
                                    <td> Method </td>
                                    <td> Paypal </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <span style="font-size: 18px; font-weight:bold;"> Payer ID </span> </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <?php echo $orders['payer_id']; ?> </td>
                                </tr>
                                <tr>
                                    <td> <a href="invoice.php?order_id=<?php echo $paypal_id; ?>&page=paypal" target="_blank" class="btn green"> <i class=" icon-external-link"></i> Generate Invoice </a> </td>
                                    <td> <a href="mailto:<?php echo $orders['payer_email']; ?>" class="btn blue"> <i class="icon-envelope"></i> Send Email </a> </td>
                                </tr>
                            </table>
								 
							</div>
						</div>
                    </div>
				</div>
            	<!-- END PAGE CONTENT -->
            <?php } else { ?>
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
                       <div class="span12">
                       	<h2> Sorry, No order has been selected. </h2>
                        <p> Please select an order from <a href="orders.php"> Orders </a> Page. </p>
                       </div>
				</div>
            	<!-- END PAGE CONTENT -->
            <?php } ?>
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>