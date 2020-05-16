<?php include 'includes/header.php'; 
	global $database;
?>
<?php
	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
	// 2. records per page ($per_page)
	$per_page = 9;
	
	// 3. total record count ($total_count)
	$sql = "SELECT COUNT(*) AS total FROM product";
	$tot_count = $database->query($sql);
	$total = $database->fetch_array($tot_count);
	$total_count = $total['total'];
	
	$pagination = new Pagination($page, $per_page, $total_count);
?>
	<?php include 'includes/navigation.php'; ?>
	
    <div class="container">
            <div class="row">
                <div class="col-sm-12">
                <?php require('includes/breadcrumb.php'); ?>
                </div>
            </div>
        </div>
    
	<section>
		<div class="container">
        <div class="row" style="margin-bottom: 10px; padding-bottom: 20px; border-bottom: 1px solid #E8E8E8;">
        	<div class="col-md-12">
            	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="search_form" post="GET">
                	<div class="row">
                    <div class="col-md-9">
                    	<input type="text" name="product_name" id="product_name" placeholder="Enter Product's Name" class="form-control" />
                        </div>
                        <div class="col-md-3">
                        <input type="submit" name="search" id="search" value="Search" class="btn btn-primary btn-lg" style="margin-top: -10px;" />
                        </div>
                    </div> <br />
                    <div class="row">
                        <div class="col-md-2">
                            <label for="category"> Categories </label>
                            <select name="category" id="category" class="form-control">
                            <option value="all" selected="selected"> All </option>
                            <?php $sql = "SELECT * FROM product_category WHERE status='active'";
								$category_result = $database->query($sql);
								while($category = $database->fetch_array($category_result)) { ?>
                                <option value="<?php echo $category['category_id']; ?>"> 
                                <?php echo $category['category_name']; ?> </option>
                            <?php } ?>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="sub_category"> Sub-Categories </label>
                            <select name="sub_category" id="sub_category" class="form-control">
                                <option value="all" selected="selected"> All </option>
                            <?php $sql = "SELECT * FROM sub_category WHERE status='active'";
								$sub_category_result = $database->query($sql);
								while($sub_category = $database->fetch_array($sub_category_result)) { ?>
                                <option value="<?php echo $sub_category['sub_cat_id']; ?>"> 
                                <?php echo $sub_category['sub_cat_name']; ?> </option>
                            <?php } ?>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="brands"> Brands </label>
                            <select name="brands" id="brands" class="form-control">
                                <option value="all" selected="selected"> All </option>
                            <?php $sql = "SELECT * FROM brand WHERE status='active'";
								$brand_result = $database->query($sql);
								while($brand = $database->fetch_array($brand_result)) { ?>
                                <option value="<?php echo $brand['brand_id']; ?>"> 
                                <?php echo $brand['brand_name']; ?> </option>
                            <?php } ?>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="condition"> Condition </label>
                            <select name="condition" id="condition" class="form-control">
                                <option value="all"> All </option>
                                <option value="New"> New </option>
                                <option value="Used"> Used </option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="price_range"> Price Range </label>
                            <select name="price_range" id="price_range" class="form-control">
                            <option value="all" selected="selected"> All </option>
                                <option value="100 AND 200"> 100 - 200 </option>
                                <option value="200 AND 300"> 200 - 300 </option>
                                <option value="300 AND 400"> 300 - 400 </option>
                                <option value="400 AND 500"> 400 - 500 </option>
                                <option value="500 AND 1000"> 500 - 1000 </option>
                                <option value="1000 AND 1500"> 1000 - 1500 </option>
                                <option value="1500 AND 2000"> 1500 - 2000 </option>
                                <option value="2000 AND 2500"> 2000 - 2500 </option>
                                <option value="2500 AND 3000"> 2500 - 3000 </option>
                                <option value="3500 AND 4000"> 3500 - 4000 </option>
                                <option value="4000 AND 4500"> 4000 - 4500 </option>
                                <option value="4500 AND 5000"> 4500 - 5000 </option>
                                <option value="5000 AND 5500"> 5000 - 5500 </option>
                            </select>
                        </div>
                     </div>
                </form>
            </div>
            <hr />
            
        </div> <br />
       <?php if(isset($_GET['product_name']) || isset($_GET['category']) 
	   			|| isset($_GET['sub_category']) || isset($_GET['brands']) 
				|| isset($_GET['price_range']) || isset($_GET['condition'])) { ?>
                	<?php
					$query1 = array();
					$query = "SELECT COUNT(*) AS total FROM `product`";
					if($_GET['category'] != 'all' || $_GET['sub_category'] != 'all' || $_GET['brands'] != 'all' || $_GET['condition'] != 'all' || $_GET['price_range'] != 'all') { $query .= " WHERE "; }
					if($_GET['category'] != 'all') {$query1[0] = " product_category=".$_GET['category'];}
					if($_GET['sub_category'] != 'all') {$query1[1] = " product_sub_category=".$_GET['sub_category'];}
					if($_GET['brands'] != 'all') {$query1[2] = " brand=".$_GET['brands'];}
					if($_GET['condition'] != 'all') {$query1[3] = " `condition`='".$_GET['condition']."'";}
					if($_GET['price_range'] != 'all') {$query1[4] = " price BETWEEN ".$_GET['price_range']." ";}
					
// Check all the possibilities for 5 Condition boxes in the search page
if(empty($query1[0]) && empty($query1[1]) && empty($query1[2]) && empty($query1[3]) && empty($query1[4])) {
	/* Do nothing */ }
if(!empty($query1[0]) && empty($query1[1]) && empty($query1[2]) && empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[0]; }
if(empty($query1[0]) && !empty($query1[1]) && empty($query1[2]) && empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[1]; }
if(empty($query1[0]) && empty($query1[1]) && !empty($query1[2]) && empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[2]; }
if(empty($query1[0]) && empty($query1[1]) && empty($query1[2]) && !empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[3]; }
if(empty($query1[0]) && empty($query1[1]) && empty($query1[2]) && empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[4]; }
if(!empty($query1[0]) && !empty($query1[1]) && empty($query1[2]) && empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[1]; }
if(empty($query1[0]) && !empty($query1[1]) && !empty($query1[2]) && empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[1] . ' AND ' . $query1[2]; }
if(empty($query1[0]) && empty($query1[1]) && !empty($query1[2]) && !empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[2] . ' AND ' . $query1[3]; }
if(empty($query1[0]) && empty($query1[1]) && empty($query1[2]) && !empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[3] . ' AND ' . $query1[4]; }
if(!empty($query1[0]) && !empty($query1[1]) && !empty($query1[2]) && empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[1] . ' AND ' . $query1[2]; }
if(empty($query1[0]) && !empty($query1[1]) && !empty($query1[2]) && !empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[1] . ' AND ' . $query1[2] . ' AND ' . $query1[3]; }
if(empty($query1[0]) && empty($query1[1]) && !empty($query1[2]) && !empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[2] . ' AND ' . $query1[3] . ' AND ' . $query1[4]; }
if(!empty($query1[0]) && !empty($query1[1]) && !empty($query1[2]) && !empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[1] . ' AND ' . $query1[2] . ' AND ' . $query1[3]; }
if(empty($query1[0]) && !empty($query1[1]) && !empty($query1[2]) && !empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[1] . ' AND ' . $query1[2] . ' AND ' . $query1[3] . ' AND ' . $query1[4]; }
if(!empty($query1[0]) && !empty($query1[1]) && !empty($query1[2]) && !empty($query1[3]) && !empty($query1[4])) {
$query .= $query1[0] . ' AND ' . $query1[1] . ' AND ' . $query1[2] . ' AND ' . $query1[3] . ' AND ' . $query1[4]; }
if(!empty($query1[0]) && empty($query1[1]) && !empty($query1[2]) && empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[2]; }
if(!empty($query1[0]) && empty($query1[1]) && empty($query1[2]) && !empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[3]; }
if(!empty($query1[0]) && empty($query1[1]) && empty($query1[2]) && empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[4]; }
if(!empty($query1[0]) && empty($query1[1]) && !empty($query1[2]) && !empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[2] . ' AND ' . $query1[3]; }
if(!empty($query1[0]) && empty($query1[1]) && empty($query1[2]) && !empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[3] . ' AND ' . $query1[4]; }
if(!empty($query1[0]) && !empty($query1[1]) && empty($query1[2]) && !empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[1] . ' AND ' . $query1[3]; }
if(!empty($query1[0]) && !empty($query1[1]) && empty($query1[2]) && empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[0] . ' AND ' . $query1[1] . ' AND ' .  $query1[4]; }
if(empty($query1[0]) && !empty($query1[1]) && empty($query1[2]) && !empty($query1[3]) && empty($query1[4])) {
	$query .= $query1[1] . ' AND ' .  $query1[3]; }
if(empty($query1[0]) && !empty($query1[1]) && empty($query1[2]) && empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[1] . ' AND ' . $query1[4]; }
if(empty($query1[0]) && !empty($query1[1]) && empty($query1[2]) && !empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[1] . ' AND ' . $query1[3] . ' AND ' . $query1[4]; }
if(empty($query1[0]) && empty($query1[1]) && !empty($query1[2]) && empty($query1[3]) && !empty($query1[4])) {
	$query .= $query1[2] . ' AND ' . $query1[4]; }
					
					$query .= " ORDER BY `product_id` DESC";
						$query_result = $database->query($query);
						$total = $database->fetch_array($query_result);
						if($total['total'] > 0) {
						if($pagination->total_pages() > 1) {
								
                    	//echo '<div class="row">';
                		echo '<div class="col-sm-6">';
                        	echo '<ul class="pagination">';
							// To show the Previous Page button if it exists
							if($pagination->has_previous_page()) {
								echo " <li><a href=\"advance_search.php?";
								if($_GET['category'] != 'all') { echo "category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&sub_category={$_GET['sub_category']}&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['sub_category'] != 'all') { echo "sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['brands'] != 'all') { echo "brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}"; }
								if($_GET['condition'] != 'all') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								if($_GET['product_name'] == '') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								echo "&page=";
								echo $pagination->previous_page();
								echo "\">&laquo; Previous</a></li> ";
							} else {
								echo "<li class=\"active\"><a href=\"\">Previous</a></li> ";
							}
							
							for($i=1; $i <= $pagination->total_pages(); $i++) {
								'product_name=&search=Search&category=all&sub_category=all&brands=all&price_range=all&condition=New';
								if($i == $page) {
									echo "<li class=\"active\"><a href=\"\">{$i}</a></li>";
								} else {
									echo " <li><a href=\"advance_search.php?";
								if($_GET['category'] != 'all') { echo "category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&sub_category={$_GET['sub_category']}&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['sub_category'] != 'all') { echo "sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['brands'] != 'all') { echo "brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}"; }
								if($_GET['condition'] != 'all') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								if($_GET['product_name'] == '') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								echo "&page={$i}\">{$i}</a></li> ";
								}
							}
							
							// To show the Next Page button if it exists
							if($pagination->has_next_page()) {
								echo " <li><a href=\"advance_search.php?";
								if($_GET['category'] != 'all') { echo "category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&sub_category={$_GET['sub_category']}&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['sub_category'] != 'all') { echo "sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['brands'] != 'all') { echo "brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}"; }
								if($_GET['condition'] != 'all') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								if($_GET['product_name'] == '') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								echo "&page=";
								echo $pagination->next_page();
								echo "\">Next &raquo;</a></li> ";	
							} else {
								echo "<li class=\"active\"><a href=\"\">Next</a></li> ";
							}
                        	echo '</ul>';
                    	echo '</div>';
                    	//echo '</div>';
					} }
					?>
				<div class="col-sm-12 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Search Items</h2>
						
                        <?php
							$query = '';
						$sql = "SELECT * FROM product ";
						$sql .= "WHERE status='active' ";
			if(!empty($_GET['product_name'])) { $sql .= " AND product_name LIKE '%". $_GET['product_name'] ."%' "; }
			if($_GET['category'] != 'all') { $sql .= " AND product_category=". $_GET['category'] ." "; }
			if($_GET['sub_category'] != 'all') { $sql .= " AND product_sub_category=". $_GET['sub_category'] ." "; }
			if($_GET['brands'] != 'all') { $sql .= " AND brand=". $_GET['brands']; }
			if($_GET['condition'] != 'all') { $sql .= " AND `condition`='". $_GET['condition'] ."' "; }
			if($_GET['price_range'] != 'all') { $sql .= " AND `price` BETWEEN ". $_GET['price_range'] ." "; }
						$sql .= " LIMIT {$per_page} OFFSET {$pagination->offset()}";
							$thisResult = $database->query($sql);
							if(mysqli_num_rows($thisResult) > 0) {
							while($row = $database->fetch_array($thisResult)) { 
							$productID = $row['product_id'];
							$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
							$image1 = $database->fetch_array($resss);
							$imageName = $image1['image_name'];
						?>	
                        <div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										
                                        <div class="productinfo text-center">
                           <img src="images/product_images/<?php echo $imageName; ?>" alt="<?php echo $row['product_name']; ?>" style="width:268px; height:249px;" />
											<h2>$<?php echo $row['price']; ?></h2>
											<p><?php echo $row['product_name']; ?></p>
									<form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $row['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default add-to-cart" >
                        <i class="fa fa-shopping-cart"></i>Add to cart
                    </button>
                	</form>
										</div>
                                   
										<div class="product-overlay">
											<div class="overlay-content">
												<h2>$<?php echo $row['price']; ?></h2>
												<p><?php echo $row['product_name']; ?></p>
										<form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $row['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default add-to-cart" >
                        <i class="fa fa-shopping-cart"></i>Add to cart
                    </button>
                	</form>
											</div>
										</div>
                                        
								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<!--<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>-->
										<li><a href="product_detail.php?product_id=<?php echo $row['product_id']; ?>"><i class="fa fa-search-plus"></i>View Details</a></li>
									</ul>
								</div>
							</div>
						</div>
                     
					<?php } // End While Loop ?>
                    <?php if($total['total'] > 0) {
						if($pagination->total_pages() > 1) {
								
                    	echo '<div class="row">';
                		echo '<div class="col-sm-12">';
                        	echo '<ul class="pagination">';
							// To show the Previous Page button if it exists
							if($pagination->has_previous_page()) {
								echo " <li><a href=\"advance_search.php?";
								if($_GET['category'] != 'all') { echo "category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&sub_category={$_GET['sub_category']}&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['sub_category'] != 'all') { echo "sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['brands'] != 'all') { echo "brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}"; }
								if($_GET['condition'] != 'all') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								if($_GET['product_name'] == '') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								echo "&page=";
								echo $pagination->previous_page();
								echo "\">&laquo; Previous</a></li> ";
							} else {
								echo "<li class=\"active\"><a href=\"\">Previous</a></li> ";
							}
							
							for($i=1; $i <= $pagination->total_pages(); $i++) {
								'product_name=&search=Search&category=all&sub_category=all&brands=all&price_range=all&condition=New';
								if($i == $page) {
									echo "<li class=\"active\"><a href=\"\">{$i}</a></li>";
								} else {
									echo " <li><a href=\"advance_search.php?";
								if($_GET['category'] != 'all') { echo "category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&sub_category={$_GET['sub_category']}&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['sub_category'] != 'all') { echo "sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['brands'] != 'all') { echo "brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}"; }
								if($_GET['condition'] != 'all') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								if($_GET['product_name'] == '') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								echo "&page={$i}\">{$i}</a></li> ";
								}
							}
							
							// To show the Next Page button if it exists
							if($pagination->has_next_page()) {
								echo " <li><a href=\"advance_search.php?";
								if($_GET['category'] != 'all') { echo "category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&sub_category={$_GET['sub_category']}&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['sub_category'] != 'all') { echo "sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}&brands={$_GET['brands']}"; }
								if($_GET['brands'] != 'all') { echo "brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}&condition={$_GET['condition']}"; }
								if($_GET['condition'] != 'all') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								if($_GET['product_name'] == '') { echo "condition={$_GET['condition']}&brands={$_GET['brands']}&sub_category={$_GET['sub_category']}&category={$_GET['category']}&product_name={$_GET['product_name']}&search=Search&price_range={$_GET['price_range']}"; }
								echo "&page=";
								echo $pagination->next_page();
								echo "\">Next &raquo;</a></li> ";	
							} else {
								echo "<li class=\"active\"><a href=\"\">Next</a></li> ";
							}
                        	echo '</ul>';
                    	echo '</div>';
                    	echo '</div>';
					} }
					?>
                  <?php } else {
								echo '<div class="row">
            							<div class="jumbotron">
											<h3> No product found Please try again! :( </h3>
										</div>
                					</div>';
							} // End Inner IF-ELSE  ?>	
                    
					</div><!--features_items-->
					
				</div>
			<?php } else { ?>
            	<div class="row">
            	<div class="jumbotron">
                <h3> Search for the product of your choice! :) </h3>
                </div>
                </div>
            <?php } // END Outer IF-ELSE ?>
			</div>
	</section>
    
<?php include 'includes/footer.php'; ?>