<?php include 'includes/header.php'; ?>
<?php
	if(isset($_POST['submitOrder'])) {
		@$guest = $_POST['guest'];	
		// Billing Variables
		@$bill_companyName = $_POST['bill_companyName'];
		@$bill_email = $_POST['bill_email'];
		@$bill_firstname = $_POST['bill_firstname'];
		@$bill_middlename = $_POST['bill_middlename'];
		@$bill_lastname = $_POST['bill_lastname'];
		@$bill_address1 = $_POST['bill_address1'];
		@$bill_address2 = $_POST['bill_address2'];
		@$bill_zip = $_POST['bill_zip'];
		@$bill_country = $_POST['bill_country'];
		@$bill_state = $_POST['bill_state'];
		@$bill_phone = $_POST['bill_phone'];
		@$bill_mobile = $_POST['bill_mobile'];
		@$bill_fax = $_POST['bill_fax'];
		// Shipping Variables
		@$shipping_companyName = $_POST['shipping_companyName'];
		@$shipping_email = $_POST['shipping_email'];
		@$shipping_firstname = $_POST['shipping_firstname'];
		@$shipping_middlename = $_POST['shipping_middlename'];
		@$shipping_lastname = $_POST['shipping_lastname'];
		@$shipping_address1 = $_POST['shipping_address1'];
		@$shipping_address2 = $_POST['shipping_address2'];
		@$shipping_zip = $_POST['shipping_zip'];
		@$shipping_country = $_POST['shipping_country'];
		@$shipping_state = $_POST['shipping_state'];
		@$shipping_phone = $_POST['shipping_phone'];
		@$shipping_mobile = $_POST['shipping_mobile'];
		@$shipping_fax = $_POST['shipping_fax'];
		// Other Variables
		@$shipping_order = $_POST['shipping_order'];
		if(isset($_POST['direct_bank_transfer'])) {
			$payment_method = $_POST['direct_bank_transfer'];
		} elseif(isset($_POST['check_payment'])) {
			$payment_method = $_POST['check_payment'];
		}
		@$cartSubTotal = $_POST['cartSubTotal'];
		@$tax = $_POST['tax'];
		@$shippingCost = $_POST['shippingCost'];
		@$delivery_time = $_POST['delivery_time'];
		@$subTotal = $_POST['subTotal'];
		
		if(isset($_SESSION['customer_id'])) {
			$customer_id = $_SESSION['customer_id'];
		} elseif(isset($_COOKIE['customer_id'])) {
			$customer_id = $_COOKIE['customer_id'];	
		}else {
			$customer_id = 0;
		}
		if(isset($_SESSION['customer_name'])) {
			$customer_name = $_SESSION['customer_name'];
			
		} elseif(isset($_COOKIE['customer_name'])) {
			$customer_name = $_COOKIE['customer_name'];		
		}else {
			$customer_name = 'Guest';
		}
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$status = 'Open';
		$date_ordered = time();
		$shipping_id = '';
				
		$BillingSql = "INSERT INTO `billing` VALUES (NULL,'$bill_companyName','$bill_email','$bill_firstname','$bill_middlename','$bill_lastname','$bill_address1','$bill_address2','$bill_zip','$bill_country','$bill_state','$bill_phone','$bill_mobile','$bill_fax','$shipping_order')";
		
		if($billing_result = $database->query($BillingSql)) {
		$GetBillIDSql = "SELECT bill_id FROM billing ORDER BY bill_id DESC LIMIT 1";
		$bill_result = $database->query($GetBillIDSql);
		$bill_id = $database->fetch_array($bill_result);
		$bill_id = $bill_id['bill_id'];
		
		if(!isset($_POST['shippingAddress']) && @$_POST['shippingAddress'] != 'on') {
			$shippmentSql = "INSERT INTO `product_shippment` VALUES (NULL,'$shipping_companyName','$shipping_email','$shipping_firstname','$shipping_middlename','$shipping_lastname','$shipping_address1','$shipping_address2','$shipping_zip','$shipping_country','$shipping_state','$shipping_phone','$shipping_mobile','$shipping_fax')";
			if($database->query($shippmentSql)) {
				$shipping_id_query = "SELECT shippment_id FROM product_shippment ORDER BY shippment_id DESC LIMIT 1";
				$shipping_result = $database->query($shipping_id_query);
				$shippingID = $database->fetch_array($shipping_result);
				$shipping_id = $shippingID['shippment_id'];
			}
		} else {
			$shipping_id = 0;
		}
		$ordersSQL = "INSERT INTO `orders`( `customer_id`, `customer_name`, `total`, `shipping_cost`, `tax`, `grand_total`, `delivery_time`, `payment_method`, `bill_id`, `shipping_id`, `ip_address`, `status`, `date_ordered`) 
		VALUES ($customer_id,'$customer_name',$cartSubTotal,$shippingCost,$tax,$subTotal,'$delivery_time','$payment_method',$bill_id,$shipping_id,'$ip_address','$status', $date_ordered)";
		
		if($database->query($ordersSQL)) {
			$getOrder_id_sql = "SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1";
			$getOrderIDsql = $database->query($getOrder_id_sql);
			$order_id = $database->fetch_array($getOrderIDsql);
			$order_id = $order_id['order_id'];
			foreach($_SESSION['cart_array'] as $each_item) {
			$product_id = $each_item['item_id'];
			$quantity = $each_item['quantity'];
			$sql = "INSERT INTO product_order(product_id, order_id, quantity) VALUES ($product_id, $order_id, $quantity)";
			// If the query is successfully executed then send an e-mail to the customer 
			if($database->query($sql)) {
				$to = strip_tags($_POST['bill_email']);
				$subject = 'E-mall: Your products list for aproval';
				
				// Additional headers
				$headers = 'To: ' . $to . "rn";
				$headers .= "From: Mohammad Naim Faizy <e-mall@mnfprofile.com>rn";
				$headers .= 'Reply-To: e-mall@mnfprofile.com' . "rn";
				$headers .= 'CC: e-mall@mnfprofile.comrn';
				
				// To send HTML mail, the Content-type header must be set
				$headers .= "MIME-Version: 1.0rn";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1rn";
				
				$msg = "<body style=\"background-color: #EBDFDF; font-family:'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif; width: 580px;\">
	<h1 style=\"font-size: 30px; text-align: center; margin: 10px;\"> Thanks From Shopping </h1>
    <h3 style=\"font-size: 22px;\"> Dear Customer we are glade that you have visited our website and bought products from us </h3>
    <hr />
    <p> You have selected Check Payment and your order is waiting for you, just submit your bank information and check number in this link <a href=\"http://localhost/E-Mall/check_info.php\" target=\"_blank\"> Check Info page </a>. <br /> 
    When we deliver the products you can submit the check to our delivry person and get products. </p>
    
    <p> <strong> Note: </strong> You orders will be stored with us for 1 weak, if we didn't recive any email from you so your orders will be canceled. </p>
</body>";
				// Mail it
				if(mail($to, $subject, $msg, $headers)) {
					echo '<script> alert("Email send successfully"); </script>';	
				} else {
					echo '<script> alert("Email not send successfully"); </script>';
				}
			}
			}
			unset($_SESSION['cart_array']);
			unset($_SESSION['shipping_cost']);
			unset($_SESSION['delivery_time']);
			$Message = true;	
		} else {
			$Message = false;
		}
		
		}
		
	}
?>
	<?php include 'includes/navigation.php'; ?>
	<div class="container">
        <div class="row">
            <div class="col-sm-12">
            <?php require('includes/breadcrumb.php'); ?>
            </div>
        </div>
    <?php if(isset($Message) && $Message == true) { ?>
	<section id="cart_items">
		<div class="container">
    	<div class="row">
        	<div class="jumbotron">
            	<h2> Your Order has been submitted :) </h2>
                <p> Thanks for shopping from our website, shortly you will recive an email and the payment method which you have selected will be described and you can do the payment.<br/> 
                After payment is confirmed we will send an invoice to your email and according to the delivery time you will recive the products. </p>
                <p> Thanks again for shopping from our website </p>
                <p> <a href="index.php" class="btn btn-primary btn-lg"> Continue Shopping </a> </p>
            </div>
        </div>
    </div>
	</section> <!--/#cart_items-->
    <?php } else { ?>
    <div class="container">
    	<div class="row">
        	<div class="jumbotron">
            	<h2> Your Shopping Cart is Empty :( </h2>
                <p> Please add at least one product to shopping cart </p>
            </div>
        </div>
    </div>
    <?php } ?>
<?php include 'includes/footer.php'; ?>