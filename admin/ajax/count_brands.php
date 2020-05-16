<?php require_once('../includes/initialize.php'); ?>
<?php $sql = "SELECT COUNT(*) AS total FROM brand";
	$orderResult = $database->query($sql);
	$total = $database->fetch_array($orderResult);
	if($database->num_rows($orderResult) > 0) {
		echo $total['total']; 
	} else {
		echo "0";
	}
?>