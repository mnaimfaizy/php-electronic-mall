<?php include 'includes/header.php'; ?>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
//		Section 1 (if user attempts to add something to the cart from the product page)
///////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['product_id'])) {
	$pid = $_POST['product_id'];
	$wasFound = false;
	$i = 0;	
	// If the cart session variable is not set or cart array is empty
	if(!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1) {
			// RUN IF THE CART IS EMPTY OR NOT SET
			$_SESSION['cart_array'] = array(0 => array("item_id"=>$pid, "quantity" => 1));
	} else {
		// RUN IF THE CART HAS AT LEASE ONE ITEM IN IT
		foreach($_SESSION['cart_array'] as $each_item) {
			$i++;
			while(list($key, $value) = each($each_item)) {
				if($key == "item_id" && $value == $pid) {
					// That item is in cart already so let's adjust its quantity using array_splice()
					array_splice($_SESSION['cart_array'], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
					$wasFound = true;
				} // close If Condition
			} // close while loop
		} // close Foreach Loop
		if($wasFound == false) {
			array_push($_SESSION['cart_array'], array('item_id' => $pid, 'quantity' => 1));	
		}
	}
	//$page_name = $_SERVER['PHP_SELF'];
	
	/*$locaction = "http://".$hostname."/cart.php";
	echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL='.$locaction.'">';
	exit;*/
}
?>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
//		Section 2 (if user chooses to empty their shopping cart)
///////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
	unset($_SESSION['cart_array']);
	unset($_SESSION['shipping_cost']);
	unset($_SESSION['delivery_time']);	
}
?>
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
		$cartOutput .= 	'<a href="product_detail.php?product_id='.$product_id.'"><img src="images/product_images/'. $imageName .'" width="100" height="100" alt=""></a>';
		$cartOutput .= '</td>';
		$cartOutput .= '<td class="cart_description">';
		$cartOutput .= 	'<h4 style="padding-left: 15px;"><a href="product_detail.php?product_id='.$product_id.'">'. $product_name .'</a></h4>';
		$cartOutput .= 	'<p style="padding-left: 15px;">Web ID: ' . $product_id . '</p>';
		$cartOutput .= '</td>';
		$cartOutput .= '<td class="cart_price">';
		$cartOutput .= 	'<p>$' . $price . '</p>';
		$cartOutput .= '</td>';
		$cartOutput .= '<td class="cart_quantity">';
		$cartOutput .= 	'<div class="cart_quantity_button">';
		$cartOutput .= '<form action="cart.php" method="post">
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
		$cartOutput .= '<form action="cart.php" method="post">
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
	<?php if(isset($OutputResult) && $OutputResult == true) { ?>
    <section id="cart_items">
		<div class="container">
        
			
            
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
					</tbody>
				</table>
                
			</div>
            <div class="row">
                <div class="col-sm-12">
                    <a href="cart.php?cmd=emptycart" class="btn btn-primary btn-lg pull-right"><i class="fa fa-trash-o"></i> Empty Cart </a>
                </div>
            </div>
		</div>
	</section> <!--/#cart_items-->
    
	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>Calculate Shipment for the product</h3>
				
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="chose_area">
						<ul class="user_info">
							<li class="single_field">
								<label>Country:</label>
                                
								<select name="country" id="country">
                                <option value="" selected="selected" disabled="disabled"> -- Select Country -- </option>
								<?php $sql = "SELECT * FROM country";
									$sqlResult = $database->query($sql);
									while($country = $database->fetch_array($sqlResult)) {	?>
                                    <option value="<?php echo $country['Code']; ?>"><?php echo $country['Name']; ?></option>
									<?php } ?>
									
								</select>
								
							</li>
							<li class="single_field">
								<label>State / Province:</label>
								<select name="state" id="state">
									
								</select>
							
							</li>
							<li class="single_field zip-field">
								<label>Zip Code:</label>
								<input type="text" name="zip" id="zip">
							</li>
						</ul>
                        <input type="button" id="submitShipmentInfo" name="submitShipmentInfo" value="Calculate" class="btn btn-default check_out" />
                        
					</div>
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Cart Sub Total <span>$<?php echo $cartTotal; ?></span></li>
							<li>Tax <span>$2</span></li>
							<li>Shipping Cost <span id="shipping_cost">
                            	<?php if(isset($_SESSION['shipping_cost'])) { echo '$' . $_SESSION['shipping_cost']; } ?>
                            </span></li>
							<li>Total <span>$ <?php 
							if(isset($_SESSION['shipping_cost']) && @$_SESSION['shipping_cost'] != 'Not Available') {
								$shipping_cast = $_SESSION['shipping_cost'];
								$tax = 2.00; 
								echo $subtotal = $cartTotal + $shipping_cast + $tax;
							} else {
							$tax = 2.00; 
							echo $subtotal = $cartTotal + $tax;	
							}?></span></li>
						</ul>
                        <div class="row">
                        	<div class="col-sm-5">
							<a class="btn btn-default check_out" href="checkout.php">Check Out Normaly</a>
                            </div>
                            <div class="col-sm-1">
                            	<span class="or" style="margin-top:0px;"> OR </span>
                            </div>
                          <div class="col-sm-6">
                            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                          <input type="hidden" name="cmd" value="_cart">
                          <input type="hidden" name="upload" value="1">
                          <input type="hidden" name="business" value="youremail@domain.com">
                          
                          <?php
                            $i = 1;
                            foreach($_SESSION['cart_array'] as $each_item) {
                            $item_id = $each_item['item_id'];
                            $quantity = $each_item['quantity'];
                            $sql = $database->query("SELECT * FROM product WHERE product_id=$item_id LIMIT 1");
                            while($row = $database->fetch_array($sql)) {
                          ?>
                          
                          <input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo $row['product_name']; ?>">
                          <input type="hidden" name="item_number_<?php echo $i; ?>" value="<?php echo $row['product_id']; ?>">
                          <input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo $row['price']; ?>">
                          <input type="hidden" name="quantity_<?php echo $i; ?>" value="<?php echo $quantity; ?>">
                          
                          <?php } $i++;
                            }
                            ?>
                           <input type="hidden" name="currency_code" value="USD">
                           <input type="hidden" name="lc" value="US">
                           <input type="hidden" name="rm" value="2">
                           <input type="hidden" name="shipping_1" value="<?php if(isset($_SESSION['shipping_cost'])) { echo $_SESSION['shipping_cost']; } else { echo '10.00'; } ?>">
                           <input type="hidden" name="tax_rate" value="2.00">
                           <input type="hidden" name="return" value="http://<?php echo $hostname; ?>/thankyou.php">
                           <input type="hidden" name="cancel_return" value="http://<?php echo $hostname; ?>/cancel_order.php">
                           <input type="hidden" name="notify_url" value="http://<?php echo $hostname; ?>/index.php">
                           <input type="image" src="images/checkout-logo-large.png" class="pull-right" name="pay_now" />
                          </form>
                          </div>
                       </div>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
    <?php } else { ?>
	<div class="container">
    	<div class="row">
        	<div class="jumbotron">
            	<h2> Your Shopping Cart is Empty :( </h2>
                <p> Please add at least one product to shopping cart </p>
            </div>
        </div>
    </div>
	<?php }?>
<?php include 'includes/footer.php'; ?>