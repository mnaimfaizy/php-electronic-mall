<div class="breadcrumbs">
    <ol class="breadcrumb">
    <?php   
            $page_name = basename($_SERVER['PHP_SELF']);  
                if($page_name == 'index.php') {
            } else if($page_name == 'cart.php') { ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="product.php">products</a></li>
            <li class="active">Shopping Cart</li>
    <?php } elseif($page_name == 'login.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li class="active">Login / Sign Up</li>
    <?php } elseif($page_name == 'contact_us.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li class="active">Conctact Us</li>
    <?php } elseif($page_name == 'brands.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li class="active">Brands</li>
    <?php } elseif($page_name == 'products.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li class="active">Products</li>
    <?php } elseif($page_name == 'product_detail.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li><a href="product.php">Product</a></li>
            <li class="active">Details</li>
    <?php } elseif($page_name == 'all_categories.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li><a href="product.php">Product</a></li>
            <li class="active">All Categories</li>
    <?php } elseif($page_name == 'all_brands.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li><a href="product.php">Product</a></li>
            <li class="active">All Brands</li>
    <?php } elseif($page_name == 'checkout.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li><a href="product.php">Product</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li class="active">Checkout</li>
    <?php } elseif($page_name == 'orders.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li><a href="product.php">Product</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="checkout.php">Checkout</a></li>
            <li class="active">Order Info</li>
    <?php } elseif($page_name == 'advance_search.php') { ?>
    		<li><a href="index.php">Home</a></li>
            <li><a href="product.php">Product</a></li>
            <li class="active">Advance Search</li>
    <?php } ?>
      
    </ol>
</div>