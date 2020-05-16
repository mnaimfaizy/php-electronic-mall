<?php require_once('../includes/initialize.php'); ?>
<?php $sql = "SELECT COUNT(*) AS total FROM orders";
	$orderResult = $database->query($sql);
	$total = $database->fetch_array($orderResult);
	$paypal_sql = "SELECT COUNT(*) AS paypal_total FROM paypal_checkout";
	$paypal_Result = $database->query($paypal_sql);
	$paypal_total = $database->fetch_array($paypal_Result);
	if(($total['total'] + $paypal_total['paypal_total']) > 0) {
		echo $total['total'] + $paypal_total['paypal_total']; 
	} else {
		echo "0";
	}
?>