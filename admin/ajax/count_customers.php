<?php require_once('../includes/initialize.php'); ?>
<?php $sql = "SELECT COUNT(*) AS total FROM customer";
	$customerResult = $database->query($sql);
	$total = $database->fetch_array($customerResult);
	if($database->num_rows($customerResult) > 0) {
		echo $total['total']; 
	} else {
		echo "0";
	}
?>