<?php include 'includes/header.php'; ?>
<?php
	// Sign Up customer
	if(isset($_POST['signUpBtn'])) {
		$name = $database->escape_value($_POST['name']);
		$email = $database->escape_value($_POST['email']);
		$password = $database->escape_value($_POST['password']);
		$password = md5($password);
		$date_added = time();
		$sql = "INSERT INTO `customer`(`customer_name`, `email`, `password`, `date_added`) VALUES ('$name','$email','$password', $date_added)";
		if($database->query($sql)) {
			$msg = true;	
		} else {
			$msg = false;
		}
	}
?>
	<?php include 'includes/navigation.php'; ?>
    	<div class="container">
            <div class="row">
                <div class="col-sm-12">
                <?php require('includes/breadcrumb.php'); ?>
                </div>
            </div>
        </div>
		<section id="form"><!--form-->
		<div class="container" style="margin-top: -50px;">
        	
        	<div class="row">
        	<div class="col-sm-9 col-sm-offset-1">
            <?php if(isset($msg)) { 
				if($msg == true) { ?>
            	<div class="alert alert-success" role="alert"> Weldone! Your account has been created succsessfully <i class="fa fa-smile-o"></i> </div>
           <?php } elseif($msg == false) { ?>
                <div class="alert alert-danger" role="alert"> Oh Snap! Your registration has been failed, please try again <i class="fa fa-frown-o"></i> </div>
          <?php } 
			}	?>
            
            <?php if(isset($ErrorMessage) && @$ErrorMessage == true) { ?>
            <div class="alert alert-danger" role="alert"> Oh Snap! Username or Password is incorrect, please try again. <i class="fa fa-frown-o"></i> </div>
            <?php } ?>
            </div>
        </div>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form action="login.php" method="post">
							<input type="text" name="username" id="username" placeholder="Email Address" />
							<input type="password" name="password" id="password" placeholder="Password" />
							<span>
								<input type="checkbox" name="remember" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" name="loginBtn" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form action="login.php" method="post" id="signup">
							<input type="text" name="name" id="name" placeholder="Name"/>
							<input type="email" name="email" id="email" placeholder="Email Address"/>
							<input type="password" name="password" id="password" placeholder="Password"/>
							<button type="submit" name="signUpBtn" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
    
<?php include 'includes/footer.php'; ?>