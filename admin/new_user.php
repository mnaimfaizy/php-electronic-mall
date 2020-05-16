<?php include_once("includes/header.php"); ?>
<?php
	global $database;

	// Insert data to product table	
	if(isset($_POST['submit'])) {
		$name = $database->escape_value($_POST['name']);
		$username = $database->escape_value($_POST['username']);
		$user_password = $database->escape_value($_POST['user_password']);
		$password = md5($user_password);
		$gender = $database->escape_value($_POST['gender']);
		@$date = $database->escape_value($_POST['date_of_birth']);
		@$date1 = DateTime::createFromFormat('m/d/Y', $date);
		@$new_date = $date1->format('Y-m-d');
		@$date_of_birth = strtotime($new_date);
		$email = $database->escape_value($_POST['email']);
		$phone = $database->escape_value($_POST['phone']);
		$date_added = time();
		$country = $database->escape_value($_POST['country']);
		$state = $database->escape_value($_POST['state']);
		$zip_code = $database->escape_value($_POST['zip_code']);
		$category = $database->escape_value($_POST['category']);
		$status = $database->escape_value($_POST['status']);
		$file = $_FILES['user_photo'];
		$user_photo = $filename	= basename($file['name']);
		
		$sql = "INSERT INTO `user`(`username`, `password`, `name`, `gender`, `date_of_birth`, `email`, `phone`, `country`, `state`, `zip_code`, `group_id`, `date_joined`, `photo`, `status`) VALUES ('$username','$password','$name','$gender',$date_of_birth,'$email','$phone','$country',$state,'$zip_code',$category,$date_added,'$user_photo','$status')";	
		
		if($database->query($sql)) {
		
		// Upload image 
		
		if(isset($_FILES['user_photo'])) {
			$file = $_FILES['user_photo'];
			$temp_path		= $file['tmp_name'];
			$filename		= basename($file['name']);
			$type			= $file['type'];
			$size			= $file['size'];
			
			// Determine the target Path
			$target_path = 'images/users/'.$filename;
			if(file_exists($target_path)) {
				echo "<script> alert('The file {$filename} already exists.'); </script>";
			}
			
			// Attempt to move the file
			if(move_uploaded_file($temp_path, $target_path)) {
				// Success
				
			} else {
				// File was not moved
				echo "The file upload failed, possibly due to incorrect permissions on the upload folder.";
			}
		}
			$result = true;
		} else {
			$result = false;
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
							Create New User				<small> Here You can create new user.</small>
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
                        <h4><i class="icon-reorder"></i>User Registration Form</h4>
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
                        <form action="new_user.php" id="new_user_form" name="new_user_form" class="form-horizontal" method="post" enctype="multipart/form-data">
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
                           <h3 class="form-section">Personal Information</h3>
                           <!-- First Section --> 
                            <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Name<span class="required">*</span></label>
                                  <div class="controls input-icon">
                                     <input type="text" name="name" id="name" class="m-wrap span8 tooltips" data-original-title="Please write your complete name" placeholder="Naim Faizy"/>
                                     
                                  </div>
                               	</div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Username<span class="required">*</span></label>
                                  <div class="controls">
                                     <input type="text" name="username" id="username" class="m-wrap span8 tooltips" data-original-title="Please write valid username" placeholder="mnaimfaizy"/>
                                  </div>
                               	</div>
                              </div>
                           </div>
                           <!-- End of First Section -->
                           
                           <!-- Second Section -->
                           <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Password<span class="required">*</span></label>
                                  <div class="controls">
                                     <input type="password" name="user_password" id="user_password" class="m-wrap span8 tooltips" data-original-title="Password must be between 6-30 characters"/>
                                  </div>
                               	</div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Confirm Password<span class="required">*</span></label>
                                  <div class="controls">
                                  <input type="password" name="conf_password" id="conf_password" class="m-wrap span8"/>
                                  </div>
                               	</div>
                              </div>
                           </div>
                           <!-- End of Second Section -->
                           
                           <!-- Third Section -->
                     		<div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Gender<span class="required">*</span></label>
                                  <div class="controls">
                                     <label class="radio line">
                                   <input type="radio" name="gender" value="male" />
                                    Male 
                                    </label>
                                    <label class="radio line">
                                    <input type="radio" name="gender" value="female" />
                                    Female 
                                    </label>
                                    <div id="new_user_gender_error"></div> 
                                  </div>
                               	</div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Date of Birth</label>
                                  <div class="controls">
                                     <input class="m-wrap span6 date-picker tooltips" data-original-title="Select date from datepicker" size="16" type="text" id="date_of_birth" name="date_of_birth" />
                                  </div>
                               </div>
                              </div>
                           </div>
                           <!-- End of Third Section -->
                           
                           <!-- Fourth Section -->
                           <div class="row-fluid">
                              <div class="span6 ">
                              	<div class="control-group">
                              <label class="control-label">E-mail<span class="required">*</span></label>
                              <div class="controls">
                                 <input name="email" id="email" type="text" class="m-wrap span8 tooltips" data-original-title="Please write valid email address" placeholder="example@test.com"/>
                              </div>
                           </div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Phone Number</label>
                                  <div class="controls">
                                     <input type="digits" name="phone" id="phone" class="m-wrap span8 tooltips" data-original-title="Please write valid phone number" placeholder="0093789182912"/>
                                  </div>
                               	</div>
                              </div>
                           </div>
                           <!-- End of Fourth Section -->
                           <!-- End of Personal Information -->
                           
                           <!-- Address Section -->
                           <h3 class="form-section">Address</h3>
                           <!-- Fifth Section -->
                           <div class="row-fluid">
                              <div class="span6 ">
                              <div class="control-group">
                                  <label class="control-label">Country<span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span6 m-wrap" name="country" id="country">
                                        <option value="" selected disabled> -- Select Country -- </option>
                                        <?php $country_result = $database->query("SELECT * FROM country");
											while($country = $database->fetch_array($country_result)) { ?>
                                        <option value="<?php echo $country['Code']; ?>">
										<?php echo $country['Name']; ?></option>
                                        <?php } ?>
                                     </select>
                                  </div>
                               </div>
                              </div>
                              <div class="span6 ">
                              <div class="control-group">
                                  <label class="control-label">State/city <span class="required">*</span></label>
                                  <div class="controls">
                                     <select class="span6 m-wrap" name="state" id="state">
                                     
                                     </select>
                                  </div>
                               </div>
                              </div>
                           </div>
                           <!-- End of Fifth Section -->
                           
                           <!-- Sixth Section -->
                           <div class="row-fluid">
                              
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Zip Code <span class="required">*</span></label>
                                  <div class="controls">
                                   <input type="text" name="zip_code" id="zip_code" class="m-wrap span3" placeholder="0093"/>
                                  </div>
                               	</div>
                              </div>
                           </div>
                           <!-- End of Sixth Section -->
                           <!-- End of Address section -->
                           
                           <!-- Other Section -->
                           <h3 class="form-section">Other</h3>
                           <!-- Seventh Section -->
                           <div class="row-fluid">
                              <div class="span6 ">
                              <div class="control-group">
                                  <label class="control-label">Category</label>
                                  <div class="controls">
                                     <select class="span6 m-wrap" name="category" id="category">
                                        <option value="" selected disabled> -- Select Category --</option>
                                        <?php $sql = $database->query("SELECT * FROM user_group");
											while($row = $database->fetch_array($sql)) { ?>
                                            <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['group_name']; ?> </option>
                                        <?php } ?>
                                     </select>
                                  </div>
                               </div>
                              </div>
                            <div class="span6 ">
                              	<div class="control-group">
                                  <label class="control-label">Status<span class="required">*</span></label>
                                  <div class="controls">
                                     <label class="radio line">
                                    <input type="radio" name="status" value="active" checked />
                                    Active
                                    </label>
                                    <label class="radio line">
                                    <input type="radio" name="status" value="deactive" />
                                    Deactive
                                    </label>
                                    <div id="new_user_status_error"></div> 
                                  </div>
                               	</div>
                              </div>
                           </div>
                           <!-- End of Seventh Section -->
                           
                           <!-- Eieght Section -->
                           <div class="row-fluid">
                              <!-- BEGIN span12 -->
                              <div class="span12">
                              	<!-- BEGIN control-group -->
                                <div class="control-group">
                              <label class="control-label">Profile Picture</label>
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
                                       <input type="file" name="user_photo" id="user_photo" class="default" /></span>
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
                   </div>
                   <!-- End of Eieght Section -->
                           <!-- Ninth Section -->
                           <div class="form-actions">
                              <button type="submit" name="submit" id="submit" class="btn green button-submit">Create <i class="m-icon-swapright m-icon-white"></i></button>
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
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>