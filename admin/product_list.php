<?php include_once("includes/header.php"); ?>
<?php
	global $database;

	// Insert Image Information to images table	for products
	if(isset($_POST['submit'])) {
		$product_ID = trim($_POST['productID']);
		$product_Name = trim($_POST['productName']);
		if(isset($_FILES['product_image'])) {
			$file = 		$_FILES['product_image'];
			$temp_path		= $file['tmp_name'];
			$filename		= basename($file['name']);
			$type			= $file['type'];
			$size			= $file['size'];
			
			// Determine the target Path
			$target_path = '../images/product_images/'.$filename;
			if(file_exists($target_path)) {
				echo "The file {$filename} already exists.";
			}
			
			// Attempt to move the file
			if(move_uploaded_file($temp_path, $target_path)) {
				// Success	
				// Save a corresponding entry to the database\
					$sql = "INSERT INTO images(image_name, size, type, caption, product_id) VALUES('$filename', '$size', '$type', '$product_name', '$product_ID')";
					if($database->query($sql)) {
						redirect_to("product_list.php");
						// $result = true;	
					} else {
						// File was not moved
						$result = false;
					}	
			}
		}
		
	}

?>
<script>
	function conf(id) {
		var value = window.confirm("Are you sure! You want to delete selected Item?");
		if(value == true) {
			window.location = "delete.php?product_id="+id;
		} else { 
			// Do something else
		}
	}
</script>
<?php include_once("includes/top_navigation.php"); ?>

	<!-- BEGIN CONTAINER -->	
	<div class="page-container row-fluid">
		
    <?php include_once("includes/sidebar_menu.php"); ?>
        
		<!-- BEGIN PAGE -->
		<div class="page-content">
			
            <!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
                	<!-- BEGIN span12 -->
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
							<!-- BEGIN color-mode -->
                            <div class="color-mode">
								<p>THEME COLOR</p>
								<ul class="inline">
									<li class="color-black current color-default" data-style="default"></li>
									<li class="color-blue" data-style="blue"></li>
									<li class="color-brown" data-style="brown"></li>
									<li class="color-purple" data-style="purple"></li>
									<li class="color-white color-light" data-style="light"></li>
								</ul>
								<label class="hidden-phone">
								<input type="checkbox" class="header" checked value="" />
								<span class="color-mode-label">Fixed Header</span>
								</label>							
							</div>
                            <!-- END color-mode -->
						</div>
						<!-- END BEGIN STYLE CUSTOMIZER --> 
                        
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Product's List &nbsp;				<small> Here You can view information about products.</small>
						</h3>
						<ul class="breadcrumb">
							<?php $breadcrumb = breadcrumb();
                                echo $breadcrumb; 
                            ?>
                        </ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
                    <!-- END span12 -->
				</div>
				<!-- END PAGE HEADER-->
            
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Products Information</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Print</a></li>
											<li><a href="#">Save as PDF</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="product_list">
									<thead>
										<tr>
											<th>No</th>
											<th>Product Name</th>
                                            <th>Category</th>
                                            <th>Sub-Category</th>
                                            <th>Brand</th>
                                            <th>Price</th>
                                            <th>Condition</th>
                                            <th>Picture</th>
                                            <th>Details</th>
                                            <th>Date Added</th>
                                            <th>Status</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$sql = "SELECT * FROM product ORDER BY product_id DESC"; 
											$result = $database->query($sql);
											while($product = $database->fetch_array($result)) {
										?>
                                        <tr class="">
											<td><?php echo $no++; ?></td>
											<td><?php echo $product['product_name'];?></td>
                                            <td>
											<?php $category_id = $product['product_category'];
												$query = $database->query("SELECT category_name FROM product_category WHERE category_id=$category_id LIMIT 1");
												$category = $database->fetch_array($query);
												echo $category['category_name'];
											?></td>
                                            <td>
											<?php $sub_Category_id = $product['product_sub_category'];
												$query = $database->query("SELECT sub_cat_name FROM sub_category WHERE sub_cat_id=$sub_Category_id LIMIT 1");
												$sub_category = $database->fetch_array($query);
												echo $sub_category['sub_cat_name'];
											?></td>
                                            <td>
											<?php $brand_id = $product['brand']; 
												$query = $database->query("SELECT brand_name FROM brand WHERE brand_id=$brand_id LIMIT 1");
												$brand = $database->fetch_array($query);
												echo $brand['brand_name'];
											?></td>
                                            <td><?php echo "$".$product['price'];?></td>
                                            <td><?php echo $product['condition'];?></td>
                                            
                                            <td width="200px">
											<?php $productID = $product['product_id']; 
													$sql = "SELECT id,image_name FROM images WHERE product_id=$productID";
													$ress = $database->query($sql);
													while($image = $database->fetch_array($ress)) {
											?>
                                            
                                            <img src="../images/product_images/<?php echo $image['image_name'];?>" width="50" height="50" /> <a href="delete.php?image_id=<?php echo $image['id']; ?>"> X </a>
                                            <?php } ?>
                                             <br />
                                   <form action="product_list.php" method="post" enctype="multipart/form-data">
                                   	<input type="hidden" name="productID" value="<?php echo $product['product_id']; ?>" />
                                    <input type="hidden" name="productName" value="<?php echo $product['product_name']; ?>" />
                                    <div class="control-group">
                                      <div class="controls">
                                         <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <span class="btn btn-file">
                                            <span class="fileupload-new">Select file</span>
                                            <span class="fileupload-exists">Change</span>
                                            <input type="file" name="product_image" class="default" />
                                            </span>
                                            <span class="fileupload-preview"></span>
                                            <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none"></a>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="control-group">
                                      <div class="controls">
                                    <input type="submit" name="submit" value="Add Image" class="btn btn-small btn-success" />
                                    	</div>
                                       </div>
                                   </form>
                                            </td>
                                            <td><?php echo $product['details'];?></td>
                                            <td><?php echo date("Y-M-d", $product['date_added']);?></td>
                                            <td><?php echo $product['status'];?></td>
                                            
											<td><a class="btn btn-info btn-small" href="product.php?product_id=<?php echo $product['product_id']; ?>&task=edit"><i class="icon-plus-sign-alt"></i></a></td>
											<td>
                                            <button type="button" class="btn btn-danger btn-small" onClick="conf(this.id)" id="<?php echo $product['product_id']; ?>"> <i class="icon-trash"></i> </button></td>
										</tr>
                                        <?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
            	<!-- END PAGE CONTENT -->
            
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>