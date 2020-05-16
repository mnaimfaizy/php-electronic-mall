<h2>Category</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
        <?php
            $sql = "SELECT * FROM product_category WHERE status='active' LIMIT 10";
            $result = $database->query($sql);
            while($category = $database->fetch_array($result)) {
        ?>	
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#<?php echo $category['category_id']; ?>">
                        <?php  // Find the category name of the selected category
            $sql = "SELECT category_id FROM sub_category WHERE category_id=" . $category['category_id'] . " LIMIT 1";
                $ress = $database->query($sql);
                $category_id = $database->fetch_array($ress);
                if($category['category_id'] == $category_id['category_id']) {
					if(isset($_GET['category_id'])) {
						if($category_id['category_id'] == $_GET['category_id']) { ?>
            			<span class="badge pull-right"><i class="fa fa-minus"></i></span>                        
            	<?php } else { ?>
            			<span class="badge pull-right"><i class="fa fa-plus"></i></span>
				<?php }
					} elseif(!isset($_GET['category_id'])) { ?>
                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
             <?php 	} 
			 	} ?>
                            <?php echo $category['category_name']; ?>
                        </a>
                    </h4>
                </div>
           <?php  // Find the category name of the selected category
            $sql = "SELECT category_id FROM sub_category WHERE category_id=" . $category['category_id'] . " LIMIT 1";
                $ress = $database->query($sql);
                $category_id = $database->fetch_array($ress);
                if($category['category_id'] == $category_id['category_id']) {
            ?>
            <div id="<?php echo $category_id['category_id']; ?>" 
            <?php if(isset($_GET['product_id'])) { 
				$productID = $_GET['product_id'];
				$product = $database->query("SELECT product_category FROM product WHERE product_id=$productID LIMIT 1");
				$products = $database->fetch_array($product);
				$category_ID = $products['product_category'];
				}
				if(!isset($_GET['product_id']) && !isset($_GET['category_id']) && isset($_GET['sub_cat_id'])) {
				$sub_cat_id = $_GET['sub_cat_id'];
				$res = $database->query("SELECT category_id FROM sub_category WHERE sub_cat_id=$sub_cat_id LIMIT 1");
				$ress = $database->fetch_array($res);
				$category_ID = $ress['category_id'];	
				}
				if(isset($_GET['category_id'])) {
					$category_ID = $_GET['category_id'];	
				}
				
			if(!empty($category_ID) && $category_id['category_id'] == $category_ID) { 
            echo 'class="panel-collapse in"';
            } else { 
            echo 'class="panel-collapse collapse"';
            } ?>
            >
            <div class="panel-body">
                    <ul>
           <?php $sql = "SELECT * FROM sub_category WHERE category_id=" . $category['category_id'] ." AND status='active'"; 
                $res = $database->query($sql);
                while($sub_category = $database->fetch_array($res)) {
                    //if($sub_category['category_id'] == $category['category_id']) {
           ?>
                    <?php if(isset($_GET['sub_cat_id'])) {  
					if($sub_category['sub_cat_id'] == $_GET['sub_cat_id']) { ?>
                    <li style="background-color: #FFAD41; padding: 2px 0px 2px 5px;">
                    <?php } else { ?>
                    <li>
                    <?php }
					} else { ?>
                    <li>
                    <?php } ?>
                    <a href="products.php?sub_cat_id=<?php echo $sub_category['sub_cat_id']; ?>">
					<?php echo $sub_category['sub_cat_name']; ?> 
                    </a></li>
                    
                <?php } ?>
                    </ul>
                </div>
                
            </div>
        <?php } ?>
        </div>
        
        <?php } ?>
        <div class="panel-heading">
        <h4 class="panel-title">
            <a href="all_categories.php"> View All Categories </a>
        </h4>
        </div>
        </div><!--/category-products-->