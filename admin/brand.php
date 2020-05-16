<?php include_once("includes/header.php"); ?>
<?php
	global $database;
	
	if(!isset($_SESSION['maxfiles'])) {
	$_SESSION['maxfiles'] = ini_get('max_file_uploads');
	$_SESSION['postmax'] = UploadFile::convertToBytes(ini_get('post_max_size'));
	$_SESSION['displaymax'] = UploadFile::convertFromBytes($_SESSION['postmax']);	
	}
	$max = 100 * 1024;
	$filename = '';
	$res = array();
	$uploadResult = false;
	
	// Insert data to brand table	
	if(isset($_POST['submit'])) {
		$brand_name = trim($_POST['brand_name']);
		$status = trim($_POST['status']);
		$date_added = time();
		$destination = '../images/brands/';
		try {
			$upload = new UploadFile($destination);	
			$upload->setMaxSize($max);
			$upload->allowAllTypes();
			
			$uploadResult = $upload->upload();
			$filename = $upload->getFileName();
			$res = $upload->getMessages();
		} catch(Exception $e) {
			$res[] = $e->getMessage();	
		}
		$error = error_get_last();
		
		$sql = "INSERT INTO brand(brand_name, brand_image, status, date_added) VALUES('" . $brand_name . "','" . $filename . "','". $status . "',". $date_added.")";	
		
		if($database->query($sql)) {
			$result = true;	
		} else {
			$result = false;
		}
	}
	
	// Update data of brand table
	if(isset($_POST['update'])) {
		$brand_id = $_POST['brandID'];
		$brand_name = $_POST['brand_name'];
		$status = trim($_POST['status']);
		
			$destination = '../images/brands/';
			try {
				$upload = new UploadFile($destination);	
				$upload->setMaxSize($max);
				$upload->allowAllTypes();
				
				$uploadResult = $upload->upload();
				if(($uploadResult == true) && file_exists('../images/brands/'.$_POST['oldImage'])) {	
					$old_image = $_POST['oldImage'];
					$old_path = '../images/brands/' . $old_image;
					unlink($old_path);
				}
				$filename = $upload->getFileName();
				$res = $upload->getMessages();
			} catch(Exception $e) {
				$res[] = $e->getMessage();	
			}
			$error = error_get_last();
			// Attempt to move the file
				// Success		
		$sql = "UPDATE brand SET brand_name='$brand_name'";
		if(isset($filename) && !empty($filename)) {
		$sql .= ", brand_image='$filename'"; 
		}
		$sql .= ", status='$status' WHERE brand_id='$brand_id' LIMIT 1";
		if($database->query($sql)) {
			redirect_to('brand.php');	
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
							Product Brand &nbsp;				<small> Here You can create and view product's brands.</small>
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
			<?php if(!isset($_GET['brand_id']) && !isset($_GET['task'])) { ?>	
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
                        <?php if($res) { ?>
                        <div class="alert">
									<button class="close" data-dismiss="alert"></button>
									<strong>Note!</strong> <br />
                        <ul>
                        <?php
                            if(isset($error)) {
                                echo "<li>{$error['message']}</li>";	
                            }
                            if($res) {
                                foreach($res as $message) {
                                        echo "<li> $message </li>";
                                } 
                            } ?>
                        </ul>
                        </div>
                        <?php } ?>
                        <!-- BEGIN FORM-->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="brands" name="brands" class="form-horizontal" method="post" enctype="multipart/form-data">
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
                           
                              	<div class="control-group">
                                  <label class="control-label">Brand Name <span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="brand_name" id="brand_name" class="m-wrap span8 tooltips" data-original-title="Please write valid brand name" autofocus/>
                                     
                                  </div>
                               	</div>
                              
                               <div class="control-group">
                              <label class="control-label">Brand Image</label>
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
                                       <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
                                       <input type="file" class="default" name="brand_image" id="filename"
                                       data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>" 
                                        data-postmax="<?php echo $_SESSION['postmax']; ?>" 
                                        data-displaymax="<?php echo $_SESSION['displaymax']; ?>" /></span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                                 <!-- END fileupload fileupload-new -->
                                 <span class="label label-important">NOTE!</span>
                                 <span>
                                 <ul>
                                    <li>Each file should be no more than <?php echo UploadFile::convertFromBytes($max); ?>.</li>
                                    <li>Combined total should not exceed <?php echo $_SESSION['displaymax']; ?>.</li>
                                </ul>
                                </span>
                                 <span>
                                 Attached image thumbnail is
                                 supported in Latest Firefox, Chrome, Opera, 
                                 Safari and Internet Explorer 10 only
                                 </span>
                              </div>
                              <!-- END controls -->
                           </div>
                           
                           <div class="control-group">
                          <label class="control-label">Status <span class="required">*</span></label>
                          <div class="controls">
                             <select class="span10 m-wrap" name="status" id="status">
                                <option value="active" selected="selected"> Active </option>
                                <option	value="deactive"> De-active </option>
                             </select>
                          </div>
                        </div>
                              
                           <div class="form-actions">
                              <button type="submit" name="submit" id="submit" class="btn green button-submit" >Save <i class="m-icon-swapright m-icon-white"></i></button>
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
								<h4><i class="icon-edit"></i>Brands Information</h4>
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
								<table class="table table-striped table-bordered table-hover" id="brand_table">
									<thead>
										<tr>
											<th>Number</th>
											<th>Brand Name</th>
                                            <th>Brand Image</th>
                                            <th>Status</th>
                                            <th>Date Added</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
											$sql = "SELECT * FROM brand"; 
											$result = $database->query($sql);
											while($product = $database->fetch_array($result)) {
										?>
                                        <tr class="">
											<td><?php echo $no++; ?></td>
											<td><?php echo $product['brand_name'];?></td>
                                            <td><img src="../images/brands/<?php echo $product['brand_image'];?>" width="50" height="50" /></td>
                                            <td><?php echo $product['status'];?></td>
                                            <td><?php echo date("Y-M-d", $product['date_added']);?></td>
											<td><a class="edit" href="brand.php?brand_id=<?php echo $product['brand_id']; ?>&task=edit">Edit</a></td>
											<td><a class="delete" href="delete.php?brand_id=<?php echo $product['brand_id']; ?>">Delete</a></td>
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
                
            <?php } else if(isset($_GET['brand_id']) && isset($_GET['task']) && ($_GET['task'] == 'edit')) {  
					$brand_id = $_GET['brand_id'];
					$sql = "SELECT * FROM brand WHERE brand_id=$brand_id LIMIT 1";
					$result = $database->query($sql);
					$brand = $database->fetch_array($result);
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
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                        <!-- END tools -->
                     </div>
                     <!-- END portlet-title -->
                     
                     <!-- BEGIN portlet-body form -->
                     <div class="portlet-body form">
                     	<?php if($res) { ?>
                        <div class="alert">
									<button class="close" data-dismiss="alert"></button>
									<strong>Note!</strong> <br />
                        <ul>
                        <?php
                            if($error) {
                                echo "<li>{$error['message']}</li>";	
                            }
                            if($res) {
                                foreach($res as $message) {
                                        echo "<li> $message </li>";
                                } 
                            } ?>
                        </ul>
                        </div>
                        <?php } ?>
                        <!-- BEGIN FORM-->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" id="brands" name="brands" class="form-horizontal" method="post" enctype="multipart/form-data">
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
                           
                              	<div class="control-group">
                                  <label class="control-label">Brand Name <span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="brand_name" id="brand_name" class="m-wrap span8 tooltips" data-original-title="Please write valid category name" value="<?php echo $brand['brand_name']; ?>" autofocus/>
                                     
                                  </div>
                               	</div>
                          <div class="row-fluid">
                          	<div class="span9">  
                              <div class="control-group">
                              <label class="control-label">Brand Image</label>
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
                                       <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
                                       <input type="file" class="default" name="brand_image" id="filename"
                                       data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>" 
                                        data-postmax="<?php echo $_SESSION['postmax']; ?>" 
                                        data-displaymax="<?php echo $_SESSION['displaymax']; ?>" /></span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                                 <!-- END fileupload fileupload-new -->
                                 <span class="label label-important">NOTE!</span>
                                 <span>
                                 <ul>
                                    <li>Each file should be no more than <?php echo UploadFile::convertFromBytes($max); ?>.</li>
                                    <li>Combined total should not exceed <?php echo $_SESSION['displaymax']; ?>.</li>
                                </ul>
                                </span>
                                 <span>
                                 Attached image thumbnail is
                                 supported in Latest Firefox, Chrome, Opera, 
                                 Safari and Internet Explorer 10 only
                                 </span>
                              </div>
                              <!-- END controls -->
                           </div>
                           </div>
                           <div class="span3">
                           	<img src="../images/brands/<?php echo $brand['brand_image'];?>" width="200" height="150" alt="" />
                           </div>
                           </div>
                           <div class="control-group">
                          <label class="control-label">Status <span class="required">*</span></label>
                          <div class="controls">
                             <select class="span10 m-wrap" name="status" id="status">
                                <option value="active" selected="selected"> Active </option>
                                <option	value="deactive"> De-active </option>
                             </select>
                          </div>
                        </div>
                           <div class="form-actions">
                           <input type="hidden" name="oldImage" value="<?php echo $brand['brand_image'];?>" />
                           <input type="hidden" name="brandID" value="<?php echo $brand['brand_id']; ?>" />
                              <button type="submit" name="update" id="submit" class="btn green button-submit" >Update <i class="m-icon-swapright m-icon-white"></i></button>
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