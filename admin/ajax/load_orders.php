<?php require_once('../includes/initialize.php'); ?>

<?php 
	$sql = "SELECT * FROM orders WHERE status='Open' OR status='Processed' ORDER BY order_id DESC LIMIT 10";
	$Order_result = $database->query($sql);
	while($row = $database->fetch_array($Order_result)) {

	echo '<tr>';
		if($row['status'] == 'Open') { 
		echo '<td><a href="#" class="btn yellow mini"> ' . $row['status'] . ' </a></td>';
		} elseif($row['status'] == 'Processed') {
		echo '<td><a href="#" class="btn blue mini"> ' .$row['status']. ' </a></td>';
		}
		echo '<td><a href="order_detail.php?order_id='.$row['order_id'].'">Order #'.$row['order_id']. '</a> by <a href="customer_list.php">' . $row['customer_name'] . '</a></td>';
		echo '<td>'. date("m/d/Y, h:i:s A", $row['date_ordered']) . '</td>';
		echo '<td class="hidden-480"><strong><span style="font-size: 20px;"> $' . $row['grand_total']. '</span> </strong></td>';
	echo '</tr>';
	}
?>