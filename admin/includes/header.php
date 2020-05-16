<?php date_default_timezone_set('Asia/Kabul'); ?>
<?php require_once("includes/initialize.php"); ?>
<?php if(!$session->is_logged_in()) { redirect_to("login.php"); } ?>
<?php $page_name = get_page_name(); ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>
    <?php if($page_name == 'index.php') { ?>
    E-mall | <?php echo 'Dashboard'; ?>
    <?php } elseif($page_name == 'new_user.php') { ?>
    E-mall | <?php echo 'New User'; ?>
    <?php } elseif($page_name == 'product_category.php') { ?>
    E-mall | <?php echo 'Product Category'; ?>
    <?php } elseif($page_name == 'product_sub_category.php') { ?>
    E-mall | <?php echo 'Product Sub-Category'; ?>
    <?php } elseif($page_name == 'brand.php') { ?>
    E-mall | <?php echo 'Product Brands'; ?>
    <?php } elseif($page_name == 'product.php') { ?>
    E-mall | <?php echo 'Add Product'; ?>
    <?php } elseif($page_name == 'product_list.php') { ?>
    E-mall | <?php echo 'Products List'; ?>
    <?php } ?>
    </title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/metro.css" rel="stylesheet" />
	<link href="assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <!-- This script is used for file upload -->
    <link href="assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" />
	<link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/plugins/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style_responsive.css" rel="stylesheet" />
    <link href="assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/plugins/gritter/css/jquery.gritter.css" />
	<link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/chosen-bootstrap/chosen/chosen.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <!-- This script is used for date picker on form fileds -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="assets/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
    <link rel="stylesheet" href="assets/plugins/data-tables/DT_bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/uniform/css/uniform.default.css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top" style="padding:5px 0px;">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="index.php">
				<img src="images/logo.png" width="120" height="20" alt="logo" />
				</a>
				<!-- END LOGO -->