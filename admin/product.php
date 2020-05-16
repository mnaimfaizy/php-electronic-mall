<?php include_once("includes/header.php"); ?>
<?php
	global $database;

	// Insert data to product table	
	if(isset($_POST['submit'])) {
		$product_name = $database->escape_value($_POST['name']);
		$category = $database->escape_value($_POST['category']);
		$sub_category = $database->escape_value($_POST['sub_category']);
		$brand = $database->escape_value($_POST['brand']);
		$price = $database->escape_value($_POST['price']);
		$condition = $database->escape_value($_POST['condition']);
		$details = $database->escape_value($_POST['details']);
		$date_added = time();
		$status = $database->escape_value($_POST['status']);
		$slider = $database->escape_value($_POST['slider']);
		$stock = $database->escape_value($_POST['stock']);
		$quantity = $database->escape_value($_POST['quantity']);
		
		$sql = "INSERT INTO product(`product_name`, `product_category`, `product_sub_category`, `brand`, `price`, `condition`, `details`, `date_added`, `status`, `slider`, `in_stock`, `quantity`) VALUES('$product_name','$category', '$sub_category', '$brand', $price, '$condition', '$details', $date_added, '$status', '$slider', '$stock', $quantity)";	
		
		if($database->query($sql)) {
		
		// Get the last id which the record has been inserted
		$R = $database->query("SELECT product_id FROM product ORDER BY product_id DESC LIMIT 1");
		$RR = $database->fetch_array($R);
		$produc_id = $RR['product_id']; 
		
		// Upload image and save to image table in the database	
		
		if(isset($_FILES['product_image'])) {
			$file = $_FILES['product_image'];
			$temp_path		= $file['tmp_name'];
			$filename		= basename($file['name']);
			$type			= $file['type'];
			$size			= $file['size'];
			
			// Determine the target Path
			$target_path = '../images/product_images/'.$filename;
			if(file_exists($target_path)) {
				echo "<script> alert('The file {$filename} already exists.'); </script>";
			}
			
			// Attempt to move the file
			if(move_uploaded_file($temp_path, $target_path)) {
				// Success	
				// Save a corresponding entry to the database
				$sql = "INSERT INTO images(image_name, size, type, caption, product_id) VALUES('$filename', '$size', '$type', '$product_name', '$produc_id')";
				if($database->query($sql)) {
					$result = true;	
				}
				
			} else {
				// File was not moved
				// echo "The file upload failed, possibly due to incorrect permissions on the upload folder.";
			}
		}
			$result = true;
		} else {
			$result = false;
		}
	}
	
	// Update data of brand table
	if(isset($_POST['update'])) {
		$product_id = $database->escape_value($_POST['productID']);
		$product_name = $database->escape_value($_POST['name']);
		$category = $database->escape_value($_POST['category']);
		$sub_category = $database->escape_value($_POST['sub_category']);
		$brand = $database->escape_value($_POST['brand']);
		$price = $database->escape_value($_POST['price']);
		$condition = $database->escape_value($_POST['condition']);
		$details = $database->escape_value($_POST['details']);
		$status = $database->escape_value($_POST['status']);
		$slider = $database->escape_value($_POST['slider']);
		$stock = $database->escape_value($_POST['stock']);
		$quantity = $database->escape_value($_POST['quantity']);
		
		$sql = "UPDATE product SET `product_name`='$product_name', `product_category`=$category, `product_sub_category`=$sub_category, `brand`=$brand, `price`=$price, `condition`='$condition', `details`='$details', `status`='$status', `slider`='$slider', `in_stock`='$stock',`quantity`= $quantity WHERE product_id=$product_id";
		
		if($database->query($sql)) {
			redirect_to("product_list.php");
		} else {
			// $result = false;
		}
	}

?>

