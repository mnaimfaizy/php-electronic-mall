<div class="brands_products"><!--brands_products-->
    <h2>Brands</h2>
    <div class="brands-name">
        <ul class="nav nav-pills nav-stacked">
    <?php $sql = "SELECT * FROM brand ORDER BY brand_name ASC LIMIT 10";
        $result = $database->query($sql);
        while($brand = $database->fetch_array($result)) { 
		if(isset($_GET['brand_id'])) {
		if($brand['brand_id'] == $_GET['brand_id']) {
		?>
        <li style="border: 1px solid #FFAD41;">
        <?php } else { ?>
        <li>
        <?php }
		} else { ?>
        <li>
        <?php } ?>
        <a href="brands.php?brand_id=<?php echo $brand['brand_id']; ?>"> <span class="pull-right">
        <?php $sql = "SELECT COUNT(*) AS total FROM product WHERE brand=". $brand['brand_id'];
            $resultCount = $database->query($sql);
            $resultCount = $database->fetch_array($resultCount);
            echo "(".$resultCount['total'].")"; ?>
        </span><?php echo $brand['brand_name']; ?></a></li>
    <?php } ?>
    	<li style=" font-weight: bold;"> <span><a href="all_brands.php">View All Brands</a></span></li>
        </ul>
    </div>
</div><!--/brands_products-->