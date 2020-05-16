	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>E</span>-mall</h2>
							<p> is the place which gives you the easiness you desire, here you will get what you seek. </p>
						</div>
					</div>
					<div class="col-sm-7">
						<?php $sql = "SELECT * FROM brand LIMIT 4";
							$r = $database->query($sql);
							while($brands = $database->fetch_array($r)) { ?>
                        <div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="images/brands/<?php echo $brands['brand_image']; ?>" alt="<?php echo $brands['brand_name']; ?>" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-check-circle"></i>
                                        
									</div>
								</a>
								<p><?php echo $brands['brand_name']; ?></p>
							</div>
						</div>
						<?php } ?>
						
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p>Kabul, AF(Afghanistan)</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="contact_us.php">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Quick Shop</h2>
							<ul class="nav nav-pills nav-stacked">
                            <?php
								$sql = "SELECT * FROM product_category WHERE status='active' ORDER BY RAND() LIMIT 5";
								$result = $database->query($sql);
								while($category = $database->fetch_array($result)) {
							?>
								<li>
                                	<a href="products.php?category_id=<?php echo $category['category_id']; ?>">
										<?php echo $category['category_name']; ?>
                                    </a>
                                </li>
                            <?php } ?>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Choose Brand</h2>
							<ul class="nav nav-pills nav-stacked">
								<?php
								$sql = "SELECT * FROM brand WHERE status='active' ORDER BY RAND(brand_id) LIMIT 5";
								$result = $database->query($sql);
								while($category = $database->fetch_array($result)) {
							?>
								<li>
                                	<a href="products.php?category_id=<?php echo $category['brand_id']; ?>">
										<?php echo $category['brand_name']; ?>
                                    </a>
                                </li>
                            <?php } ?>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Company Information</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Store Location</a></li>
								<li><a href="#">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>About E-mall</h2>
							<form action="sendemail.php" method="post" class="searchform" id="sendEmailForm">
								<input type="text" name="email_address" id="email_address" placeholder="Your email address" />
                                <input type="hidden" name="customer_name" value="
                                <?php if(!empty($_SESSION['customer_name'])) { echo $_SESSION['customer_name']; }
										elseif(empty($_SESSION['customer_name']) && !empty($_COOKIE['customer_name'])) {
											echo $_COOKIE['customer_name']; } else { echo 'Guest'; } ?>" />
                                <input type="hidden" name="page_name" value="<?php echo $_SERVER['PHP_SELF']; ?>" />
								<button type="submit" name="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated...</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
        
        
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © <?php echo date("Y"); ?> E-mall Inc. All rights reserved.</p>
					<p class="pull-right">Developed by <span><a target="_blank" href="https://github.com/mnaimfaizy">Mohammad Naim Faizy</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	
<div id="dialogoverly"></div>
<div id="dialogbox">
	<div>
    	<div id="dialogboxhead"></div>
        <div id="dialogboxbody"></div>
        <div id="dialogboxfoot"></div>
    </div>
</div>
  
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/additional-methods.min.js"></script>
    <!-- Script of Magnifying images -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!-- Search box script -->
    <script src="js/search_script.js"></script>
    <script src="js/load_states.js"></script>
    <!-- This script counts the shippment cost of the product -->
	<script type="text/javascript">
		$('#submitShipmentInfo').on('click', function() {
					var country = $('#country').val();
					var state = $('#state').val();
				$.get('ajax/calculate_shipment.php?country_code=' + country + '&state=' + state, function(data) { 
				data = '$' + data;
				$("#shipping_cost").html(data);
				//alert(data);
				})
		});
	</script>
    
    <script type="text/javascript">
