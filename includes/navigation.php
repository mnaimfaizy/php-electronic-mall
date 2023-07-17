<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-5">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" class="active">Home</a></li>
								<li class="dropdown"><a href="#">Products<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                    <?php
										$sql = "SELECT * FROM product_category WHERE status='active' ORDER BY RAND() LIMIT 5";
										$result = $database->query($sql);
										while($category = $database->fetch_array($result)) {
									?>
                                        <li><a href="products.php?category_id=<?php echo $category['category_id']; ?>">
										<?php echo $category['category_name']; ?></a></li>
                                    <?php } ?>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#">Brands<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                    <?php
										$sql = "SELECT * FROM brand WHERE status='active' ORDER BY RAND() LIMIT 5";
										$result = $database->query($sql);
										while($category = $database->fetch_array($result)) {
									?>
                                        <li><a href="brands.php?brand_id=<?php echo $category['brand_id']; ?>">
										<?php echo $category['brand_name']; ?></a></li>
                                    <?php } ?>
                                    </ul>
                                </li> 
								<li><a href="contact_us.php">Contact Us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="search_box pull-right">
						<input type="text" name="searchQuery" id="searchQuery" placeholder="Search Products here..."/>
                        <a href="advance_search.php"> Advance Search </a>
                        </div>
                        
					</div>
                    <div class="col-sm-3">
                    <div class="pull-right">
                           <!-- Shopping cart button -->
                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cart" style="margin-top: 0px;">
                            <i class="fa fa-shopping-cart"></i> &nbsp; &nbsp; Shopping Cart: item
                            <?php if(isset($_SESSION['cart_array']) && is_array($_SESSION['cart_array']) && count(@$_SESSION['cart_array']) >= 1) {
								echo "( " . count($_SESSION['cart_array']) . " )";
							} else {
								echo '( 0 )';
							}
							?> 
                           </button>
                           
                           <!-- Shopping cart body / Modal -->
                          <div class="modal fade" id="cart" tabindex="-1" role="dialog">
                          	<div class="modal-dialog">
                            	<div class="modal-content">
                                	<div class="modal-header">
                                    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-tittle">Your Cart</h4>
                                    </div>
                                    <div class="modal-body">
<?php
$Output = "";
$cartTotal = 0;
if(!isset($_SESSION['cart_array']) || count(@$_SESSION['cart_array']) < 1) {
	echo "<h2 align='center'> Your shopping cart is empty</h2>";	
} else {
	$i = 0;
	foreach($_SESSION['cart_array'] as $each_item) {
		$i++;
		$item_id = $each_item['item_id'];
		$sql = $database->query("SELECT * FROM product WHERE product_id=$item_id LIMIT 1");
		while($row = $database->fetch_array($sql)) {
			$product_id = $row['product_id'];
			$product_name = $row['product_name'];
			$price = $row['price'];
			// Get image of product
			$resss = $database->query("SELECT image_name FROM images WHERE product_id=$product_id LIMIT 1"); 
			$image1 = $database->fetch_array($resss);
			$imageName = $image1['image_name'];
		}
		$pricetotal = $price * $each_item['quantity'];
		$cartTotal = $pricetotal + $cartTotal;
		
		$Output .= '<p> 
						<span> ';
		$Output .= '<img src="images/product_images/'. $imageName .'" width="50" height="50" style="padding: 3px; border: 1px solid #3E3E3E;" /> </span>';
		$Output .= '<span style="color: #FF4700; padding-left: 10px; font-size: 16px;">Product: </span>';
		$Output .= '<strong>'. $product_name .'</strong>
						 &nbsp; &nbsp; | &nbsp; &nbsp;
						<span style="padding-left: 0px; color: #FF4700; font-size: 16px;"> Price: </span>
						<strong> $'. $price .' </strong> ';
		$Output .=	'</p>';						
	}
}
echo $Output;
?>
                        <p class="pull-right">
                            <span style="font-size: 18px; font-weight:bold"> Total: 
                            <?php if(!empty($cartTotal)) { echo "$".$cartTotal; } else { echo "$0"; } ?> </span> 
                        </p>
                                    </div>
                                    
                                    <div class="modal-footer">
                                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                     <a href="cart.php" class="btn btn-primary" style="margin-top: 0px;">Go To Cart</a>
                                    </div>
                                </div>
                            </div>
                          </div>
                     </div>
                    </div>
                    
				</div>
                <!-- Search Result Section -->
                <div id="update">
                	<ul class="searchresults">
                    
                    </ul>
                </div>
                <!-- End Search Result -->
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->