<?php include 'includes/header.php'; ?>
<?php
	global $database;
	if(isset($_POST['submit'])) {
		$name = mysql_real_escape_string($_POST['name']);
		$email = mysql_real_escape_string($_POST['email']);
		$review = mysql_real_escape_string($_POST['review']);
		$rating = mysql_real_escape_string($_POST['rating']);
		$date_added = time();
		$product_id = mysql_real_escape_string($_POST['product_id']);
		$status = 'active';
		
		$query = "INSERT INTO `product_review`
				( `review`, `name`, `email`, `rating`, `date_added`, `product_id`, `status`) 
				VALUES ('$review','$name','$email',$rating,$date_added,$product_id,'$status')";
		if($database->query($query)) {
			$errorMessage = true;
		} else {
			$errorMessage = false;
		}
	}
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
                <?php if(isset($_GET['product_id'])) { ?>
                <?php if(isset($errorMessage)) { 
					if($errorMessage == true) { ?>
                <p style="color:#01780E; font-size: 15px;"> Your review hase been added for the current product. <br>
                Thanks for reviewing :) </p>
                <?php } elseif($errorMessage == false) { ?>
				<p style="color:#CF0003; font-size: 15px;"> We could not add your review for this product. <br>
                Please try again :( </p>
                <?php } } ?>
                <?php $sql = "SELECT * FROM product WHERE status='active' AND product_id=" . $_GET['product_id'] . " LIMIT 1";
						$thisResult = $database->query($sql);
						if(mysqli_num_rows($thisResult) > 0) {
						$row = $database->fetch_array($thisResult);
						$productID = $row['product_id'];
						$resss = $database->query("SELECT * FROM images WHERE product_id=$productID LIMIT 1"); 
						$image1 = $database->fetch_array($resss);
						$imageName = $image1['image_name'];
					?>	
                <div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
                            <a class="test-popup-link" href="images/product_images/<?php echo $imageName; ?>">
								<img src="images/product_images/<?php echo $imageName; ?>" alt="<?php echo $row['product_name']; ?>" />
                                </a>
								<h3>ZOOM</h3>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
                                <div class="item active">
                                <?php $resss = $database->query("SELECT * FROM images WHERE product_id=$productID LIMIT 3"); 
                                while($images = $database->fetch_array($resss)) { 
                                ?>
                                 <a class="gallery-item" href="images/product_images/<?php echo $images['image_name']; ?>">
                                 <img src="images/product_images/<?php echo $images['image_name']; ?>" alt="" width="85" height="84" />
                                 </a>
                                  
                                <?php } ?>	</div>
                        
									</div>

								  <!-- Controls -->
								  <!--<a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>-->
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
                            <?php if(strtolower($row['condition']) == 'new') { ?> 
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
                           	<?php } ?>
								<h2><?php echo $row['product_name']; ?></h2>
								<p>Web ID: <?php echo $row['product_id']; ?></p>
								<span>
									<span>US $<?php echo $row['price']; ?></span>
									<span>
									<form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $row['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default add-to-cart" >
                        <i class="fa fa-shopping-cart"></i>Add to cart
                    </button>
                	</form>
                                    </span>
								</span>
								<p><b>Availability:</b> In Stock</p>
								<p><b>Condition:</b> <?php echo $row['condition']; ?></p>
								<p><b>Brand:</b> 
								<?php $query = $database->query("SELECT brand_name FROM brand WHERE " . $brand_id=$row['brand'] . " LIMIT 1"); 
								$brand = $database->fetch_array($query);
								if(isset($brand) && !empty($brand)) {
									echo $brand['brand_name'];
								} else {
									echo "No Brand";
								}
								?></p>
								<a href="#"><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
                    
                    <div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li><a href="#details" data-toggle="tab">Details</a></li>
								<li class="active"><a href="#reviews" data-toggle="tab">Reviews 
                                <?php $product_id = $_GET['product_id']; 
								$totalReview = $database->query("SELECT COUNT(*) AS total FROM product_review WHERE product_id=$product_id");
								$total = $database->fetch_array($totalReview);
								if($total['total'] > 0) {
									echo "(". $total['total'] .")";
								} else {
									echo "(0)";
								}
								?>
								</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="details" >
								<div class="col-sm-12">
									<?php echo $row['details']; ?>
								</div>
							</div>
							
							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
                           <?php $sql = "SELECT * FROM product_review WHERE product_id=" . $_GET['product_id'] . " AND status='active' ORDER BY review_id DESC LIMIT 3";
						   $reviewResult = $database->query($sql);
						   while($review = $database->fetch_array($reviewResult)) { ?>
									<ul>
										<li><a href=""><i class="fa fa-user"></i><?php echo $review['name']; ?></a></li>
										<li><a href=""><i class="fa fa-clock-o"></i><?php echo date("h:i A", $review['date_added']); ?></a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i><?php echo date("d M Y", $review['date_added']); ?></a></li>
                                        <li class="pull-right">
                                        	
                                        <?php if($review['rating'] == 1) { ?>
                                        	<span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                        <?php } elseif($review['rating'] == 2) { ?>
                                        	<span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                        <?php } elseif($review['rating'] == 3) { ?>
                                        	<span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                        <?php } elseif($review['rating'] == 4) { ?>
                                        	<span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star-o" style="display:inline"></span>
                                        <?php } elseif($review['rating'] == 5) { ?>
                                        	<span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                            <span class="fa fa-star" style="display:inline"></span>
                                        <?php } ?>
                                       </li>
									</ul>
									<p><?php echo $review['review']; ?></p>
                                    <hr />
							<?php } ?>
                                    <p><b>Write Your Review</b></p>
									
									<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="review_form">
										<span>
											<input type="text" name="name" id="name" placeholder="Your Name"/>
											<input type="email" name="email" id="email" placeholder="Email Address"/>
										</span>
										<textarea name="review" id="review" ></textarea>
                                          
                                        <div class="star-rating" style="width: 200px; float:left;">
                                        Rating:
                                        	<span class="fa fa-star-o" data-rating="1" style="display:inline"></span>
                                            <span class="fa fa-star-o" data-rating="2" style="display:inline"></span>
                                            <span class="fa fa-star-o" data-rating="3" style="display:inline"></span>
                                            <span class="fa fa-star-o" data-rating="4" style="display:inline"></span>
                                            <span class="fa fa-star-o" data-rating="5" style="display:inline"></span>
                                            <input type="hidden" name="rating" class="rating-value" value="2" />
                                        </div>
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>" />
										<button type="submit" name="submit" class="btn btn-default pull-right">
                                        Submit
                                        </button>	
                                </form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->

			<?php } // End Inner IF condition
					} else { ?>
            	<h3> No product found! :( </h3>
            <?php } // END Outer IF-ELSE ?>
			</div>
		</div>
	</section>
<?php include 'includes/footer.php'; ?>