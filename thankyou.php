<?php include 'includes/header.php'; ?>
<?php 
if(!empty($_POST)) {
	// Store the data which are send from paypal
	// Variables that are coming from the paypal
	@$mc_gross = $_POST['mc_gross'];
	@$protection_eligibility = $_POST['protection_eligibility'];
	@$address_status = $_POST['address_status'];
	@$payer_id = $_POST['payer_id'];
	@$tax = $_POST['tax'];
	@$address_street = $_POST['address_street'];
	@$payment_date = $_POST['payment_date'];
	@$payment_status = $_POST['payment_status'];
	@$address_zip = $_POST['address_zip'];
	@$mc_shipping = $_POST['mc_shipping'];
	@$mc_handling = $_POST['mc_handling'];
	@$first_name = $_POST['first_name'];
	@$last_name = $_POST['last_name'];
	@$mc_fee = $_POST['mc_fee'];
	@$address_country_code = $_POST['address_country_code'];
	@$address_name = $_POST['address_name'];
	@$notify_version = $_POST['notify_version'];
	@$payer_status = $_POST['payer_status'];
	@$business = $_POST['business'];
	@$address_country = $_POST['address_country'];
	@$num_cart_items = $_POST['num_cart_items'];
	@$address_city = $_POST['address_city'];
	@$payer_email = $_POST['payer_email'];
	@$verify_sign = $_POST['verify_sign'];
	@$txn_id = $_POST['txn_id'];
	@$payment_type = $_POST['payment_type'];
	@$address_state = $_POST['address_state'];
	@$receiver_email = $_POST['receiver_email'];
	@$payment_fee = $_POST['payment_fee'];
	@$receiver_id = $_POST['receiver_id'];
	@$txn_type = $_POST['txn_type'];
	@$mc_currency = $_POST['mc_currency'];
	@$residence_country = $_POST['residence_country'];
	@$test_ipn = $_POST['test_ipn'];
	@$transaction_subject = $_POST['transaction_subject'];
	@$payment_gross = $_POST['payment_gross'];
	@$auth = $_POST['auth'];
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$date_ordered = time();
	
	$query = "INSERT INTO 
	`paypal_checkout`(`mc_gross`, `protection_eligibility`, `address_status`, `payer_id`, `tax`, `address_street`, `payment_date`, `payment_status`, `address_zip`, `mc_shipping`, `mc_handling`, `first_name`, `last_name`, `mc_fee`, `address_country_code`, `address_name`, `notify_version`, `payer_status`, `business_email`, `address_country`, `num_cart_items`, `address_city`, `payer_email`, `verify_sign`, `txn_id`, `payment_type`, `address_state`, `receiver_email`, `payment_fee`, `receiver_id`, `txn_type`, `mc_currency`, `residence_country`, `test_ipn`, `transaction_subject`, `payment_gross`, `auth`,`ip_address`,`date_added`) 
	VALUES ($mc_gross,'$protection_eligibility','$address_status','$payer_id',$tax,'$address_street','$payment_date','payment_status','$address_zip',$mc_shipping,$mc_handling,'$first_name','$last_name',$mc_fee,'$address_country_code','$address_name',$notify_version,'$payer_status','$business','$address_country',$num_cart_items,'$address_city','$payer_email','$verify_sign','$txn_id','$payment_type','$address_state','$receiver_email','$payment_fee','$receiver_id','$txn_type','$mc_currency','$residence_country','$test_ipn','$transaction_subject',$payment_gross,'$auth','$ip_address', $date_ordered)";
	
	if($database->query($query)) {
	
		// Variable that will be store in the paypal_item table
		// Now loop through the $_POST array for the items and there price
		// First find the inserted paypal_id from the database
		$sql = "SELECT paypal_id FROM paypal_checkout ORDER BY paypal_id DESC LIMIT 1";
		$sql_result = $database->query($sql);
		if($database->num_rows($sql_result) > 0) {
			$paypal_id_result = $database->fetch_array($sql_result);
			$paypal_id = $paypal_id_result['paypal_id'];	
			}
		$no = 0;
		while(array_key_exists('item_number'.++$no, $_POST)) {
			
			$product_id = $_POST['item_number'.$no];
			$mc_handling = $_POST['mc_handling'.$no];
			$tax = $_POST['tax'.$no];
			$item_name = $_POST['item_name'.$no];
			$quantity = $_POST['quantity'.$no];
			$mc_gross = $_POST['mc_gross_'.$no];
			$items_query = "INSERT INTO `payment_items`(`paypal_id`, `product_id`, `mc_handling`, `mc_shipping`, `tax`, `item_name`, `quantity`, `mc_gross`) 
			VALUES (
			$paypal_id, 
			$product_id, 
			$mc_handling, 
			$mc_shipping, 
			$tax, 
			'$item_name', 
			$quantity, 
			$mc_gross)";
			$database->query($items_query);
		}
		unset($_SESSION['cart_array']);
		unset($_SESSION['shipping_cost']);
		unset($_SESSION['delivery_time']);
	}
} else { 
	$locaction = "http://".$hostname."/index.php";
	echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$locaction.'">';
	exit;
}
?>
	<?php include 'includes/navigation.php'; ?>
	<div class="container">
        <div class="row">
            <div class="col-sm-12">
            <?php require('includes/breadcrumb.php'); ?>
            </div>
        </div>
        
        <div class="row">
        	<div class="jumbotron">
            	<?php if(!empty($_POST)) { ?>
                	<h1> Thank you <strong> <?php echo $_POST['first_name'] . " " . $_POST['last_name']; ?> from shopping </h1> 
                    <p> You will recevie your recipt in your email along with more details regarding your shipment. </p>
                
                <?php } ?>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>