<?php include 'includes/header.php'; ?>
	
	<?php include 'includes/navigation.php'; ?>
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						
                        <ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
                            <li data-target="#slider-carousel" data-slide-to="3"></li>
                            <li data-target="#slider-carousel" data-slide-to="4"></li>
						</ol>
						<div class="carousel-inner">
                                                
						<?php $sql="SELECT * FROM product WHERE status='active' AND slider='slide' ORDER BY product_id LIMIT 5";
						$result = $database->query($sql);
						while($product_result = $database->fetch_array($result)) { ?>
                        	<?php if($product_result['product_id'] == 5) { ?>
                            <div class="item active">
                            <?php } else { ?>
                            <div class="item">
                            <?php } ?>
                            
								<div class="col-sm-6">
									<h2><?php echo $product_result['product_name']; ?></h2>
									<p><?php 
										$string = strip_tags($product_result['details']);
										if(strlen($string) > 200) {
											$stringCut = substr($string, 0, 200);
											$string = substr($stringCut, 0, strrpos($stringCut, ' '));	
										}
				echo $string . "... <br /><a href=\"product_detail.php?product_id={$product_result['product_id']}\">Read More</a>";
									?> </p>
                <form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_result['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default get" >
                        <i class="fa fa-shopping-cart"></i> &nbsp; Get it now
                    </button>
                </form>
								</div>
								<div class="col-sm-6">
									<img src="images/product_images/
						<?php
						$ress = $database->query("SELECT image_name FROM images WHERE product_id=" . $product_result['product_id'] . " LIMIT 1"); 
							$image_name = $database->fetch_array($ress);
							echo $image_name['image_name'];
						?>" class="girl img-responsive" alt="" style="width:484px; height:441px;" />
								</div>
							</div>
						<?php } ?>
                        
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
    
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
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
                        
                   	<?php $sql = "SELECT * FROM product WHERE status='active' ORDER BY RAND() DESC LIMIT 12";
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
                           <img src="images/product_images/<?php echo $imageName; ?>" alt="<?php echo $row['product_name']; ?>" height="245" />
											<h2>$<?php echo $row['price']; ?></h2>
											<p><?php echo(substr($row['product_name'], 0, 35)); ?></p>
										
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
										<li><a href="product_detail.php?product_id=<?php echo $row['product_id']; ?>"><i class="fa fa-search-plus"></i>View Details</a></li>
									</ul>
								</div>
							</div>
						</div>
					<?php }
							} else {
								echo "<h3> No product found! :( </h3>";
							}
					?>	
					</div><!--features_items-->
					
					<div class="category-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#computers" data-toggle="tab">Computers</a></li>
								<li><a href="#tv" data-toggle="tab">TV &amp; Video</a></li>
								<li><a href="#cell" data-toggle="tab">Cell Phones</a></li>
								<li><a href="#camera" data-toggle="tab">Cameras</a></li>
								<li><a href="#men" data-toggle="tab">Men's Clothing</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="computers" >
								<?php $computerResult = $database->query("SELECT * FROM product WHERE product_category=1 AND status='active' ORDER BY RAND() LIMIT 4");
								while($computers = $database->fetch_array($computerResult)) { 
								$productID = $computers['product_id'];
								$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
								$image1 = $database->fetch_array($resss);
								$imageName = $image1['image_name'];
								?>	
                                <div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/product_images/<?php echo $imageName; ?>" width="184" height="162" alt="" />
												<h2>$<?php echo $computers['price']; ?></h2>
												<p><?php echo $computers['product_name']; ?></p>
												<form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $computers['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default add-to-cart" >
                        <i class="fa fa-shopping-cart"></i>Add to cart
                    </button>
                	</form>
											</div>
											
										</div>
									</div>
								</div>
                            <?php } ?>
							</div>
							
							<div class="tab-pane fade" id="tv" >
								<?php $computerResult = $database->query("SELECT * FROM product WHERE product_category=3 AND status='active' ORDER BY RAND() LIMIT 4");
								while($computers = $database->fetch_array($computerResult)) { 
								$productID = $computers['product_id'];
								$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
								$image1 = $database->fetch_array($resss);
								$imageName = $image1['image_name'];
								?>	
                                <div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/product_images/<?php echo $imageName; ?>" width="184" height="162" alt="" />
												<h2>$<?php echo $computers['price']; ?></h2>
												<p><?php echo $computers['product_name']; ?></p>
												<form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $computers['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default add-to-cart" >
                        <i class="fa fa-shopping-cart"></i>Add to cart
                    </button>
                	</form>
											</div>
											
										</div>
									</div>
								</div>
                            <?php } ?>
							</div>
							
							<div class="tab-pane fade" id="cell" >
                            	<?php $computerResult = $database->query("SELECT * FROM product WHERE product_category=4 AND status='active' ORDER BY RAND() LIMIT 4");
								while($computers = $database->fetch_array($computerResult)) { 
								$productID = $computers['product_id'];
								$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
								$image1 = $database->fetch_array($resss);
								$imageName = $image1['image_name'];
								?>	
                                <div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/product_images/<?php echo $imageName; ?>" width="184" height="162" alt="" />
												<h2>$<?php echo $computers['price']; ?></h2>
												<p><?php echo $computers['product_name']; ?></p>
												<form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $computers['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default add-to-cart" >
                        <i class="fa fa-shopping-cart"></i>Add to cart
                    </button>
                	</form>
											</div>
											
										</div>
									</div>
								</div>
                            <?php } ?>
							</div>
							
							<div class="tab-pane fade" id="camera" >
                            	<?php $computerResult = $database->query("SELECT * FROM product WHERE product_category=6 AND status='active' ORDER BY RAND() LIMIT 4");
								while($computers = $database->fetch_array($computerResult)) { 
								$productID = $computers['product_id'];
								$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
								$image1 = $database->fetch_array($resss);
								$imageName = $image1['image_name'];
								?>	
                                <div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/product_images/<?php echo $imageName; ?>" width="184" height="162" alt="" />
												<h2>$<?php echo $computers['price']; ?></h2>
												<p><?php echo $computers['product_name']; ?></p>
												<form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $computers['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default add-to-cart" >
                        <i class="fa fa-shopping-cart"></i>Add to cart
                    </button>
                	</form>
											</div>
											
										</div>
									</div>
								</div>
                            <?php } ?>
							</div>
							
							<div class="tab-pane fade" id="men" >
                            	<?php $computerResult = $database->query("SELECT * FROM product WHERE product_category=10 AND status='active' ORDER BY RAND() LIMIT 4");
								while($computers = $database->fetch_array($computerResult)) { 
								$productID = $computers['product_id'];
								$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
								$image1 = $database->fetch_array($resss);
								$imageName = $image1['image_name'];
								?>	
                                <div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/product_images/<?php echo $imageName; ?>" width="184" height="162" alt="" />
												<h2>$<?php echo $computers['price']; ?></h2>
												<p><?php echo $computers['product_name']; ?></p>
												<form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $computers['product_id']; ?>" />
                    <button type="submit" name="submit" id="submit" class="btn btn-default add-to-cart" >
                        <i class="fa fa-shopping-cart"></i>Add to cart
                    </button>
                	</form>
											</div>
											
										</div>
									</div>
								</div>
                            <?php } ?>
							</div>
						</div>
					</div><!--/category-tab-->
					
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
                       	<?php $computerResult = $database->query("SELECT * FROM product WHERE status='active' ORDER BY RAND() DESC LIMIT 3");
								while($row = $database->fetch_array($computerResult)) { 
								$productID = $row['product_id'];
								$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
								$image1 = $database->fetch_array($resss);
								$imageName = $image1['image_name'];
								?>	
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="images/product_images/<?php echo $imageName; ?>" width="200" height="118" alt="" />
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
									</div>
                              <?php } ?>
								</div>
								<div class="item">	
                           <?php $computerResult = $database->query("SELECT * FROM product WHERE status='active' ORDER BY RAND() ASC LIMIT 3");
								while($row = $database->fetch_array($computerResult)) { 
								$productID = $row['product_id'];
								$resss = $database->query("SELECT image_name FROM images WHERE product_id=$productID LIMIT 1"); 
								$image1 = $database->fetch_array($resss);
								$imageName = $image1['image_name'];
								?>	
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="images/product_images/<?php echo $imageName; ?>" width="200" height="118" alt="" />
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
									</div>
                              <?php } ?>
								</div>
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
					
				</div>
			</div>
		</div>
	</section>
	
    <!-- Popup contents -->
        
        <div id="boxes">
            <div style="top: 199.5px; left: 551.5px; display: none;" id="dialog" class="window">
            <a style="text-align: right;" href="#" class="close">Exit</a><br />
            <h2>Dear Viewers,</h2> 
            <p>please be noted that this is not a real shopping website where you guys can buy products.<br />
                But you can visit it and see how the structure of the website is, and actully this is my final year's project which I am going to submit.<br /><br />
                Thank You so much.
            </p>
            
            </div>
            <!-- Mask to cover the whole screen -->
            <div style="width: 1478px; height: 602px; display: none; opacity: 0.8;" id="mask"></div>
        </div>
        
        <!-- End Popup -->
    
<?php include 'includes/footer.php'; ?>