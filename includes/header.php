<?php date_default_timezone_set('Asia/Kabul'); ?>
<?php require_once('admin/includes/initialize.php'); ?>
<?php $page_name = get_page_name(); ?>
<?php
if($_SERVER['HTTP_HOST'] == 'localhost') {
	$hostname = $_SERVER['HTTP_HOST'] . "/E-Mall";
} else {
	$hostname = $_SERVER['HTTP_HOST'];
}
global $database;
// Check for User authuntication
	if(isset($_POST['loginBtn'])) { // Form has been submitted.
		
		$email = trim($_POST['username']);
		$password = trim($_POST['password']);
		$password = md5($password);
		@$remember = $_POST['remember'];
		// Check database to see if username/password exist
		$sql = "SELECT * FROM customer WHERE email='$email' AND password='$password' LIMIT 1";
		$result = $database->query($sql);
		if($row = $database->fetch_array($result)) {
			if($remember == "on") {
				$key = "true";
				setcookie("customer_id", $row['customer_id'], time()+7200);
				setcookie("customer_name", $row['customer_name'], time()+7200);
				setcookie("key", $key, time()+7200);
			} else {
				$_SESSION['customer_id'] = $row['customer_id'];
				$_SESSION['customer_name'] = $row['customer_name'];
				$_SESSION['key'] = "true";
			}
			redirect_to("index.php");	
		} else {
			$ErrorMessage = true;	
		}
	} else { // Form has not been submitted
		$email = "";
		$password = "";	
	}

// Check if the email is send and give a message

if(isset($_GET['emailResult'])) {
	if($_GET['emailResult'] == true) { $_SESSION['sendEmailResult'] = true; }
	else if($_GET['emailResult'] == false) { $_SESSION['sendEmailResult'] = false; }	
	
	$page_name = $_SERVER['PHP_SELF'];
	$locaction = "http://".$hostname."/".$page_name;
	echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$locaction.'">';
	exit;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if($page_name == 'index.php') { echo 'Home | E-mall'; 
    	   		} elseif($page_name == 'all_brands.php') { echo 'All Brands | E-mall'; 
				} elseif($page_name == 'all_categories.php') { echo 'All Categories | E-mall';
				} elseif($page_name == 'brands.php') { echo 'Brands | E-mall';
				} elseif($page_name == 'cancel_order.php') { echo 'Cancel Order | E-mall';
				} elseif($page_name == 'cart.php') { echo 'Cart | E-mall';
				} elseif($page_name == 'checkout.php') { echo 'Checkout | E-mall';
				} elseif($page_name == 'contact_us.php') { echo 'Contact US | E-mall';
				} elseif($page_name == 'login.php') { echo 'Login | E-mall';
				} elseif($page_name == 'orders.php') { echo 'Orders | E-mall';
				} elseif($page_name == 'product_detail.php') { echo 'Product Detail | E-mall';
				} elseif($page_name == 'products.php') { echo 'Products | E-mall';
				} elseif($page_name == 'thankyou.php') { echo 'Thank You | E-mall'; 
				} else { echo 'E-Mall'; }
			?>
    </title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- Search Box CSS file -->
    <link rel="stylesheet" href="css/search_style.css">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/png" />
        <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/images/faviconapple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
        <link rel="manifest" href="images/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
    <!-- End Favicon -->
    <!-- Popup window Style -->
    
    <style type="text/css">
    
    #mask {
      position:absolute;
      left:0;
      top:0;
      z-index:9000;
      background-color:#000;
      display:none;
    }  
    #boxes .window {
      position:absolute;
      left:0;
      top:0;
      width:500px;
      height:300px;
      display:none;
      z-index:9999;
      padding:20px;
    }
    #boxes #dialog {
      width:450px; 
      height:300px;
      padding:10px;
      background-color:#ffffff;
    }
	/* ---------------------------------------------- */
	/* For form validation error and success */
	.has-error {
		color: #a94442;
	}
	.has-error .form-group {
		border-color: #a94442;
		-webkit-box-shadow: inset 0 1px rgba(0, 0, 0, .075);
				box-shadow: inset 0 1px rgba(0, 0, 0, .075);
	}
	.has-error .form-control {
		border: 1px solid #a94442 !important;
	}
	.has-error .form-group:focus {
		border-color: #843534;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
				box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #ce8483;
	}
	.has-success {
		color: #2b542c;
	}
	.has-success .form-group {
		border-color: #3c763d;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
				box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);	
	}
	.has-success .form-control {
		border: 1px solid #2b542c !important;
	}
	.has-success .form-control:focus {
		border-color: #2b542c;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #67b168;
				box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 6px #67b168;	
	}
	.error {
		color: #a94442;
	}
	.star-rating {
		line-height: 32px;
		font-size: 1.25em;
		cursor: pointer;
	}
	.fa-star-o {
		color: #FE980F;
	}
	.fa-star {
		color: #FE980F;
	}
