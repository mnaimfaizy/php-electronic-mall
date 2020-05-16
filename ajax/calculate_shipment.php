<?php require_once('../admin/includes/initialize.php'); ?>
<?php
global $database;
if(isset($_GET['country_code']) && isset($_GET['state'])) {
		$country = $_GET['country_code'];
		$state = $_GET['state'];
		
		$sql = "SELECT shipping_cost, delivery_time FROM shipping WHERE country_id='$country' AND province_id=$state AND status='Active' LIMIT 1";
		$result = $database->query($sql);
		if($database->num_rows($result) > 0) {
			$row = $database->fetch_array($result);
				echo $_SESSION['shipping_cost'] = $row['shipping_cost'];	
				$_SESSION['delivery_time'] = $row['delivery_time'];
		} else {
			echo $_SESSION['shipping_cost'] = 0;
			$_SESSION['delivery_time'] = 0;	
		}
		
	}