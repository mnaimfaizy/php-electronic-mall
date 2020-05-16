<?php
	require_once("includes/initialize.php");
	
	if($session->is_logged_in()) {
		redirect_to("index.php");	
	}
	
	$message = "";
	// Remember to give your form's submit tag a name="submit" attribute!
	if(isset($_POST['submit'])) { // Form has been submitted.
		
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		// Check database to see if username/password exist
		$found_user = User::authenticate($username, $password);
		if($found_user) {
			$session->login($found_user);
			//log_action('Login', "{$found_user->username} logeed in.");
			redirect_to("index.php");	
			/*echo "<script> alert('Login Successfull'); </script>";*/
		} else {
			// username/password combo was not found in the database
			$message = true;
			/*echo "<script> alert('Login was not successful'); </script>";*/	
		}
	} else { // Form has not been submitted
		$username = "";
		$password = "";	
	}
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <meta charset="utf-8" />
  <title>E-mall | Login </title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/metro.css" rel="stylesheet" />
  <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/style_responsive.css" rel="stylesheet" />
  <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
  <link rel="stylesheet" type="text/css" href="assets/plugins/uniform/css/uniform.default.css" />
  <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="logo">
    <img src="images/logo.png" alt="E-mall" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
  	<?php if(isset($message) && $message == true) { ?>
    	<div class="alert alert-error">
            <button class="close" data-dismiss="alert"></button>
            <strong>Error!</strong> The username OR password is incorret.
        </div>
    <?php } ?>
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" action="login.php" method="post">
      <h3 class="form-title">Login to your account</h3>
      <div class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span>Enter your username and passowrd.</span>
      </div>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap span6 placeholder-no-fix" type="text" placeholder="Username" name="username" autofocus/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap span6 placeholder-no-fix" type="password" placeholder="Password" name="password"/>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <label class="checkbox">
        <input type="checkbox" name="remember" value="1"/> Remember me
        </label>
        <button type="submit" name="submit" class="btn green pull-right">
        Login <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
    </form>
    <!-- END LOGIN FORM --> 
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    <?php echo date("Y", time()); ?> &copy; E-mall shopping center.
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="assets/js/jquery-1.8.3.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>  
  <script src="assets/plugins/uniform/jquery.uniform.min.js"></script> 
  <script src="assets/js/jquery.blockui.js"></script>
  <script type="text/javascript" src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="assets/js/app.js"></script>
  <script>
    jQuery(document).ready(function() {     
      // App.initLogin();
    });
  </script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>