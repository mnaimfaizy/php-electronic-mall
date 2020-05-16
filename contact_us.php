<?php include 'includes/header.php'; ?>	
<?php 
	
	if(isset($_GET['res'])) {
		if($_GET['res'] == true) { $_SESSION['errorMessage'] = true; }
		else if($_GET['res'] == false) { $_SESSION['errorMessage'] = false; }	
		
		$page_name = $_SERVER['PHP_SELF'];
		$locaction = "http://".$hostname."/".$page_name;
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$locaction.'">';
		exit;
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
	<div id="contact-page" class="container">
    	<div class="bg">
        <!-- Error Message Placement -->
        <?php if(isset($_SESSION['errorMessage'])) { ?>
         		<?php // Check if $_GET['res'] == tre 
					if($_SESSION['errorMessage'] == true) { ?>
                    <div class="row">  	
	    				<div class="col-sm-12">
                        	<h2> Thanks for reaching to us and letting us know your opinion. </h2>
                            <p> We will contact you back as soon as possible. </p>
                        </div>
                    </div>
                <?php } // Check if $_GET['res'] == false 
					elseif ($_SESSION['errorMessage'] == false) { ?>
					<div class="row">  	
	    				<div class="col-sm-12">
                        	<h2 style="color: #C71518;"> Sorry! we were unable to sent your message. </h2>
                            <p> Please try again <a href="contact_us.php"> Click Me </a> </p>
                        </div>
                    </div>
				<?php } unset($_SESSION['errorMessage']); ?>
         <?php }  ?>  
        <!-- End Error Message Placement -->
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					<h2 class="title text-center">Contact <strong>Us</strong></h2>    			    				    				
					<div id="gmap" class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3288.152822547093!2d69.14389378027565!3d34.499009750095496!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1430539038885" width="1140" height="385" frameborder="0" style="border:0"></iframe>
					</div>
				</div>			 		
			</div> 
             	
    		<div class="row">  	
	    		<div class="col-sm-8">
	    			<div class="contact-form">
	    				<h2 class="title text-center">Get In Touch</h2>
	    				<div class="status alert alert-success" style="display: none"></div>
				    	<form action="sendemail.php" id="main-contact-form" class="contact-form row" name="contact-form" method="post">
				            <div class="form-group col-md-6">
				                <input type="text" name="name" id="name" class="form-control" required="required" placeholder="Name">
				            </div>
				            <div class="form-group col-md-6">
				                <input type="email" name="email" id="email" class="form-control" required="required" placeholder="Email">
				            </div>
				            <div class="form-group col-md-12">
				                <input type="text" name="subject" id="subject" class="form-control" required="required" placeholder="Subject">
				            </div>
				            <div class="form-group col-md-12">
				                <textarea name="message" id="message" required class="form-control" rows="8" placeholder="Your Message Here"></textarea>
				            </div>                        
				            <div class="form-group col-md-12">
				                <input type="submit" name="submit" id="submit" class="btn btn-primary pull-right" value="Submit">
				            </div>
				        </form>
	    			</div>
	    		</div>
	    		<div class="col-sm-4">
	    			<div class="contact-info">
	    				<h2 class="title text-center">Contact Info</h2>
	    				<address>
	    					<p>E-mall Inc.</p>
							<p>Street# 23, District 3, Karat-e-Chahar, Kabul</p>
							<p>Kabul AFG</p>
							<p>Mobile: +744 25 24 11</p>
							<p>Fax: None</p>
							<p>Email: e-mall@mnfprofile.com</p>
	    				</address>
	    				<div class="social-networks">
	    					<h2 class="title text-center">Social Networking</h2>
							<ul>
								<li>
									<a href="https://www.facebook.com/mnaimfaizy" target="_blank"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="https://twitter.com/Naim_Soft" target="_blank"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="https://plus.google.com/+mnaimfaizy/"><i class="fa fa-google-plus"></i></a>
								</li>
								<li>
									<a href="https://www.youtube.com/channel/UCoWi6CcvqwFMHFPWw0FD7Gg"><i class="fa fa-youtube"></i></a>
								</li>
							</ul>
	    				</div>
	    			</div>
    			</div>    			
	    	</div>
         
    	</div>	
    </div><!--/#contact-page-->
    
    
<?php include 'includes/footer.php'; ?>