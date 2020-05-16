<?php require_once('../admin/includes/initialize.php'); ?>

<?php 
	global $database;
	if(isset($_POST['query']) === true && empty($_POST['query']) === false) {
		
		$searchQuery = $database->escape_value($_POST['query']);
		$query = "SELECT * FROM product WHERE product_name LIKE '%" . $searchQuery . "%' LIMIT 5";
		$queryResult = $database->query($query);
		if(mysqli_num_rows($queryResult) > 0) {
			while($row = $database->fetch_array($queryResult)) {
				$productID = $row['product_id'];
				$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
				$image1 = $database->fetch_array($resss);
				$imageName = $image1['image_name'];
				//$output = '<ul class="searchresults">';
				$output =	'<a href="product_detail.php?product_id=' . $row['product_id'] . '">';
				$output .=		'<li>';
				$output .=		'<span class="product_image">';
				$output .=		'<img src="images/product_images/' . $imageName . '" alt="Test Product" />';
				$output .=		'</span>'; 
				$output .=		'<span class="product_name">';
				$output .=		'Product Name: <strong>' . $row['product_name'] . '</strong>';
				$output .=		'</span>'; 
						  
				$output .=		'<span class="product_price">';
				$output .=		'| Price: <strong>$' . $row['price'] . '</strong>';
				$output .=		'</span>';
				$output .=		 '</li>';
				$output .=	'</a>';
				//$output .= '</ul>';
				echo $output;
			}
		} else {
			// $output = '<ul class="searchresults">';
			$output = '<li>';
			$output .= '<h2> No product found <i class="fa fa-frown-o"></i> </h2>';
			$output .= '</li>';
			// $output .= '</ul>';
			echo $output;
		}
	}