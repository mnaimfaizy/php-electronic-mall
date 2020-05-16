<?php include_once("includes/header.php"); ?>
<?php
	global $database;
	// Insert data to product_category table
	if(isset($_POST['submit'])) {
		$category_name = $database->escape_value($_POST['category']);
		
		$sql = "INSERT INTO user_group(group_name) 
				VALUES('$category_name')";	
		
		if($database->query($sql)) {
			$result = true;	
		} else {
			$result = false;
		}
	}
	
	// Update data of product_category table
	if(isset($_POST['update'])) {
		$categorID = $database->escape_value($_POST['category_id']);
		$categoryName = $database->escape_value($_POST['category_edit']);
		
		$sql = "UPDATE user_group SET group_name='$categoryName' WHERE id='$categorID' LIMIT 1";
		if($res = $database->query($sql)) {
			redirect_to('user_category.php');	
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
							User Categories &nbsp;				<small> Here You can create and view User's categories.</small>
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
			<?php if(!isset($_GET['user_category_id']) && !isset($_GET['task'])) { ?>	
                <!-- BEGIN PAGE CONTENT-->          
             <div class="row-fluid">
               <!-- BEGIN span12 -->
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box purple">
                  	<!-- BEGIN portlet-title -->
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>User Category Information</h4>
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
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="user_category" name="user_category" class="form-horizontal" method="post">
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
                            	<div class="span9">
                              	<div class="control-group">
                                  <label class="control-label">Category Name <span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="category" id="cateogry" class="m-wrap span12 tooltips" data-original-title="Please write valid category name" autofocus/>
                                     
                                  </div>
                               	</div>
                                </div>
                           <div class="span3">
                           <div class="control-group">
                              <button type="submit" name="submit" class="btn green button-submit" >Save <i class="m-icon-swapright m-icon-white"></i></button>
                           </div>
                           </div>
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
								<h4><i class="icon-edit"></i>Categories Information</h4>
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
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>Number</th>
											<th>Category</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$sql = "SELECT * FROM user_group"; 
											$result = $database->query($sql);
											while($product = $database->fetch_array($result)) {
										?>
                                        <tr class="">
											<td><?php echo $no++; ?></td>
											<td><?php echo $product['group_name'];?></td>
											<td><a class="edit" href="user_category.php?user_category_id=<?php echo $product['id']; ?>&task=edit">Edit</a></td>
											<td><a class="delete" href="delete.php?user_category_id=<?php echo $product['id']; ?>">Delete</a></td>
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
                
            <?php } else if(isset($_GET['user_category_id']) && isset($_GET['task']) && ($_GET['task'] == 'edit')) {  
					$cat_id = $_GET['user_category_id'];
					$sql = "SELECT * FROM user_group WHERE id=$cat_id LIMIT 1";
					$result = $database->query($sql);
					$product = $database->fetch_array($result);
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
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="user_category" name="user_category" class="form-horizontal" method="post">
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
                            	<div class="span9">
                              	<div class="control-group">
                                  <label class="control-label">Category Name <span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="category_edit" id="category" class="m-wrap span10 tooltips" data-original-title="Please write valid category name" value="<?php echo $product['group_name']; ?>" autofocus/>
                                     
                                  </div>
                               	</div>
                                </div>
                           <div class="span3">
                           <div class="control-group">
                           <input type="hidden" name="category_id" value="<?php echo $product['id']; ?>" />
                              <button type="submit" name="update" class="btn green button-submit" >Update <i class="m-icon-swapright m-icon-white"></i></button>
                           </div>
                           </div>
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