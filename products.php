<?php include 'includes/header.php'; 
	global $database;
?>
<?php
	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
	// 2. records per page ($per_page)
	$per_page = 9;
	
	if(isset($_GET['sub_cat_id'])) {
	// 3. total record count ($total_count)
	$sql = "SELECT COUNT(*) AS total FROM product WHERE product_sub_category={$_GET['sub_cat_id']}";
	$tot_count = $database->query($sql);
	$total = $database->fetch_array($tot_count);
	$total_count = $total['total'];
	} else {
	// 3. total record count ($total_count)
	$sql = "SELECT COUNT(*) AS total FROM product";
	$tot_count = $database->query($sql);
	$total = $database->fetch_array($tot_count);
	$total_count = $total['total'];
	}
	
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
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
					
                    <!-- Product Categories -->
                    <?php include 'includes/categories_panel.php'; ?>
                    <!-- End Product Catregories -->
						
					<!-- Product Brands -->
                    <?php include 'includes/brands_panel.php'; ?>
                    <!-- End Product Brands -->
						
						<div class="shipping text-center"><!--shipping-->
							<img src="images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
					
					</div>
				</div>
				<?php if(isset($_GET['category_id'])) { ?>
                	<?php
						$query = "SELECT COUNT(*) AS total FROM product WHERE product_category=".$_GET['category_id'];
						$query_result = $database->query($query);
						$total = $database->fetch_array($query_result);
						if($total['total'] > 0) {
						if($pagination->total_pages() > 1) {
								
                    	//echo '<div class="row">';
                		echo '<div class="col-sm-6">';
                        	echo '<ul class="pagination">';
							// To show the Previous Page button if it exists
							if($pagination->has_previous_page()) {
								echo " <li><a href=\"products.php?category_id={$_GET['category_id']}&page=";
								echo $pagination->previous_page();
								echo "\">&laquo; Previous</a></li> ";
							} else {
								echo "<li class=\"active\"><a href=\"\">Previous</a></li> ";
							}
							
							for($i=1; $i <= $pagination->total_pages(); $i++) {
								if($i == $page) {
									echo "<li class=\"active\"><a href=\"\">{$i}</a></li>";
								} else {
									echo " <li><a href=\"products.php?category_id={$_GET['category_id']}&page={$i}\">{$i}</a></li> ";
								}
							}
							
							// To show the Next Page button if it exists
							if($pagination->has_next_page()) {
								echo " <li><a href=\"products.php?category_id={$_GET['category_id']}&page=";
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
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
						<?php $sql = "SELECT * FROM product WHERE status='active' AND product_category=" . $_GET['category_id'] . " LIMIT {$per_page} OFFSET {$pagination->offset()}";
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
                    <?php
						if($pagination->total_pages() > 1) {
								
                    	echo '<div class="row">';
                		echo '<div class="col-sm-12">';
                        	echo '<ul class="pagination">';
							// To show the Previous Page button if it exists
							if($pagination->has_previous_page()) {
								echo " <li><a href=\"products.php?category_id={$_GET['category_id']}&page=";
								echo $pagination->previous_page();
								echo "\">&laquo; Previous</a></li> ";
							} else {
								echo "<li class=\"active\"><a href=\"\">Previous</a></li> ";
							}
							
							for($i=1; $i <= $pagination->total_pages(); $i++) {
								if($i == $page) {
									echo "<li class=\"active\"><a href=\"\">{$i}</a></li>";
								} else {
									echo " <li><a href=\"products.php?category_id={$_GET['category_id']}&page={$i}\">{$i}</a></li> ";
								}
							}
							
							// To show the Next Page button if it exists
							if($pagination->has_next_page()) {
								echo " <li><a href=\"products.php?category_id={$_GET['category_id']}&page=";
								echo $pagination->next_page();
								echo "\">Next &raquo;</a></li> ";	
							} else {
								echo "<li class=\"active\"><a href=\"\">Next</a></li> ";
							}
                        	echo '</ul>';
                    	echo '</div>';
                    	echo '</div>';
					}
					?>
                  <?php } else {
								echo "<h3> No product found for this category! :( </h3>";
							} // End Inner IF-ELSE  ?>	
                    
					</div><!--features_items-->
					
				</div>
            <?php } elseif(isset($_GET['sub_cat_id'])) { ?>
            	<?php
						if($pagination->total_pages() > 1) {
								
                    	//echo '<div class="row">';
                		echo '<div class="col-sm-6">';
                        	echo '<ul class="pagination">';
							// To show the Previous Page button if it exists
							if($pagination->has_previous_page()) {
								echo " <li><a href=\"products.php?sub_cat_id={$_GET['sub_cat_id']}&page=";
								echo $pagination->previous_page();
								echo "\">&laquo; Previous</a></li> ";
							} else {
								echo "<li class=\"active\"><a href=\"\">Previous</a></li> ";
							}
							
							for($i=1; $i <= $pagination->total_pages(); $i++) {
								if($i == $page) {
									echo "<li class=\"active\"><a href=\"\">{$i}</a></li>";
								} else {
									echo " <li><a href=\"products.php?sub_cat_id={$_GET['sub_cat_id']}&page={$i}\">{$i}</a></li> ";
								}
							}
							
							// To show the Next Page button if it exists
							if($pagination->has_next_page()) {
								echo " <li><a href=\"products.php?sub_cat_id={$_GET['sub_cat_id']}&page=";
								echo $pagination->next_page();
								echo "\">Next &raquo;</a></li> ";	
							} else {
								echo "<li class=\"active\"><a href=\"\">Next</a></li> ";
							}
                        	echo '</ul>';
                    	echo '</div>';
                    	//echo '</div>';
					}
					?>
			<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
						<?php $sql = "SELECT * FROM product WHERE status='active' AND product_sub_category=" . $_GET['sub_cat_id'] . " LIMIT {$per_page} OFFSET {$pagination->offset()}";
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
                                        
                    <?php
						if($pagination->total_pages() > 1) {
								
                    	echo '<div class="row">';
                		echo '<div class="col-sm-12">';
                        	echo '<ul class="pagination">';
							// To show the Previous Page button if it exists
							if($pagination->has_previous_page()) {
								echo " <li><a href=\"products.php?sub_cat_id={$_GET['sub_cat_id']}&page=";
								echo $pagination->previous_page();
								echo "\">&laquo; Previous</a></li> ";
							} else {
								echo "<li class=\"active\"><a href=\"\">Previous</a></li> ";
							}
							
							for($i=1; $i <= $pagination->total_pages(); $i++) {
								if($i == $page) {
									echo "<li class=\"active\"><a href=\"\">{$i}</a></li>";
								} else {
									echo " <li><a href=\"products.php?sub_cat_id={$_GET['sub_cat_id']}&page={$i}\">{$i}</a></li> ";
								}
							}
							
							// To show the Next Page button if it exists
							if($pagination->has_next_page()) {
								echo " <li><a href=\"products.php?sub_cat_id={$_GET['sub_cat_id']}&page=";
								echo $pagination->next_page();
								echo "\">Next &raquo;</a></li> ";	
							} else {
								echo "<li class=\"active\"><a href=\"\">Next</a></li> ";
							}
                        	echo '</ul>';
                    	echo '</div>';
                    	echo '</div>';
					}
					?>
                  <?php
							} else {
								echo "<h3> No product found for this category! :( </h3>";
							} // End Inner IF-ELSE  ?>	
					</div><!--features_items-->
					
				</div>
			<?php } else { ?>
            	<h3> No product found! :( </h3>
            <?php } // END Outer IF-ELSE ?>
			</div>
		</div>
	</section>
    
<?php include 'includes/footer.php'; ?>