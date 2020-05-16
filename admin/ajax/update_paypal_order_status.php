<?php require_once('../includes/initialize.php'); ?>
<?php 
	if(isset($_POST['paypal_order_id'])) {
	$order_id = $_POST['paypal_order_id'];
	$status = $_POST['status'];
	$sql = "UPDATE paypal_checkout SET status='$status' WHERE paypal_id=$order_id LIMIT 1";
	if($database->query($sql)) {
		echo '<img src="images/ajax-loader.gif" />';	
	} else {
		echo "Failed";
	}
}
?>