<?php include_once("includes/top_navigation.php"); ?>

	<!-- BEGIN CONTAINER -->	
	<div class="page-container row-fluid">
		
    <?php include_once("includes/sidebar_menu.php"); ?>
        
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<?php if(!isset($_GET['product_id']) && !isset($_GET['task']) && (@$_GET['task'] != 'edit')) { ?>
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
							Add Product		&nbsp;&nbsp;		<small> Here You can add new product.</small>
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
               <!-- BEGIN span12 -->
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box purple">
                  	<!-- BEGIN portlet-title -->
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Add New Product to database</h4>
                        <!-- BEGIN tools -->
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                        <!-- END tools -->
                     </div>
                     <!-- END portlet-title -->
                     
                     <!-- BEGIN portlet-body form -->
                     <div class="portlet-body form">
                       	<?php 
						if(isset($result)) {
						if($result == true) {
                               echo '<div class="alert alert-success">
									  <button class="close" data-dismiss="alert"></button>
									  Record Inserted Successfully!
								   	 </div>';
						} else if($result == false) {
                           	echo '<div class="alert alert-error">
                                  	<button class="close" data-dismiss="alert"></button>
                                  	Please check your entry, record insertion was unsuccessfull.
                               	  </div>';
                        }	// End second IF
						} // End First IF ?>
                        <!-- BEGIN FORM-->
                        <form action="product.php" id="product" name="product" class="form-horizontal" method="post"   enctype="multipart/form-data">
                           <!-- Error Section for form -->
                           <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                           <div class="alert alert-success hide">
                              <button class="close" data-dismiss="alert"></button>
                              Your form validation is successful!
                           </div>
                           <!-- End Error Section for from -->
                           
                           <!-- Personal Information Section -->
                           <h3 class="form-section">Product Information</h3>
                           <!-- First Section --> 
                            <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Product Name <span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="name" id="name" class="m-wrap span8 tooltips" data-original-title="Please write valid product name" placeholder="Product Name"/>
                                     
                                  </div>
                               	</div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Category <span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span8 m-wrap" name="category" id="category">
                                        <option value="" selected="selected" disabled>Select...</option>
                                        <?php $sql = "SELECT * FROM product_category";
											$sub_cat = $database->query($sql);
											while($row = $database->fetch_array($sub_cat)) { 
										?>
										<option value="<?php echo $row['category_id']; ?>">
											<?php echo $row['category_name']; ?></option>
										<?php } ?>
                                     </select>
                                  </div>
                               </div>
                              </div>
                           </div>
                           <!-- End of First Section -->
                           
                           <!-- Second Section -->
                           <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Sub-Category <span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span8 m-wrap" name="sub_category" id="sub_category">
                                        
                                     </select>
                                  </div>
                               </div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Brand</label>
                                  <div class="controls">
                                     <select class="span8 m-wrap" name="brand" id="brand">
                                        <option value="" selected="selected" disabled>Select...</option>
                                        <?php $sql = "SELECT * FROM brand";
											$sub_cat = $database->query($sql);
											while($row = $database->fetch_array($sub_cat)) { 
										?>
										<option value="<?php echo $row['brand_id']; ?>">
											<?php echo $row['brand_name']; ?></option>
										<?php } ?>
                                     </select>
                                  </div>
                               </div>
                              </div>
                           </div>
                           <!-- End of Second Section -->
                           
                           <!-- Third Section -->
                     		<div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Price <span class="required">*</span></label>
                                  <div class="controls">
                                     <input type="text" name="price" id="price" class="m-wrap span8 tooltips" data-original-title="Please write product's price" placeholder="40"/>
                                  </div>
                               	</div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Condition <span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span8 m-wrap" name="condition" id="condition">
                                        <option value="" selected="selected" disabled>Select...</option>
                                        <option value="New">New</option>
                                        <option value="Used">Used</option>
                                     </select>
                                  </div>
                               </div>
                              </div>
                           </div>
                           <!-- End of Third Section -->
                           
                           <!-- Fourth Section -->
                           <div class="row-fluid">
                              <div class="span12 ">
                              	<div class="control-group">
                                  <label class="control-label">Details / Specification <span class="required">*</span></label>
                                  <div class="controls">
                                     <textarea class="span12 wysihtml5 m-wrap" name="details" id="details" rows="6"></textarea>
                                  </div>
                           		</div>
                              </div>
                           </div>
                           <!-- End of Fourth Section -->
                           
                           <!-- Fifth Section -->
                           <div class="row-fluid">
                              <!-- BEGIN span12 -->
                              <div class="span6">
                              	<!-- BEGIN control-group -->
                                <div class="control-group">
                              <label class="control-label">Product Picture <span class="required">*</span></label>
                              <!-- BEGIN controls -->
                              <div class="controls">
                                 <!-- BEGIN fileupload fileupload-new -->
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                       <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                       <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="product_image" id="product_image" /></span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                                 <!-- END fileupload fileupload-new -->
                                 <span class="label label-important">NOTE!</span>
                                 <span>
                                 Attached image thumbnail is
                                 supported in Latest Firefox, Chrome, Opera, 
                                 Safari and Internet Explorer 10 only
                                 </span>
                              </div>
                              <!-- END controls -->
                           </div>
                           <!-- END control-group -->
                      </div>
                      <!-- END span12 -->
                      
                      <div class="span6">
                        <div class="control-group">
                          <label class="control-label">Status <span class="required">*</span></label>
                          <div class="controls">
                             <select class="span10 m-wrap" name="status" id="status">
                                <option value="" selected="selected" disabled> Select... </option>
                                <option value="active"> Active </option>
                                <option	value="deactive"> De-active </option>
                             </select>
                          </div>
                        </div>
                      <br />
                        <div class="control-group">
                          <label class="control-label">Slider <span class="required">*</span></label>
                          <div class="controls">
                             <select class="span10 m-wrap" name="slider" id="slider" style="float:left;">
                                <option value="" selected="selected" disabled> Select... </option>
                                <option value="slide"> Slide </option>
                                <option	value="no_slide"> No Slide </option>
                             </select>
                          </div>
                        </div>
                        
                        <br />
                        
                         <div class="control-group">
                          <label class="control-label">In Stock <span class="required">*</span></label>
                          <div class="controls">
                                Yes <input type="radio" checked="checked" name="stock" id="stock" value="Yes" />
                                No <input type="radio" name="stock" value="No" /> 
                          </div>
                       </div>
                       
                       <div class="control-group">
                          <label class="control-label">Quantity<span class="required">*</span></label>
                          <div class="controls">
                                <input type="text" name="quantity" id="quantity" class="m-wrap span2" placeholder="10"/>
                          </div>
                       </div>
                          
                         
                      </div>
                      
                   </div>
                  <!-- End of Fifth Section -->
                           <!-- Ninth Section -->
                           <div class="form-actions">
                              <button type="submit" name="submit" class="btn green button-submit">Save <i class="m-icon-swapright m-icon-white"></i></button>
                           </div>
                           <!-- End of Ninth Section -->
                        </form>
                        <!-- END FORM-->
                     </div>
                     <!-- END portlet-body form -->
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
               <!-- END span12 -->
            </div>  
            <!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->
        <?php } else if(isset($_GET['product_id']) && isset($_GET['task']) && (@$_GET['task'] == 'edit')) { ?>
        <?php 		$product_id = $_GET['product_id'];
					$sql = "SELECT * FROM product WHERE product_id=$product_id LIMIT 1";
					$ress = $database->query($sql);
					$product = $database->fetch_array($ress);
		?>
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
							Update Product		&nbsp;&nbsp;		<small> Here You can update selected product.</small>
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
               <!-- BEGIN span12 -->
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box purple">
                  	<!-- BEGIN portlet-title -->
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Update selected Product to database</h4>
                        <!-- BEGIN tools -->
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                        <!-- END tools -->
                     </div>
                     <!-- END portlet-title -->
                     
                     <!-- BEGIN portlet-body form -->
                     <div class="portlet-body form">
                       
                        <!-- BEGIN FORM-->
                        <form action="product.php" id="product" name="product" class="form-horizontal" method="post"   enctype="multipart/form-data">
                           <!-- Error Section for form -->
                           <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                           <div class="alert alert-success hide">
                              <button class="close" data-dismiss="alert"></button>
                              Your form validation is successful!
                           </div>
                           <!-- End Error Section for from -->
                           
                           <!-- Personal Information Section -->
                           <h3 class="form-section">Product Information</h3>
                           <!-- First Section --> 
                            <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Product Name <span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="name" id="name" class="m-wrap span8 tooltips" data-original-title="Please write valid product name" value="<?php echo $product['product_name']; ?>"/>
                                     
                                  </div>
                               	</div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Category <span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span6 m-wrap" name="category" id="category">
                                        <option value="" selected="selected" disabled>Select...</option>
                                        <?php $sql = "SELECT * FROM product_category";
											$sub_cat = $database->query($sql);
											while($row = $database->fetch_array($sub_cat)) { 
										?>
										<option value="<?php echo $row['category_id']; ?>" 
                                        <?php if($row['category_id'] == $product['product_category']) { echo "selected=\"selected\""; } ?>>
											<?php echo $row['category_name']; ?></option>
										<?php } ?>
                                     </select>
                                  </div>
                               </div>
                              </div>
                           </div>
                           <!-- End of First Section -->
                           
                           <!-- Second Section -->
                           <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Sub-Category <span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span6 m-wrap" name="sub_category">
                                        <option value="" selected="selected" disabled>Select...</option>
                                        <?php $sql = "SELECT * FROM sub_category";
											$sub_cat = $database->query($sql);
											while($row = $database->fetch_array($sub_cat)) { 
										?>
										<option value="<?php echo $row['sub_cat_id']; ?>" 
                                         <?php if($row['sub_cat_id'] == $product['product_sub_category']) { echo "selected=\"selected\""; } ?>>
											<?php echo $row['sub_cat_name']; ?></option>
										<?php } ?>
                                     </select>
                                  </div>
                               </div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Brand</label>
                                  <div class="controls">
                                     <select class="span6 m-wrap" name="brand" id="brand">
                                        <option value="" selected="selected" disabled>Select...</option>
                                        <?php $sql = "SELECT * FROM brand";
											$sub_cat = $database->query($sql);
											while($row = $database->fetch_array($sub_cat)) { 
										?>
										<option value="<?php echo $row['brand_id']; ?>"  
										<?php if($row['brand_id'] == $product['brand']) { echo "selected=\"selected\""; } ?>>
											<?php echo $row['brand_name']; ?></option>
										<?php } ?>
                                     </select>
                                  </div>
                               </div>
                              </div>
                           </div>
                           <!-- End of Second Section -->
                           
                           <!-- Third Section -->
                     		<div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Price <span class="required">*</span></label>
                                  <div class="controls">
                                     <input type="text" name="price" id="price" class="m-wrap span8 tooltips" data-original-title="Please write product's price" value="<?php echo $product['price']; ?>"/>
                                  </div>
                               	</div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Condition <span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span6 m-wrap" name="condition" id="condition">
                                        <option value="" selected="selected" disabled>Select...</option>
                                        <option value="New" <?php if($product['condition'] == 'New') { echo 'selected="selected"'; } ?>>New</option>
                                        <option value="Used" <?php if($product['condition'] == 'Used') { echo 'selected="selected"'; } ?>>Used</option>
                                     </select>
                                  </div>
                               </div>
                              </div>
                           </div>
                           <!-- End of Third Section -->
                           
                           <!-- Fourth Section -->
                           <div class="row-fluid">
                              <div class="span12 ">
                              	<div class="control-group">
                                  <label class="control-label">Details / Specification <span class="required">*</span></label>
                                  <div class="controls">
                                     <textarea class="span12 wysihtml5 m-wrap" name="details" id="details" rows="6">
                                     <?php echo $product['details']; ?>
                                     </textarea>
                                  </div>
                           		</div>
                              </div>
                           </div>
                           <!-- End of Fourth Section -->
                           
                           <!-- Fourth Section -->
                           <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Status <span class="required">*</span></label>
                                  <div class="controls">
                                     <select name="status">
                                     	<option value="active" <?php if($product['status'] == 'active') { echo 'selected="selected"'; } ?>> Active </option>
                                        <option	value="deactive" <?php if($product['status'] == 'deactive') { echo 'selected="selected"'; } ?>> De-active </option>
                                     </select>
                                  </div>
                           		</div>
                                </div>
                                <div class="span6">
                                <div class="control-group">
                                  <label class="control-label">Slider <span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span10 m-wrap" name="slider" id="slider" style="float:left;">
                                        <option value="" selected="selected" disabled> Select... </option>
                                        <option value="slide" <?php if($product['slider'] == 'slide') { echo 'selected="selected"'; } ?>> Slide </option>
                                        <option	value="no_slide" <?php if($product['slider'] == 'no_slide') { echo 'selected="selected"'; } ?>> No Slide </option>
                                     </select>
                                  </div>
                                </div>
                                
                              </div>
                           </div>
                           <!-- End of Fourth Section -->
                           
                           <!-- Fifth Section -->
                           <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">In Stock <span class="required">*</span></label>
                                  <div class="controls">
                                        Yes <input type="radio" name="stock" id="stock" value="Yes" <?php if($product['in_stock'] == 'Yes') { echo 'checked="checked"'; } ?> />
                                        No <input type="radio" name="stock" id="stock" value="No" <?php if($product['in_stock'] == 'No') { echo 'checked="checked"'; } ?> /> 
                                  </div>
                               </div>
                                </div>
                                <div class="span6">
                               <div class="control-group">
                                  <label class="control-label">Quantity<span class="required">*</span></label>
                                  <div class="controls">
                                  <input type="text" name="quantity" id="quantity" class="m-wrap span2" placeholder="10"value="<?php echo $product['quantity']; ?>" />
                                  </div>
                               </div>
                                
                              </div>
                           </div>
                           <!-- End of Fifth Section -->
                           
                           <!-- Sixth Section -->
                           <div class="form-actions">
                           <input type="hidden" name="productID" value="<?php echo $product['product_id']; ?>" />
                              <button type="submit" name="update" class="btn green button-submit">Update <i class="m-icon-swapright m-icon-white"></i></button>
                           </div>
                           <!-- End of Sixth Section -->
                        </form>
                        <!-- END FORM-->
                     </div>
                     <!-- END portlet-body form -->
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
               <!-- END span12 -->
            </div>  
            <!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->
        <?php } ?>	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>
<script type="text/javascript">
	$(document).ready(function() {
        // Load Sub-Categories when Category is selected
		$("#category").change(function() {
			$.get('ajax/load_sub_category.php?category_id=' +$(this).val(), function(data) { 
				$("#sub_category").html(data);
				$("#sub_category").prepend('<option value="" disabled="disabled" selected="selected"> -- Select Sub-Category -- </option>');
			});
		});
		var output = '<option value="" selected="selected" disabled>-- Select Category First --</option>';
		$("#sub_category").html(output);
    });
</script>