<?php require_once('../includes/initialize.php'); ?>
<?php 
	if(isset($_POST['user_id'])) {
	$user_id = $_POST['user_id'];
	$group = $_POST['group'];
	$sql = "UPDATE user SET group_id=$group WHERE id=$user_id LIMIT 1";
	if($database->query($sql)) {
		echo '<img src="images/ajax-loader.gif" />';	
	} else {
		echo "Failed";
	}
}
?>
