<?php include_once("includes/header.php"); ?>
<?php
	// Insert data to sub_category table
	global $database;
	if(isset($_POST['submit'])) {
		$sub_cat_name = $database->escape_value($_POST['sub_category']);
		$category_name = $database->escape_value($_POST['category_name']);
		$description = $database->escape_value($_POST['description']);
		$status = $database->escape_value($_POST['status']);
		$date_added = time();
		$sql = "INSERT INTO sub_category(category_id, sub_cat_name, description, status, date_added) 
				VALUES($category_name,'$sub_cat_name', '$description', '$status', $date_added)";	
		
		if($database->query($sql)) {
			$result = true;	
		} else {
			$result = false;
		}
	}
	
	// Update data of sub_category table
	if(isset($_POST['update'])) {
		$sub_cat_id = $database->escape_value($_POST['sub_cat_id']);
		$sub_cat_name = $database->escape_value($_POST['sub_cateogry']);
		$categoryName = $database->escape_value($_POST['category_name']);
		$description = $database->escape_value($_POST['description']);
		$status = $database->escape_value($_POST['status']);
		
		$sql = "UPDATE sub_category SET category_id='$categoryName', sub_cat_name='$sub_cat_name', description='$description', status='$status' WHERE sub_cat_id='$sub_cat_id' LIMIT 1";
		if($res = $database->query($sql)) {
			redirect_to('product_sub_category.php');	
		} else {
			echo '<script type="text/javascript"> alert("Please check your entry and try again"); </script>';
		}
	}

