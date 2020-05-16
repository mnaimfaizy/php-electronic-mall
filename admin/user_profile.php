<?php include_once("includes/header.php"); ?>
<?php global $database;
$user_id = $_SESSION['user_id'];
if(isset($_POST['submit'])) {
	@$name = $database->escape_value($_POST['name']);
	@$username = $database->escape_value($_POST['username']);
	if(isset($_POST['new_password']) && !empty($_POST['new_password'])) {
		$new_password = $database->escape_value($_POST['new_password']);
		$password = md5($new_password);
	} else {
		$password = $_POST['old_password'];
	}
	@$country = $database->escape_value($_POST['country']);
	if(isset($_POST['state']) && !empty($_POST['state'])) {
		$state = $database->escape_value($_POST['state']);
	} else {
		$state = $_POST['old_state'];
	}
	@$zip_code = $database->escape_value($_POST['zip_code']);
	@$email = $database->escape_value($_POST['email']);
	@$phone = $database->escape_value($_POST['phone']);
	@$date = $database->escape_value($_POST['birthday']);
	@$date1 = DateTime::createFromFormat('d/m/Y', $date);
	@$new_date = $date1->format('Y-m-d');
	@$birthday = strtotime($new_date);
	@$gender = $database->escape_value($_POST['gender']);
	if(isset($_FILES['new_photo'])) {
		$file = $_FILES['new_photo'];
		$photo = basename($file['name']);
	} else {
		$photo = $_POST['old_photo'];
	}
	$sql = "UPDATE `user` SET `username`='$username',`password`='$password',`name`='$name',`gender`='$gender',`date_of_birth`=$birthday,`email`='$email',`phone`='$phone',`country`='$country',`state`=$state,`zip_code`='$zip_code',`photo`='$photo' WHERE id=$user_id LIMIT 1";
	
	if($database->query($sql)) {
		// Upload image 
		
		if(isset($_FILES['new_photo']) && !empty($_FILES['new_photo'])) {
			$file 			= $_FILES['new_photo'];
			$temp_path		= $file['tmp_name'];
			$filename		= basename($file['name']);
			$type			= $file['type'];
			$size			= $file['size'];
			
			// Determine the target Path
			$target_path = 'images/users/'.$filename;
			
			// Attempt to move the file
			if(move_uploaded_file($temp_path, $target_path)) {
				// Success
				$old_photo = $_POST['old_photo'];
				unlink('images/users/'.$old_photo);
			} else {
				// File was not moved
				echo '<script> alert("The file upload failed, possibly due to incorrect permissions on the upload folder."); </script>';
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
    <?php if(isset($_SESSION['user_id'])) { ?>
    <?php $sql = $database->query("SELECT * FROM user WHERE id={$_SESSION['user_id']} LIMIT 1");
		$user = $database->fetch_array($sql); ?>
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
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
						</div>
						<!-- END BEGIN STYLE CUSTOMIZER --> 
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							<?php echo $user['name']; ?> Profile
						</h3>
						<ul class="breadcrumb">
							<?php echo breadcrumb(); ?>
                        </ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid profile">
					<div class="span12">
                    <?php 
						if(isset($result)) {
						if($result == true) {
                               echo '<div class="alert alert-success">
									  <button class="close" data-dismiss="alert"></button>
									  Your profile has been updated successfully!
								   	 </div>';
						} else if($result == false) {
                           	echo '<div class="alert alert-error">
                                  	<button class="close" data-dismiss="alert"></button>
                                  	Please check your entry, record updation was unsuccessfull.
                               	  </div>';
                        }	// End second IF
						} // End First IF ?>
						<!--BEGIN TABS-->
						<div class="tabbable tabbable-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab_1_1" data-toggle="tab">Overview</a></li>
								<li><a href="#tab_1_2" data-toggle="tab">Profile Info</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane row-fluid active" id="tab_1_1">
									<ul class="unstyled profile-nav span3">
										<li><img src="images/users/<?php echo $user['photo']; ?>" alt="<?php echo $user['name']; ?>" width="270" height="300" /></li>
									</ul>
									<div class="span9">
										<div class="row-fluid">
											<div class="span7 profile-info">
												<h1><?php echo $user['name']; ?></h1>
												<p>Bellow are some information related to <strong> <?php echo $user['name']; ?> </strong> user, you can brink changes at the profile info tab.</p>
												<p><a href="mailto:<?php echo $user['email']; ?>">
												<?php echo $user['email']; ?></a></p>
												<ul class="unstyled inline">
													<li><i class="icon-map-marker"></i> <?php echo $user['country']; ?></li>
													<li><i class="icon-calendar"></i> <?php echo date('d/m/Y', $user['date_of_birth']); ?> </li>
													<li><i class="icon-briefcase"></i> <?php echo $user['group_id']; ?></li>
													<li><i class="icon-phone"></i> <?php echo $user['phone']; ?></li>
													<li><i class="icon-heart"></i> <?php echo $user['gender']; ?></li>
												</ul>
											</div>
											<!--end span8-->
											<div class="span5">
												<div class="portlet sale-summary">
													<div class="portlet-title">
														<h4> User Info</h4>
														<div class="tools">
															<a class="reload" href="javascript:;"></a>
														</div>
													</div>
													<ul class="unstyled">
														<li>
															<span class="sale-info">E-MAIL</span> 
															<span class="sale-num"><?php echo $user['email']; ?></span>
														</li>
														<li>
															<span class="sale-info">PHONE </span> 
															<span class="sale-num"><?php echo $user['phone']; ?></span>
														</li>
														<li>
															<span class="sale-info">DATE of BIRTH</span> 
															<span class="sale-num"><?php echo date('d/m/Y', $user['date_of_birth']); ?></span>
														</li>
														<li>
															<span class="sale-info">GENDER</span> 
															<span class="sale-num"><?php echo $user['gender']; ?></span>
														</li>
													</ul>
												</div>
											</div>
											<!--end span4-->
										</div>
										<!--end row-fluid-->
									</div>
									<!--end span9-->
								</div>
								<!--end tab-pane-->
								<div class="tab-pane profile-classic row-fluid" id="tab_1_2">
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="user_update_form" id="user_update_form" method="post" enctype="multipart/form-data" />
                                    <div class="span2"><img src="images/users/<?php echo $user['photo']; ?>" alt="<?php echo $user['name']; ?>" /> 
                                    <p> Update Profile Photo </p>
                                    <input type="file" name="new_photo" id="new_photo" />
                                    <input type="hidden" name="old_photo" id="old_photo" value="<?php echo $user['photo']; ?>" />
                                    </div>
									
                                    <ul class="unstyled span10">
										<li><span>User Name:</span>
                                        <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" class="form-horizontal" /></li>
										<li><span>Name:</span>
                                        <input type="text" name="name" id="name" value="<?php echo $user['name']; ?>" class="form-horizontal" /></li>
										<li><span>Password:</span> 
                                        <input type="password" name="new_password" id="new_password" placeholder="Type your new Pssword" class="form-horizontal form-section" />
                                        <input type="hidden" name="old_password" id="old_password" value="<?php echo $user['password']; ?>" />
                                        </li>
										<li><span>Counrty:</span> 
										<select name="country" id="country">
										<?php $country_code = $user['country']; 
											$sqll = $database->query("SELECT * FROM country");
											while($country = $database->fetch_array($sqll)) { ?>
                                        	<option value="<?php echo $country['Code']; ?>" 
                                        <?php if($country_code == $country['Code']) { echo 'selected="selected"'; } ?>>
                                            	<?php echo $country['Name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select></li>
                                        <li><span>State:</span> 
										<?php $state = $user['state']; $sqlll = $database->query("SELECT * FROM city WHERE id=$state LIMIT 1");
										$state = $database->fetch_array($sqlll);
										echo $state['Name']; ?>
                                        <select name="state" id="state"></select>
                                        <input type="hidden" name="old_state" id="old_state" value="<?php echo $user['state']; ?>" />
                                        </li>
										<li><span>Zip Code:</span> <input type="text" name="zip_code" id="zip_code" value="<?php echo $user['zip_code']; ?>" class="form-horizontal" /></li>
                                        <li><span>Birthday:</span> 
										<input type="text" name="birthday" id="birthday" value="<?php echo date('d/m/Y',$user['date_of_birth']); ?>" class="form-horizontal" placeholder="30/12/2015" /></li>
										<li><span>Phone:</span> 
										<input type="text" name="phone" id="phone" value="<?php echo $user['phone']; ?>" class="form-horizontal" /></li>
										<li><span>Email:</span> <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>" class="form-horizontal" /></li>
										<li><span>Gender:</span> 
                                        <select name="gender" id="gender">
                                        	<option value="male" <?php if($user['gender'] == 'male') { echo 'selected="selected"'; } ?>> Male </option>
                                            <option value="female" <?php if($user['gender'] == 'female') { echo 'selected="selected"'; } ?>> Female </option>
                                        </select>
                                        </li>
                                        <li> 
                                        <input type="submit" name="submit" value="UPDATE" class="btn btn-success form-actions" />
                                        </li>
									</ul>
                                    </form>
								</div>
							</div>
						</div>
						<!--END TABS-->
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<!-- END PAGE CONTAINER-->
           <?php } else { ?>
           <div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
                    	<h2> Please select user first, to show his/her details. </h2>
                    </div>
                </div>
           </div>
           </div>
           <?php } ?>	
		</div>
		<!-- END PAGE -->	 	
	</div>
	<!-- END CONTAINER -->

<?php include_once("includes/footer.php"); ?>