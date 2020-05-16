<?php require_once('../includes/initialize.php'); ?>
<?php
	global $database;
	if(isset($_GET['country_code'])) {
		$country_code = $_GET['country_code'];
		
		echo $sql = "SELECT * from city WHERE CountryCode='$country_code'";
		$result = $database->query($sql);
		while($rows = $database->fetch_array($result)) {
			echo "<option value='$rows[ID]'>$rows[Name]</option>";	
		}
	}
?>