<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<form class="sidebar-search">
						<div class="input-box">
							<a href="javascript:;" class="remove"></a>
							<input type="text" placeholder="Search..." />				
							<input type="button" class="submit" value=" " />
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
                <?php if($page_name == 'index.php') { ?>
				<li class="active ">
                <?php } else {?>
                <li>
                <?php } ?>
					<a href="index.php">
					<i class="icon-home"></i> 
					<span class="title">Dashboard</span>
					</a>
				</li>
                <?php if($page_name == 'customer_list.php') { ?>
				<li class="active">
                <?php } else { ?>
                <li>
                <?php } ?>
					<a href="customer_list.php">
					<i class="icon-bookmark-empty"></i> 
					<span class="title">Customers</span>
					</a>
				</li>
				<?php if($page_name == 'product_category.php' || 
						$page_name == 'product_sub_category.php' || 
						$page_name == 'brand.php' || 
						$page_name == 'product.php' || 
						$page_name == 'product_list.php' ||
						$page_name == 'shipping.php') { ?>
				<li class="active has-sub ">
                <?php } else { ?>
                <li class="has-sub ">
                <?php } ?>
					<a href="#">
					<i class="icon-table"></i> 
					<span class="title">Product</span>
					<?php if($page_name == 'product_category.php' || 
							$page_name == 'product_sub_category.php' || 
							$page_name == 'brand.php' || 
							$page_name == 'product.php' || 
							$page_name == 'product_list.php' ||
							$page_name == 'shipping.php') { ?>
					<span class="selected"></span>
                    <span class="arrow open"></span>
                    <?php } else { ?>
                    <span class="arrow "></span>
                    <?php } ?>
					</a>
					<ul class="sub">
						<li <?php if($page_name == 'product.php') { echo 'class="active"'; } ?>>
                        <a href="product.php">Add Product</a></li>
						<li <?php if($page_name == 'product_list.php') { echo 'class="active"'; } ?>>
                        <a href="product_list.php">Product List</a></li>
                        <li <?php if($page_name == 'product_category.php') { echo 'class="active"'; } ?>>
                        <a href="product_category.php">Product Category</a></li>
                        <li <?php if($page_name == 'product_sub_category.php') { echo 'class="active"'; } ?>>
                        <a href="product_sub_category.php">Sub Category</a></li>
                        <li <?php if($page_name == 'brand.php') { echo 'class="active"'; } ?>>
                        <a href="brand.php">Brand</a></li>
                        <li <?php if($page_name == 'shipping.php') { echo 'class="active"'; } ?>>
                        <a href="shipping.php">Shipment</a></li>
					</ul>
				</li>
				<?php if($page_name == 'orders.php' || $page_name == 'order_detail.php') { ?>
				<li class="active ">
                <?php } else { ?>
                <li>
                <?php } ?>
					<a href="orders.php">
					<i class="icon-user"></i> 
					<span class="title"> Orders</span>
					</a>
				</li>
                <?php if($page_name == 'new_user.php' ||
						$page_name == 'user_list.php' ||
						$page_name == 'user_category.php') { ?>
				<li class="active has-sub ">
                <?php } else { ?>
                <li class="has-sub ">
                <?php } ?>
					<a href="#">
					<i class="icon-map-marker"></i> 
					<span class="title">Users</span>
					<?php if($page_name == 'new_user.php' ||
						$page_name == 'user_list.php' ||
						$page_name == 'user_category.php') { ?>
					<span class="selected"></span>
                    <span class="arrow open"></span>
                    <?php } else { ?>
                    <span class="arrow "></span>
                    <?php } ?>
					</a>
					<ul class="sub">
						<li <?php if($page_name == 'new_user.php') { echo 'class="active"'; } ?>>
                        <a href="new_user.php">New User</a></li>
                        <li <?php if($page_name == 'user_list.php') { echo 'class="active"'; } ?>>
                        <a href="user_list.php">Users List</a></li>
                        <li <?php if($page_name == 'user_category.php') { echo 'class="active"'; } ?>>
                        <a href="user_category.php">User Category</a></li>
					</ul>
				</li>
				<li>
					<a href="logout.php">
					<i class="icon-user"></i> 
					<span class="title">Log Out</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
		<!-- END SIDEBAR -->