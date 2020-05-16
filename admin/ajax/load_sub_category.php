<?php require_once('../includes/initialize.php'); ?>
<?php
	global $database;
	if(isset($_GET['category_id'])) {
		$cat_id = $_GET['category_id'];
		
		$sql = "SELECT * from sub_category WHERE category_id=$cat_id";
		$result = $database->query($sql);
		while($rows = $database->fetch_array($result)) {
			echo "<option value='$rows[sub_cat_id]'>$rows[sub_cat_name]</option>";	
		}
	}
?>