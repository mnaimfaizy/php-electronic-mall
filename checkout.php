<?php include 'includes/header.php'; ?>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
//		Section 3 (if user chooses to adjust item quantity)
///////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
	// execute some code
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
	if($quantity >= 100) { $quantity = 99; }
	if($quantity < 1) { $quantity = 1; }
	$i = 0;
	foreach($_SESSION['cart_array'] as $each_item) {
		$i++;
		while(list($key, $value) = each($each_item)) {
			if($key == "item_id" && $value == $item_to_adjust) {
				// That item is in cart already so let's adjust its quantity using array_splice()
	array_splice($_SESSION['cart_array'], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
			} // close If Condition
		} // close while loop
	} // close Foreach Loop
}
?>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////
// 		Section 4 (if user want to remove an item from cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
	// Access the array and run code to remove that array index
	
	$key_to_remove = $_POST['index_to_remove'];
	if(count($_SESSION['cart_array']) <= 1) {
		unset($_SESSION['cart_array']);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}
?>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////
// 		Section 5 (render the cart for the user to view)
/////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = "";
$OutputResult = false;
$cartFalseResult = "";
$cartTotal = 0;
$pp_checkout_btn = '';
$product_id_array = '';
if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1) {
	$cartFalseResult = '<h2 style="text-align: center; margin: 100px 0px 30px 0px;"> Your shopping cart is empty</h2>
						<h3 style="text-align: center; margin-bottom: 100px;"> Please add some product to your cart first! </h3>';	
} else {
	// Start the For Each loop
	$i = 0;
	foreach($_SESSION['cart_array'] as $each_item) {
		$item_id = $each_item['item_id'];
		$sql = $database->query("SELECT * FROM product WHERE product_id=$item_id LIMIT 1");
		while($row = $database->fetch_array($sql)) {
			$product_id = $row['product_id'];
			$product_name = $row['product_name'];
			$price = $row['price'];
			// Get image of product
			$resss = $database->query("SELECT image_name FROM images WHERE product_id=$product_id LIMIT 1"); 
			$image1 = $database->fetch_array($resss);
			$imageName = $image1['image_name'];
		}
		$pricetotal = $price * $each_item['quantity'];
		$cartTotal = $pricetotal + $cartTotal;
		
		//setlocale(LC_MONETARY, "en_USS");
		//$pricetotal = money_format("%10.2n", $pricetotal);
		
		// Dynamic Checkout Btn Assembly
		$x = $i + 1;

		// Create the product array variable
		$product_id_array .= "$item_id-".$each_item['quantity'].",";
		// Dynamic table row assembly
		$cartOutput .= '<tr>';
		$cartOutput .= '<td class="cart_product">';
		$cartOutput .= '<td class="cart_product">';
		$cartOutput .= 	'<a href="product_detail.php?product_id='.$product_id.'"><img src="images/product_images/'. $imageName .'" style="width:110px; height:110px;" alt=""></a>';
		$cartOutput .= '</td>';
		$cartOutput .= '<td class="cart_description">';
		$cartOutput .= 	'<h4><a href="product_detail.php?product_id='.$product_id.'">'. $product_name .'</a></h4>';
		$cartOutput .= 	'<p>Web ID: ' . $product_id . '</p>';
		$cartOutput .= '</td>';
		$cartOutput .= '<td class="cart_price">';
		$cartOutput .= 	'<p>$' . $price . '</p>';
		$cartOutput .= '</td>';
		$cartOutput .= '<td class="cart_quantity">';
		$cartOutput .= 	'<div class="cart_quantity_button">';
		$cartOutput .= '<form action="checkout.php" method="post">
					<input class="cart_quantity_input" type="text" name="quantity" value="'. $each_item['quantity'] .'" autocomplete="off" size="2" /> &nbsp;
					<input type="submit" class="btn btn-info btn-sm" name="adjustBtn" value="Change" />
					<input type="hidden" name="item_to_adjust" value="'. $item_id .'" />
		</form>';
		$cartOutput .= 	'</div>';
		$cartOutput .= '</td>';
		$cartOutput .= '<td class="cart_total">';
		$cartOutput .= 	'<p class="cart_total_price">$' . $pricetotal . '</p>';
		$cartOutput .= '</td>';
		$cartOutput .= '<td class="cart_delete">' ;
		$cartOutput .= '<form action="checkout.php" method="post">
						<button name="deleteBtn'. $item_id .'" type="submit" class="btn btn-default" />
						<i class="fa fa-times"></i>
						</button>
						<input name="index_to_remove" type="hidden" value="'. $i .'" />
						</form>';
		$cartOutput .= '</td>';
		$cartOutput .= '</tr>';		
		$i++;					
						
	}
	$OutputResult = true;
	
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
    <?php if(isset($_SESSION['shipping_cost']) && isset($_SESSION['delivery_time']) && isset($_SESSION['cart_array'])) { ?>
	<section id="cart_items">
		<div class="container">
		<form action="orders.php" method="post" name="checkout" id="checkout" class="form-horizontal">	
			<div class="step-one">
				<h2 class="heading">Step1</h2>
			</div>
            <?php if(isset($_SESSION['customer_name'])) { ?>
            	<div class="checkout-options">
                	<h3> Regular User </h3>
                    <p> Welcome <strong> <?php echo $_SESSION['customer_name']; ?> </strong> , your orders are ready. Just fill out the billing system and you will be all done.</p>
                    <p> Thanks for buying from our store </p>
                </div>
            <?php } else { ?>
			<div class="checkout-options">
				<h3>New User</h3>
				<p>Checkout options</p>
				<ul class="nav">
					<li>
						<p> If your already registered just login to access your information. &nbsp; &nbsp;&nbsp; <strong> OR </strong></p> 
					</li>
					<li>
						<label><input type="radio" name="guest" id="guest" value="Guest Checkout"> Guest Checkout</label>
					</li>
				</ul>
			</div><!--/checkout-options-->
			<?php } ?>

			<div class="register-req">
				<p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-3 clearfix">
						<div class="bill-to">
							<p>Bill To</p>
							<div class="input-group">
                                <input type="text" name="bill_companyName" id="bill_companyName" class="form-control" placeholder="Company Name">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_email" id="bill_email" class="form-control" placeholder="Email*"> 
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_firstname" id="bill_firstname" class="form-control" placeholder="First Name *">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_middlename" id="bill_middlename" class="form-control" placeholder="Middle Name">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_lastname" id="bill_lastname" class="form-control" placeholder="Last Name *">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_address1" id="bill_address1" class="form-control" placeholder="Address 1 *">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_address2" id="bill_address2" class="form-control" placeholder="Address 2">
                                <div style="margin: 5px 0px;"></div>
								<input type="text" name="bill_zip" id="bill_zip" class="form-control" placeholder="Zip / Postal Code *">
                                <div style="margin: 5px 0px;"></div>
                                <select name="bill_country" id="bill_country" class="form-control">
                                <option value="" selected disabled>-- Country --</option>
                                    <?php $sql = "SELECT * FROM country";
									$sqlResult = $database->query($sql);
									while($country = $database->fetch_array($sqlResult)) {	?>
                                    <option value="<?php echo $country['Code']; ?>"><?php echo $country['Name']; ?></option>
									<?php } ?>
                                </select>
                                <div style="margin: 5px 0px;"></div>
                                <select name="bill_state" id="bill_state"  class="form-control">
                                </select>
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_phone" id="bill_phone" class="form-control" placeholder="Phone *">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_mobile" id="bill_mobile" class="form-control" placeholder="Mobile Phone">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="bill_fax" id="bill_fax" class="form-control" placeholder="Fax">
                                <div style="margin: 5px 0px;"></div>
                                <label><input name="shippingAddress" id="shippingAddress" type="checkbox" value="on"> Shipping to bill address</label>
							</div>
						</div>
					</div>
                    <div id="shipping_address" class="col-sm-3 clearfix">
						
                        <div class="bill-to">
							<p>Shipping Address</p>
							<div class="input-group">
                                <input type="text" name="shipping_companyName" class="form-control" placeholder="Company Name">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_email" class="form-control" placeholder="Email*"> 
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_firstname" class="form-control" placeholder="First Name *">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_middlename" class="form-control" placeholder="Middle Name">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_lastname" class="form-control" placeholder="Last Name *">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_address1" class="form-control" placeholder="Address 1 *">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_address2" class="form-control" placeholder="Address 2">
                                <div style="margin: 5px 0px;"></div>
								<input type="text" name="shipping_zip" class="form-control" placeholder="Zip / Postal Code *">
                                <div style="margin: 5px 0px;"></div>
                                 <select name="shipping_country" id="shipping_country" class="form-control">
                                <option value="" selected disabled>-- Country --</option>
                                    <?php $sql = "SELECT * FROM country";
									$sqlResult = $database->query($sql);
									while($country = $database->fetch_array($sqlResult)) {	?>
                                    <option value="<?php echo $country['Code']; ?>"><?php echo $country['Name']; ?></option>
									<?php } ?>
                                </select>
                                <div style="margin: 5px 0px;"></div>
                                <select name="shipping_state" id="shipping_state"  class="form-control">
                                </select>
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_phone" class="form-control" placeholder="Phone *">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_mobile" class="form-control" placeholder="Mobile Phone">
                                <div style="margin: 5px 0px;"></div>
                                <input type="text" name="shipping_fax" class="form-control" placeholder="Fax">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="order-message">
							<p>Shipping Order</p>
							<textarea name="shipping_order" id="shipping_order"  placeholder="Notes about your order, Special Notes for Delivery" rows="16"></textarea>
							
						</div>	
					</div>					
				</div>
			</div>
			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>

			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
                     <?php echo $cartOutput; ?>
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Cart Sub Total</td>
										<td>$<?php echo $cartTotal; ?></td>
                                        <input type="hidden" name="cartSubTotal" value="<?php echo $cartTotal; ?>" />
									</tr>
									<tr>
										<td>Tax</td>
										<td>$2.00</td>
                                        <input type="hidden" name="tax" value="<?php echo '2.00'; ?>" />
									</tr>
									<tr class="shipping-cost">
										<td>Shipping Cost</td>
										<td><?php echo '$' . $_SESSION['shipping_cost']; ?></td>
                                        <input type="hidden" name="shippingCost" value="<?php echo $_SESSION['shipping_cost']; ?>" />
                                        <input type="hidden" name="delivery_time" value="<?php echo $_SESSION['delivery_time']; ?>" />										
									</tr>
									<tr>
										<td>Total</td>
										<td><span>$<?php 
							if(isset($_SESSION['shipping_cost']) && @$_SESSION['shipping_cost'] != 'Not Available') {
								$shipping_cast = $_SESSION['shipping_cost'];
								$tax = 2; 
								echo $subtotal = $cartTotal + $shipping_cast + $tax;
							} else {
							$tax = 2; 
							echo $subtotal = $cartTotal + $tax;	
							}?></span></td>
                            <input type="hidden" name="subTotal" value="<?php echo $subtotal; ?>" />
									</tr>
								</table>
							</td>
						</tr>
                       
					</tbody>
				</table>
			</div>
			<div class="payment-options">
                <span style="border: 1px solid #F8B09C; padding: 4px; margin-right: 10px;">
                    <label><input type="radio" name="direct_bank_transfer" value="Direct Bank Transer" checked="checked"> <i class="fa fa-home"></i> Direct Bank Transfer</label>
                </span>
                <span style="border: 1px solid #F8B09C; padding: 4px; margin-right: 10px;">
                    <label><input type="radio" name="check_payment" value="Check Payment"> <i class="fa fa-money"></i> Check Payment</label>
                </span>
            <div class="pull-right" style=" margin-top: -20px; padding-top: 0px;">
            	<button type="submit" name="submitOrder" id="submitOrder" class="btn btn-primary btn-lg">
                Order Now &nbsp; <i class="fa fa-arrow-circle-o-right"></i>
                </button>
            </div>
            </div>
         <div class="payment-options">
         <div class="pull-right" style="margin-bottom: 10px; margin-top: -50px;">   
          </form>
          
          </div></div>
		</div>
	</section> <!--/#cart_items-->
    <?php } else { ?>
    <div class="container">
    	<div class="row">
        <div class="jumbotron">
        	<h2> No Item in the Cart </h2>
            <p> Please add at least one item to your <strong> Shopping Cart </strong> &amp; count the <strong> Shipping cost </strong> for the product(s). </p>
            <p> <a href="index.php" class="btn btn-primary"> Go to Home Page </a> </p>
        </div>
        </div>
    </div>
    <?php } ?>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	
	$('#shippingAddress').click(function(){
		var $this = $(this);
		// $this will contain a reference to the checkbox
		if($this.is(':checked')) {
			$('#shipping_address').addClass('animated hidden');	
		} else {
			$('#shipping_address').removeClass('hidden');
			$('#shipping_address').addClass('show');
		}
	});
</script>