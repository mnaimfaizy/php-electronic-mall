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
            $sql = "SELECT * FROM product_category WHERE status='active' ORDER BY category_name ASC";
            $result = $database->query($sql);
            while($category = $database->fetch_array($result)) {
        ?>	
				<div class="col-sm-3" style="min-height: 250px;">
					<h3> 
                    	<a style="color: #FE980F;" href="products.php?category_id=<?php echo $category['category_id']; ?>"> 
							<?php echo $category['category_name']; ?> 
                        </a> 
                    </h3>
                    <ul>
                    	<?php $sql = "SELECT * FROM sub_category WHERE category_id=" . $category['category_id'] ." AND status='active'"; 
                $res = $database->query($sql);
                while($sub_category = $database->fetch_array($res)) {
           ?>
                    	<li> 
                            <a style="color: #9C9C9C;" href="products.php?sub_cat_id=<?php echo $sub_category['sub_cat_id']; ?>">
                                <?php echo $sub_category['sub_cat_name']; ?>
                            </a> 
                        </li>
           <?php } ?>
                    </ul>
				</div>
       <?php } ?>
			</div>
         </div>
		</div>
	</section><!--/form-->
    
<?php include 'includes/footer.php'; ?>