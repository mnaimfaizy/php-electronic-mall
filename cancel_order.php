<?php include 'includes/header.php'; ?>
<?php 
		unset($_SESSION['cart_array']);
		unset($_SESSION['shipping_cost']);
		unset($_SESSION['delivery_time']);
?>
	<?php include 'includes/navigation.php'; ?>
	<div class="container">
        <div class="row">
            <div class="col-sm-12">
            <?php require('includes/breadcrumb.php'); ?>
            </div>
        </div>
        
        <div class="row">
        <div class="jumbotron">
                	<h1> What Happend !</h1> 
                    <p> Dear customer we don't understand what went wrong that you canceled your order. <br />
                    If there is any problem please <a href="contact_us.php"> contact us </a> imediatly to solve the problem. </p>
                    <p> We don't like loosing our customers. </p>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php'; ?>