function CustomAlert() {
	this.render = function(dialog) {
		var winW = window.innerWidth;
		var winH = window.innerHeight;
		var dialogoverly = document.getElementById('dialogoverly');
		var dialogbox = document.getElementById('dialogbox');
		dialogoverly.style.display = "block";
		dialogoverly.style.height = winH+"px";
		dialogbox.style.left = (winW/2) - (550 * .5)+"px";
		dialogbox.style.top = "100px";
		dialogbox.style.display = "block";
		document.getElementById('dialogboxhead').innerHTML = "Message";
		document.getElementById('dialogboxbody').innerHTML = dialog;
		document.getElementById('dialogboxfoot').innerHTML = '<button onclick="Alert.ok()">OK</button>';	
	}
	this.ok = function() {
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverly').style.display = "none";	
	}
}
var Alert = new CustomAlert();
</script>
    <script type="text/javascript">
		$(document).ready(function() {
			
			// Validating Checkout Form 
			$("#checkout").validate({
				rules: {
					bill_companyName: { required: true },
					bill_email: { required: true, email: true },
					bill_firstname: { required: true },
					bill_lastname: { required: true },
					bill_address1: { required: true },
					bill_zip: { required: true },
					bill_country: { required: true },
					bill_state: { required: true },
					bill_phone: { required: true },
					shipping_order: { required: true }
				}
			});
			// End of Validation
			
			// Validating Send Email Form 
			$("#sendEmailForm").validate({
				rules: {
					email_address: {
						required: true,
						email: true
					}
				},
				messages: {
					email: {
						required: "Please enter valid email address",
						email: "Your e-mail address is not valid"
					}
				}
			});
			// End of Validation
			
			// Validating Contact Form 
			$("#main-contact-form").validate({
				rules: {
					name: {
						required: true,
						minlength: 4
					},
					email: {
						required: true,
						email: true
					},
					subject: {
						required: true,
						minlenght: 4
					},
					message: {
						required: true
					}
				},
				messages: {
					name: {
						required: "Please enter valid name",
						minlength: "The name must be greater than 4 characters"
					},
					email: {
						required: "Please enter valid email address",
						email: "The email must be correct"
					},
					subject: {
						required: "Subject is required",
						minlenght: "The subject must be greater than 4 characters"
					},
					message: {
						required: "Message is required"
					}
				},
				highlight: function (element) { // hightlight error inputs
					
					$(element).parents('.form-group').addClass('has-error');
				},
				unhighlight: function (element) { // revert the change dony by hightlight
					$(element).parents('.form-group').addClass('has-success');
					$(element).parents('.form-group').removeClass('has-error');
				}
			});
			// End of Validation
			
			// Validating signup Form 
			$("#signup").validate({
				rules: {
					name: {
						required: true,
						minlength: 4
					},
					email: {
						required: true,
						email: true
					},
					password: {
						required: true,
						minlenght: 4
					}
				},
				messages: {
					name: {
						required: "Please enter valid name",
						minlength: "The name must be at least 4 characters"
					},
					email: {
						required: "Please enter valid email address",
						email: "The email must be correct"
					},
					password: {
						required: "This field is required",
						minlenght: "The password must be at least 4 characters"
					}
				}
			});
			// End of Validation
			
			// Validating Review Form 
			$("#review_form").validate({
				rules: {
					name: {
						required: true,
						minlength: 4
					},
					email: {
						required: true,
						email: true
					},
					review: {
						required: true
					}
				},
				messages: {
					name: {
						required: "Please enter valid name",
						minlength: "The name must be greater than 4 characters"
					},
					email: {
						required: "Please enter valid email address",
						email: "The email must be correct"
					},
					message: {
						required: "Review is required"
					}
				}
			});
			// End of Validation
			
			// Magnifing the Images
			$('.test-popup-link').magnificPopup({
				type: 'image'
			});
			
			$('.gallery-item').magnificPopup({
				type: 'image',
				gallery:{
					enabled: true
				}
			});
			
			// Star Rating Script
			var $star_rating = $('.star-rating .fa');
			
			var SetRatingStar = function() {
				return $star_rating.each(function() {
                    if(parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
						return $(this).removeClass('fa-star-o').addClass('fa-star');	
					} else {
						return $(this).removeClass('fa-star').addClass('fa-star-o');
					}
                });
			};
			
			$star_rating.on('click', function() {
				$star_rating.siblings('input.rating-value').val($(this).data('rating'));
				return SetRatingStar();
			});
			SetRatingStar();
		});
	</script>
    <script type="text/javascript">
$(document).ready(function() {	

		var id = '#dialog';
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(2000); 	
	
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});		
	
	
	
});

</script>
<!-- Footer section email sending -->
    <?php 
	if(isset($_SESSION['sendEmailResult'])) {  
	 // Check if $_GET['sendEmailResult'] == tre 
	if($_SESSION['sendEmailResult'] == true) { 
		echo '<script type="text/javascript">
			window.onload = function() { Alert.render("Your E-mail has been registered with us, just wait for the latest products update"); } </script>';
	} // Check if $_GET['sendEmailResult'] == false
	elseif($_SESSION['sendEmailResult'] == false) {
		echo '<script> window.onload = function() { Alert.render("Your E-mail has not been registered with us, just try again"); }</script>';
	} // END OF INNER IF-ELSE
	unset($_SESSION['sendEmailResult']);
	} // END OF OUTER IF COUNDITION
	?>
    <!-- End of Footer Section email sending -->
</body>
</html>