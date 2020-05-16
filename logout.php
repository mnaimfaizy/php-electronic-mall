<?php require_once('admin/includes/initialize.php'); ?>
<?php
if(isset($_GET['status']) && $_GET['status'] = 'delete') {
	unset($_SESSION['customer_id']);
	unset($_SESSION['customer_name']);
	unset($_SESSION['key']);
	unset($_SESSION['cart_array']);
	unset($_SESSION['shipping_cost']);
	unset($_SESSION['delivery_time']);
	setcookie("customer_id", $row['customer_id'], time()-7200);
	setcookie("customer_name", $row['customer_name'], time()-7200);
	setcookie("key", $key, time()-7200);
	redirect_to("login.php");	
}

?>