/* ---- Style for custom Alert box ----- */
#dialogoverly {
	display: none;
	opacity: .8;
	position: fixed;
	top: 0px;
	left: 0px;
	background: #FFFFFF;
	width: 100%;
	z-index: 10;	
}
#dialogbox {
	display: none;
	position: fixed;
	background: #FFFFFF;
	border: 1px	 solid #B3B3B3;
	-webkit-border-radius: 7px;
	-moz-border-radius: 7px;
	-o-border-radius: 7px;
	border-radius: 7px;
	z-index: 10;	
	box-shadow: inset 0px 0px 5px 1px #B3B3B3;
	width: 500px;
}
#dialogbox > div{ 
	background: #FFF; margin: 10px; 
}
#dialogbox > div > #dialogboxhead { 
	background: #D5D5D5; font-size: 15px; padding: 10px; color: #FFFFFF; }
#dialogbox > div > #dialogboxbody { background: #FFFFFF; padding: 20px; color: #3D3D3D; }
#dialogbox > div > #dialogboxfoot { background: #D5D5D5; padding: 10px; text-align: right; }
    </style>
    
    <!-- End Popup Window Style -->
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +93 123 456 789</a></li>
								<li><a href="mailto:info@e-mall.96.lt"><i class="fa fa-envelope"></i> email@yourdomain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" target="_blank"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/home/logo.png" alt="E-mall - What you see is what you get" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
                         <?php if((isset($_SESSION['key']) || isset($_COOKIE['key'])) && 
						 		(@$_SESSION['key'] == 'true' || @$_COOKIE['key'] == 'true')) { ?>
								<li><a><i class="fa fa-user"></i> 
						<?php if(isset($_SESSION['customer_name'])) { echo $_SESSION['customer_name']; } 
								elseif(isset($_COOKIE['customer_name'])) { echo $_COOKIE['customer_name']; } ?></a></li>
                         <?php } elseif((!isset($_SESSION['key']) || !isset($_COOKIE['key'])) && (@$_SESSION['key'] != 'true' || @$_COOKIE['key'] != 'true')) { ?>
                         		<li><a><i class="fa fa-user"></i> Guest</a></li>
                         <?php } ?>
								<li><a href="checkout.php"><i class="fa fa-crosshairs"></i> Checkout</a></li>
								<li><a href="cart.php"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                         <?php if((isset($_SESSION['key']) || isset($_COOKIE['key'])) && (@$_SESSION['key'] == 'true' || @$_COOKIE['key'] == 'true')) { ?>
                         		<li><a href="logout.php?status=logout"><i class="fa fa-unlock-alt"></i> Logout</a></li>
                         <?php } elseif((!isset($_SESSION['key']) || !isset($_COOKIE['key'])) && (@$_SESSION['key'] != 'true' || @$_COOKIE['key'] != 'true')) { ?>
								<li><a href="login.php"><i class="fa fa-lock"></i> Login</a></li>
                         <?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->