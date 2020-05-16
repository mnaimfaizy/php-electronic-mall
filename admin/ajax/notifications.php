<?php require_once('../includes/initialize.php'); ?>

<?php
	$query = "SELECT COUNT(*) AS orderTotal FROM orders WHERE `date_ordered` >=" . (time()-(60*60*24));
		$queryResult = $database->query($query);
		$order = $database->fetch_array($queryResult);
		@$orders = $order['orderTotal'];
	$sql = "SELECT date_added, COUNT(*) AS total FROM customer WHERE date_added >=" . (time()-(60*60*24));
		$sqlResult = $database->query($sql);
		$row = $database->fetch_array($sqlResult);
		@$new_customers = $row['total'];
	$sql = "SELECT date_added, COUNT(*) AS paypaltotal FROM paypal_checkout WHERE date_added >=" . (time()-(60*60*24));
		$sqlResult = $database->query($sql);
		$row = $database->fetch_array($sqlResult);
		@$new_paypal_orders = $row['paypaltotal'];
	
		if(($new_customers > 0) || ($orders > 0) || ($new_paypal_orders > 0)) {
	echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
		echo '<i class="icon-warning-sign"></i>';
		echo '<span class="badge">';
		echo $new_customers + $orders + $new_paypal_orders;
		echo '</span>';
	echo '</a>';
		} else {
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
		echo '<i class="icon-warning-sign"></i>';
		echo '</a>';
		}
		echo '<ul class="dropdown-menu extended notification">';
			echo '<li>';
				if(($new_customers > 0) || ($orders > 0)) {
				echo '<p>You have '. $new_customers + $orders + $new_paypal_orders .' new notifications</p>';
				} else {
				echo '<p>You have no new notifications</p>';	
				}
			echo '</li>';
			if(($new_customers > 0)) {
				for($i=1; $i <= $new_customers; $i++) {
				echo '<li>';
					echo '<a href="#">';
					echo '<span class="label label-success"><i class="icon-plus"></i></span>';
						echo 'New customer registered. ';
					echo '</a>';
				echo '</li>';
				}
				echo '<li class="external">';
				echo '<a href="customer_list.php">See all customers <i class="m-icon-swapright"></i></a>';
				echo '</li>';
			}
			if((($orders + $new_paypal_orders) > 0)) {
				for($i=1; $i <= $orders; $i++) {
				echo '<li>';
					echo '<a href="#">';
					echo '<span class="label label-success"><i class="icon-plus"></i></span>';
						echo 'New order submited. ';
					echo '</a>';
				echo '</li>';
				}
			
			} else {
				echo '<li>';	
					echo '<p> There is no new notification </p>';
				echo '</li>';	
			}
		echo '</ul>';
 ?>