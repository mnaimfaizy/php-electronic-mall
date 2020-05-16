<?php require_once('../includes/initialize.php'); ?>

<?php 
	$sql = "SELECT * FROM paypal_checkout WHERE status='Open' OR status='Processed' ORDER BY paypal_id DESC LIMIT 10";
	$Order_result = $database->query($sql);
	while($row = $database->fetch_array($Order_result)) {

	echo '<tr>';
		if($row['status'] == 'Open') { 
		echo '<td><a href="#" class="btn yellow mini"> ' . $row['status'] . ' </a></td>';
		} elseif($row['status'] == 'Processed') {
		echo '<td><a href="#" class="btn blue mini"> ' .$row['status']. ' </a></td>';
		}
		echo '<td><a href="order_detail.php?paypal_id='.$row["paypal_id"].'">Order #'.$row['paypal_id']. '</a> by <a href="customer_list.php">' . $row['first_name'] .' '. $row['last_name'] . '</a></td>';
		echo '<td>'. $row['payment_date'] . '</td>';
		echo '<td class="hidden-480"><strong><span style="font-size: 20px;"> $' . $row['mc_gross']. '</span> </strong></td>';
	echo '</tr>';
	}
?>