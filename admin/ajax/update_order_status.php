<?php require_once('../includes/initialize.php'); ?>
<?php 
	if(isset($_POST['order_id'])) {
	$order_id = $_POST['order_id'];
	$status = $_POST['status'];
	$sql = "UPDATE orders SET status='$status' WHERE order_id=$order_id LIMIT 1";
	if($database->query($sql)) {
		echo '<img src="images/ajax-loader.gif" />';	
	} else {
		echo "Failed";
	}
}
?>