?>
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
							Product Sub-Categories &nbsp;				<small> Here You can create and view product's sub-categories.</small>
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
			<?php if(!isset($_GET['product_sub_category_id']) && !isset($_GET['task'])) { ?>	
                <!-- BEGIN PAGE CONTENT-->          
             <div class="row-fluid">
               <!-- BEGIN span12 -->
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box purple">
                  	<!-- BEGIN portlet-title -->
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Category Information</h4>
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
                        <form action="product_sub_category.php" id="product_sub_category" name="product_sub_category" class="form-horizontal" method="post">
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
                           	<div class="row-fluid">
                            	<div class="span6">
                              	<div class="control-group">
                                  <label class="control-label">Sub-Category Name <span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="sub_category" id="sub_cateogry" class="m-wrap span10 tooltips" data-original-title="Please write valid category name" tabindex="1" autofocus/>
                                     
                                  </div>
                               	</div>
                                </div>
                                <div class="span6">
                                <div class="control-group">
                              <label class="control-label">Category Name <span class="required">*</span></label>
                              <div class="controls">
                                 <select class="span10 chosen" data-placeholder="Choose a Category" name="category_name" tabindex="2">
                                    <option value=""></option>
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
                          <div class="row-fluid">
                            
                            <div class="span6">
                                <div class="control-group">
                                  <label class="control-label">Description </label>
                                  <div class="controls input-icon">
                                     <textarea name="description" id="description" class="span10 m-wrap " rows="3"/> </textarea>
                                     
                                  </div>
                                </div>
                            </div>
                              <div class="span6">
                                <div class="control-group">
                                  <label class="control-label">Status</label>
                                  <div class="controls">
                                     <label class="radio">
                                     <input type="radio" name="status" value="active" checked />
                                     Active
                                     </label>
                                     <label class="radio">
                                     <input type="radio" name="status" value="hidden" />
                                     Hidden
                                     </label>  
                                     <label class="radio">
                                     <input type="radio" name="status" value="disabled" />
                                     Disabled
                                     </label>  
                                  </div>
                               </div>
                             </div>
                           </div>	
                           <div class="form-actions">
                              <button type="submit" name="submit" class="btn green button-submit" tabindex="3">Save <i class="m-icon-swapright m-icon-white"></i></button>
                           </div>
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
            
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-edit"></i>Product's Sub-Category Information</h4>
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
								<table class="table table-striped table-bordered table-hover" id="sub_category">
									<thead>
										<tr>
											<th>Number</th>
											<th>Category</th>
                                            <th>Sub-Category</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$sql = "SELECT * FROM sub_category"; 
											$result = $database->query($sql);
											while($product = $database->fetch_array($result)) {
										?>
                                        <tr class="">
											<td><?php echo $no++; ?></td>
                                            <td><?php $catID = $product['category_id']; 
												$catName = $database->query("SELECT category_name FROM product_category WHERE category_id=$catID LIMIT 1");
												$catResult = $database->fetch_array($catName);
												echo $catResult['category_name'];
											?></td>
											<td><?php echo $product['sub_cat_name'];?></td>
                                            <td width="350"><?php echo $product['description'];?></td>
                                            <td><?php echo "<strong>" . $product['status'] . "</strong>";?></td>
                                            <td><?php echo date("Y-M-d", $product['date_added']);?></td>
											<td><a class="edit" href="product_sub_category.php?product_sub_category_id=<?php echo $product['sub_cat_id']; ?>&task=edit">Edit</a></td>
											<td><a class="delete" href="delete.php?product_sub_category_id=<?php echo $product['sub_cat_id']; ?>">Delete</a></td>
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
                
            <?php } else if(isset($_GET['product_sub_category_id']) && isset($_GET['task']) && ($_GET['task'] == 'edit')) {  
					$sub_cat_id = $_GET['product_sub_category_id'];
					$sql = "SELECT * FROM sub_category WHERE sub_cat_id=$sub_cat_id LIMIT 1";
					$result = $database->query($sql);
					$subCatID = $database->fetch_array($result);
			?>
               <!-- BEGIN PAGE CONTENT-->          
             <div class="row-fluid">
               <!-- BEGIN span12 -->
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box purple">
                  	<!-- BEGIN portlet-title -->
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Category Information</h4>
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
                        <form action="product_sub_category.php" id="product_sub_category" name="product_sub_category" class="form-horizontal" method="post">
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
                           		<div class="row-fluid">
                            	<div class="span6">
                                <div class="control-group">
                                  <label class="control-label">Category Name <span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="sub_cateogry" id="sub_cateogry" class="m-wrap span8 tooltips" data-original-title="Please write valid category name" value="<?php echo $subCatID['sub_cat_name']; ?>"/>
                                     
                                  </div>
                               	</div>
                                </div>
                           <div class="span6">
                           	    <div class="control-group">
                              <label class="control-label">Category Name <span class="required">*</span></label>
                              <div class="controls">
                                 <select class="span6 chosen" data-placeholder="Choose a Category" name="category_name" tabindex="2">
                                    <option value=""></option>
                                    <?php $sql = "SELECT * FROM product_category";
										$sub_cat = $database->query($sql);
										while($row = $database->fetch_array($sub_cat)) { 
									?>
                                  <option value="<?php echo $row['category_id']; ?>" 
							<?php if($subCatID['category_id'] == $row['category_id']) { echo 'selected="selected"'; } ?>>
								<?php echo $row['category_name']; ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                           </div> 
                           </div>
                                
                             </div>
                          <div class="row-fluid">
                            
                            <div class="span6">
                                <div class="control-group">
                                  <label class="control-label">Description </label>
                                  <div class="controls input-icon">
                                     <textarea name="description" id="description" class="span10 m-wrap " rows="3"/> 
                                     <?php echo $subCatID['description']; ?></textarea>
                                     
                                  </div>
                                </div>
                            </div>
                              <div class="span6">
                                <div class="control-group">
                                  <label class="control-label">Status</label>
                                  <div class="controls">
                                     <label class="radio">
                                     <input type="radio" name="status" value="active" <?php if($subCatID['status'] == 'active') { echo "checked"; } ?> />
                                     Active
                                     </label>
                                     <label class="radio">
                                     <input type="radio" name="status" value="hidden" <?php if($subCatID['status'] == 'hidden') { echo "checked"; } ?> />
                                     Hidden
                                     </label>  
                                     <label class="radio">
                                     <input type="radio" name="status" value="disabled" <?php if($subCatID['status'] == 'disabled') { echo "checked"; } ?> />
                                     Disabled
                                     </label>  
                                  </div>
                               </div>
                             </div>
                           </div>	
                              	
                           <div class="form-actions">
                           <input type="hidden" name="sub_cat_id" value="<?php echo $subCatID['sub_cat_id']; ?>" />
                              <button type="submit" name="update" class="btn green button-submit" >Update <i class="m-icon-swapright m-icon-white"></i></button>
                           </div>
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
            <?php } else {
				redirect_to('404.php');	
			}?>
            
			</div>
			<!-- END PAGE CONTAINER-->	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>