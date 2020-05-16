<?php include 'includes/header.php'; ?>
	<?php include 'includes/navigation.php'; ?>
    	<div class="container">
            <div class="row">
                <div class="col-sm-12">
                <?php require('includes/breadcrumb.php'); ?>
                </div>
            </div>
        </div>
		<section><!--form-->
		<div class="container">

			<div class="row">
        <?php
            $sql = "SELECT * FROM brand WHERE status='active' ORDER BY brand_name ASC";
            $result = $database->query($sql);
            while($brand = $database->fetch_array($result)) {
        ?>	
				<div class="col-sm-2">
                	<div class="panel panel-default">
                    <div class="panel-heading">
					<h3 class="panel-title" style="text-align:center;"> 
                    	<a style="color: #FE980F; font-size: 24px !important;" href="products.php?brand_id=<?php echo $brand['brand_id']; ?>"> 
							<?php echo $brand['brand_name']; ?> 
                        </a> 
                        
                    </h3>
                    </div>
                    <div class="panel-body">
                    	<a href="products.php?brand_id=<?php echo $brand['brand_id']; ?>">
                    	<img src="images/brands/<?php echo $brand['brand_image']; ?>" class="img-responsive img-circle" alt="<?php echo $brand['brand_name']; ?>" style="padding: 3px; border: 1px solid #D7D7D7;" /> </a>
                    </div>
                    </div>
					</div>
       <?php } ?>
			</div>
         </div>
		</div>
	</section><!--/form-->
    <hr />
<?php include 'includes/footer.php'; ?>