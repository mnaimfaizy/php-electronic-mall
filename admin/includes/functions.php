<?php
/**
 *
 * This document is all for the functions used in the project
 * There are many useful functions that can help reduce the redundancy
 *
 */
function strip_zeros_from_date($maked_string="") {
	// first remove the marked zeros
	$no_zeros = str_replace('*0','', $maked_string);
	// then remove any remaining marks
	$cleaned_string = str_replace('*','', $no_zeros);
	return $cleaned_string;
}

function redirect_to( $location = NULL) {
	if($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}

function output_message($message="") {
	if(!empty($message)) {
		return "<p class=\"message\">{$message}</p>";
	} else {
		return "";
	}
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
	$path = "LIB_PATH.DS.{$class_name}.php";
	if(file_exists($path)) {
		require_once($path);
	} else {
		die("The file {$class_name}.php could not be found.");
	}

}

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
	if($handle = fopen($logfile, 'a')) { // append
		$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message} \n";
		fwrite($handle, $content);
		fclose($handle);
		if($new) { chmod($logile, 0755); }
	} else {
		echo "Could not open log file for writing.";
	}
}

function datetime_to_text($datetime="") {
	$unixdatetime = strtotime($datetime);
	return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function get_page_name() {
	return basename($_SERVER['PHP_SELF']);
}

// TODO: Modify this function to be less redundent 
function breadcrumb() {
    $page_name = get_page_name();
	$output = '';
		if($page_name == 'index.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '</li>';
    } else if($page_name == 'new_user.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="new_user.php">Users</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>New User</li>';
    } else if($page_name == 'user_list.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="new_user.php">Users</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>User List</li>';
    } else if($page_name == 'user_category.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="new_user.php">Users</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>User Category</li>';
    } else if($page_name == 'product_category.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="product.php">Product</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>Product Category</li>';
    } else if($page_name == 'product_sub_category.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="product.php">Product</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>Product Sub-Category</li>';
    } else if($page_name == 'brand.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="product.php">Product</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>Product Brand</li>';
    } else if($page_name == 'product.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li> Product </li>';
    } else if($page_name == 'product_list.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="product.php">Product</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>Products List</li>';
    } else if($page_name == 'shipping.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="product.php">Product</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>Product Shipment</li>';
    } else if($page_name == 'order_detail.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="orders.php">Orders</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>Order Detail</li>';
    } else if($page_name == 'orders.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>Orders';
    $output .= '</i>';
    } else if($page_name == 'customer_list.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>Customers List</li>';
    } else if($page_name == 'user_profile.php') {
    $output  = '<li>';
    $output .= '<i class="icon-home"></i>';
    $output .= '<a href="index.php">Home</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>';
    $output .= '<a href="user_list.php">Users</a>';
    $output .= '<i class="icon-angle-right"></i>';
    $output .= '</li>';
    $output .= '<li>User Profile</li>';
    } else {
		// Something else
	}
	return $output;
}

// Get IP Address of the client
function getIP() {
	$ip = $_SERVER['REMOTE_ADDR'];

	if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	return $ip;
}

?>
