<?php require_once("includes/initialize.php"); ?>
<?php
global $database;
/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from product_category.php page
if(isset($_GET['product_category_id'])) {
	
	$category_id = $_GET['product_category_id'];
	
	$sql = "DELETE FROM product_category WHERE category_id=$category_id LIMIT 1";
	
	if($database->query($sql)) {
		redirect_to("product_category.php");	
	} else {
		echo "Record can not be deleted, please try again. <br />";
		echo "To go Back <a href=\"product_category.php\"> Click Me </a>";
	}	
}
/* ------------------------------------------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from product_sub_category.php page
if(isset($_GET['product_sub_category_id'])) {
	
	$sub_cat_id = $_GET['product_sub_category_id'];
	
	$sql = "DELETE FROM sub_category WHERE sub_cat_id=$sub_cat_id LIMIT 1";
	if($database->query($sql)) {
		redirect_to("product_sub_category.php");	
	} else {
		echo "Record can not be deleted, please try again. <br />";
		echo "To go Back <a href=\"product_category.php\"> Click Me </a>";
	}	
}
/* ------------------------------------------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from brand.php page
if(isset($_GET['brand_id'])) {
	
	$brand_id = $_GET['brand_id'];
	
	$sql = "SELECT brand_image FROM brand WHERE brand_id=$brand_id LIMIT 1";
	$result = $database->query($sql);
	$image = $database->fetch_array($result);
	$brand_image = $image['brand_image'];
	$target_path = '../images/brands/'.$brand_image;
		
			$sql = "DELETE FROM brand WHERE brand_id=$brand_id LIMIT 1";
			if($database->query($sql)) {
				if(file_exists($target_path)) {
					unlink($target_path);
				}
				redirect_to("brand.php");	
			} else {
				echo "Record can not be deleted, please try again. <br />";
				echo "To go Back <a href=\"brand.php\"> Click Me </a>";
			}			
}
/* ------------------------------------------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from product_list.php page
if(isset($_GET['product_id'])) {
	
	$product_id = $_GET['product_id'];
	
	$sql = "SELECT image_name FROM images WHERE product_id=$product_id LIMIT 1";
	$result = $database->query($sql);
	$image = $database->fetch_array($result);
	$product_image = $image['image_name'];
	$target_path = '../images/product_images/'.$product_image;
		
			$sql = "DELETE FROM product WHERE product_id=$product_id LIMIT 1";
			if($database->query($sql)) {
				if(file_exists($target_path)) {
					$sql = "DELETE FROM images WHERE product_id=$product_id LIMIT 1";
					$database->query($sql);
					unlink($target_path);
				}
				redirect_to("product_list.php");	
			} else {
				echo "Record can not be deleted, please try again. <br />";
				echo "To go Back <a href=\"brand.php\"> Click Me </a>";
			}			
}
/* ------------------------------------------------------------------------------------------------------------- */


/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from product_list.php page
if(isset($_GET['image_id'])) {
	
	$image_id = $_GET['image_id'];
	
	$sql = "SELECT image_name FROM images WHERE id=$image_id LIMIT 1";
	$result = $database->query($sql);
	$image = $database->fetch_array($result);
	$product_image = $image['image_name'];
	$target_path = '../images/product_images/'.$product_image;
		if(file_exists($target_path)) {
			$sql = "DELETE FROM images WHERE id=$image_id LIMIT 1";
			$database->query($sql);
			unlink($target_path);
			redirect_to("product_list.php");
		} else {
			echo "Record can not be deleted, please try again. <br />";
			echo "To go Back <a href=\"product_list.php\"> Click Me </a>";
		}			
}
/* ------------------------------------------------------------------------------------------------------------- */


/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from customer_list.php page
if(isset($_GET['customer_id'])) {
	
	$customer_id = $_GET['customer_id'];
	
		$sql = "DELETE FROM customer WHERE customer_id=$customer_id LIMIT 1";
		if($database->query($sql)) {
			$sql = "DELETE FROM orders WHERE customer_id=$customer_id";
			if($database->query($sql)) {
				redirect_to("customer_list.php");	
			}
		} else {
		echo "Record can not be deleted, please try again. <br />";
		echo "To go Back <a href=\"customer_list.php\"> Click Me </a>";
	}			
}
/* ------------------------------------------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from customer_list.php page => Normal Customers
if(isset($_GET['ip_address'])) {
	
	$ip_address = $_GET['ip_address'];
	
		$sql = "DELETE FROM orders WHERE ip_address='$ip_address' LIMIT 1";
		if($database->query($sql)) {
			redirect_to("customer_list.php");
		} else {
		echo "Record can not be deleted, please try again. <br />";
		echo "To go Back <a href=\"customer_list.php\"> Click Me </a>";
	}			
}
/* ------------------------------------------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from customer_list.php page => PayPal Customers
if(isset($_GET['paypal_id'])) {
	
	$paypal_id = $_GET['paypal_id'];
	
		$sql = "DELETE FROM paypal_checkout WHERE paypal_id=$paypal_id LIMIT 1";
		if($database->query($sql)) {
			redirect_to("customer_list.php");
		} else {
		echo "Record can not be deleted, please try again. <br />";
		echo "To go Back <a href=\"customer_list.php\"> Click Me </a>";
	}			
}
/* ------------------------------------------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from user_category.php page
if(isset($_GET['user_category_id'])) {
	
	$category_id = $_GET['user_category_id'];
	
	$sql = "DELETE FROM user_group WHERE id=$category_id LIMIT 1";
	
	if($database->query($sql)) {
		redirect_to("user_category.php");	
	} else {
		echo "Record can not be deleted, please try again. <br />";
		echo "To go Back <a href=\"user_category.php\"> Click Me </a>";
	}	
}
/* ------------------------------------------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------------------------------------- */
// Delete records from user_category.php page
if(isset($_GET['user_id'])) {
	
	$user_id = $_GET['user_id'];
	
	$sql = "DELETE FROM user WHERE id=$user_id LIMIT 1";
	
	if($database->query($sql)) {
		redirect_to("user_list.php");	
	} else {
		echo "Record can not be deleted, please try again. <br />";
		echo "To go Back <a href=\"user_list.php\"> Click Me </a>";
	}	
}
/* ------------------------------------------------------------------------------------------------------------- */


?>