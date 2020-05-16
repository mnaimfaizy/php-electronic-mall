<?php
ob_start();
// Include libraries
require_once("includes/initialize.php");
require_once("tcpdf/tcpdf.php");

/* -------------------------------------- Generate Invoice for Order Through PayPal ------------------------------ */
if(isset($_GET['order_id']) && ($_GET['page'] == 'paypal')) {
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mohammad Naim Faizy');
$pdf->SetTitle('Order Invoice');
$pdf->SetSubject('Order Invoice');
$pdf->SetKeywords('Orders, PDF, invoice, paypal');
$pdf->setPageOrientation('P');
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, '15', PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */
 $order_id = $_GET['order_id'];
		$sql = "SELECT * FROM paypal_checkout WHERE paypal_id=$order_id LIMIT 1";
		$OrderResult = $database->query($sql);
		$orders = $database->fetch_array($OrderResult);	
		$paypal_id = $orders['paypal_id'];
 // define some HTML content with style
$html = '
<style>
	.container { background:#F1F1F1; width: 100%; }
	.header { border-bottom: 1px solid #D9D9D9 }
 	 h2 { font-size: 18px; }
	.client_info table { width: 100%; }
	.client_info table th { font-size: 16px; font-weight: bold; text-align: left; height: 30px;}
	.client_info table td { font-size: 14px; padding-left: 5px; height: 23px; }
	.product_info table { width: 100% }
	.product_info table th { font-weight: bold; font-size: 14px; height: 30px; border-bottom: 1px solid #D9D9D9; }
	.product_info table td { height: 40px; border-top: 1px solid #D9D9D9; }
	.footer_info table { width: 100%; }
</style>';
$html .= '<div class="container">
    	<div class="header">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr><td width="40%">
			<span style="text-align: left;"> <img src="images/logo.png" alt="E-mall" /> </span>
			</td>
			<td width="60%">
            <h2> Order #'.$paypal_id.' / '.$orders['payment_date'].' </h2>
			</td></tr>
			</table>
        </div>
		<div></div>
        <div class="client_info">
		<table>
        	<tr>
            	<th width="36%"> Customer </th>
                <th width="32%"> Shipping </th>
                <th width="32%"> Billing </th>
            </tr>
            <tr>
            	<td> '.$orders['first_name']." ".$orders['last_name'].' </td>
                <td> '.$orders['address_street'].' </td>
                <td> '.$orders['address_street'].' </td>
            </tr>
            <tr>
            	<td> AUD </td>
                <td>&nbsp;  </td>
                <td>&nbsp;  </td>
            </tr>
            <tr>
            	<td> '.$orders['address_country'].' </td>
                <td> '.$orders['address_country'].' </td>
                <td> '.$orders['address_country'].' </td>
            </tr>
            <tr>
            	<td> '.$orders['address_state'].' </td>
                <td> '.$orders['address_state'].' </td>
                <td> '.$orders['address_state'].' </td>
            </tr>
            <tr>
            	<td> '.$orders['address_zip'].' </td>
                <td> '.$orders['address_zip'].' </td>
                <td> '.$orders['address_zip'].' </td>
            </tr>
            <tr>
            	<td> '.$orders['payer_email'].' </td>
                <td>&nbsp;  </td>
                <td>&nbsp;  </td>
            </tr>
            <tr>
            	<td> '.$orders['ip_address'].' </td>
                <td>&nbsp;  </td>
                <td>&nbsp;  </td>
            </tr>
        </table>
		</div>
		<div class="product_info">
			<table>
				<tr>
					<th width="10%"> # </th>
					<th width="40%"> Item </th>
					<th width="10%"> Picture </th>
					<th width="15%"> Quantity </th>
					<th width="15%"> Unit Cost </th>
					<th width="10%"> Total </th>
				</tr>';
				$no = 1;
				$sql = "SELECT * FROM payment_items WHERE paypal_id=$paypal_id";
				$product_result = $database->query($sql);
				while($products = $database->fetch_array($product_result)) { 
				$product_id = $products['product_id'];
				$quantity = $products['quantity'];
				$total += $products['mc_gross'];
				$product_sql = $database->query("SELECT * FROM product WHERE product_id=$product_id");
				while($products_result = $database->fetch_array($product_sql)) {
					$product_name = $products_result['product_name'];
					$price = $products_result['price'];
					// Retrive Image of product
					$image_sql = $database->query("SELECT * FROM images WHERE product_id=$product_id LIMIT 1");
					$image_result = $database->fetch_array($image_sql);
					$image_name = $image_result['image_name'];
				$html .= '<tr>';
					$html .= '<td> '.$no++.' </td>';
					$html .= '<td> '.$product_name.' </td>';
					$html .= '<td style="text-align: center;"> <img src="../images/product_images/'.$image_name.'" width="40" height="40" /> </td>';
					$html .= '<td> '.$quantity.' </td>';
					$html .= '<td> '.$price.' </td>';
					$html .= '<td> '.($price * $quantity).' </td>';
				$html .= '</tr>';
				}
				}
				$html .= '
			</table>
		</div>
		<div class="footer_info">
			<table>
				<tr>
					<td> <strong>E-Mall</strong> </td>
					<td style="text-align: right;"> <strong>Sub-Total:</strong> $'.$total.' </td>
				</tr>
				<tr>
					<td> <strong>7th Street Karta-e-Chahar</strong> </td>
					<td style="text-align: right;"> <strong>Shipping:</strong> $'.$orders['mc_shipping'].' </td>
				</tr>
				<tr>
					<td> <strong>District 3</strong> </td>
					<td style="text-align: right;"> <strong>Tax:</strong> $'.$orders['tax'].' </td>
				</tr>
				<tr>
					<td> <strong>Kabul - Afghanistan</strong> </td>
					<td style="text-align: right;"> <strong>Grand Total:</strong> $'.($orders['payment_gross'] + $orders['mc_shipping'] + $orders['tax']) .' </td>
				</tr>
				<tr>
					<td> <strong>+93-788103809</strong> </td>
					<td style="text-align: right;"> &nbsp; </td>
				</tr>
			</table>
		</div>
    </div>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Change to Avoid the PDF Error
ob_end_clean();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('paypal_order_'.$paypal_id.'_invoice.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}

/* -------------------------------------- Generate Invoice for Order ----------------------------------------- */
if(isset($_GET['order_id']) && ($_GET['page'] == 'order')) {
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mohammad Naim Faizy');
$pdf->SetTitle('Order Invoice');
$pdf->SetSubject('Order Invoice');
$pdf->SetKeywords('Orders, PDF, invoice, paypal');
$pdf->setPageOrientation('P');
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, '15', PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded.
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */
$order_id = $_GET['order_id'];
		$sql = "SELECT * FROM orders WHERE order_id=$order_id LIMIT 1";
		$OrderResult = $database->query($sql);
		$orders = $database->fetch_array($OrderResult);	
		$bill_id = $orders['bill_id'];
		$sub_total = $orders['total'];
		$shipping_cost = $orders['shipping_cost'];
		$tax = $orders['tax'];
		$grand_total = $orders['grand_total'];
		$status = $orders['status'];
		$payment_method = $orders['payment_method'];
		$delivery_time = $orders['delivery_time'];
			$bill_sql = $database->query("SELECT * FROM billing WHERE bill_id=$bill_id LIMIT 1");
			$bill_result = $database->fetch_array($bill_sql);
			$email_address = $bill_result['email'];
			$phone = $bill_result['phone'];
			$address_1 = $bill_result['address_1'];
			@$address_2 = $bill_result['address_2'];
			$shipping_order = $bill_result['shipping_order'];
			// Find the state for Billing
			$state_id = $bill_result['state'];
			$state_sql = $database->query("SELECT Name FROM city WHERE ID=$state_id");
			$state_result = $database->fetch_array($state_sql);
			$state = $state_result['Name'];
			// Find the Country for Billing
			$contry_code = $bill_result['country'];
			$country_sql = $database->query("SELECT Name FROM country WHERE Code='$contry_code'");
			$country_result = $database->fetch_array($country_sql);
			$contry = $country_result['Name'];
			
			if($orders['shipping_id'] != 0) {
				$shipping_id = $orders['shipping_id'];
				$shipping_sql = $database->query("SELECT * FROM product_shippment WHERE shippment_id=$shipping_id");
				$shipping_result = $database->fetch_array($shipping_sql);
				$shipping_address_1 = $shipping_result['address1'];
				@$shipping_address_2 = $shipping_result['address2'];
				$shipping_phone = $shipping_result['phone'];
				// Find the state for Shipping
				$shipping_state_id = $shipping_result['state'];
				$shipping_state_sql = $database->query("SELECT Name FROM city WHERE ID=$shipping_state_id");
				$shipping_state_result = $database->fetch_array($shipping_state_sql);
				$shipping_state = $shipping_state_result['Name'];	
				// Find the country for Shipping
				$shipping_country_code = $shipping_result['country'];
				$shipping_country_sql = $database->query("SELECT Name FROM country WHERE Code='$shipping_country_code'");
				$shipping_country_result = $database->fetch_array($shipping_country_sql);
				$shipping_country = $shipping_country_result['Name'];
			}
 // define some HTML content with style
$html = '
<style>
	.container { background:#F1F1F1; width: 100%; }
	.header { border-bottom: 1px solid #D9D9D9 }
 	 h2 { font-size: 18px; }
	.client_info table { width: 100%; }
	.client_info table th { font-size: 16px; font-weight: bold; text-align: left; height: 30px;}
	.client_info table td { font-size: 14px; padding-left: 5px; height: 23px; }
	.product_info table { width: 100% }
	.product_info table th { font-weight: bold; font-size: 14px; height: 30px; border-bottom: 1px solid #D9D9D9; }
	.product_info table td { height: 40px; border-top: 1px solid #D9D9D9; }
	.footer_info table { width: 100%; }
</style>';
$html .= '<div class="container">
    	<div class="header">
        	<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr><td width="40%">
			<span style="text-align: left;"> <img src="images/logo.png" alt="E-mall" /> </span>
			</td>
			<td width="60%">
            <h2> Order #'.$order_id.' / '.date("h:i:s M d, Y", $orders['date_ordered']).' </h2>
			</td></tr>
			</table>
        </div>
		<div></div>
        <div class="client_info">
		<table>
        	<tr>
            	<th width="36%"> Customer </th>
                <th width="32%"> Shipping </th>
                <th width="32%"> Billing </th>
            </tr>
            <tr>
            	<td> '.$orders['customer_name'].' </td>
                <td> '.$shipping_address_1.' </td>
                <td> '.$address_1.' </td>
            </tr>
            <tr>
            	<td> AUD </td>
                <td>&nbsp;  </td>
                <td>&nbsp;  </td>
            </tr>
            <tr>
            	<td> '.$contry.' </td>
                <td> '.$shipping_country.' </td>
                <td> '.$contry.' </td>
            </tr>
            <tr>
            	<td> '.$state.' </td>
                <td> '.$shipping_state.' </td>
                <td> '.$state.' </td>
            </tr>
            <tr>
            	<td> '.$orders['address_zip'].' </td>
                <td> '.$orders['address_zip'].' </td>
                <td> '.$orders['address_zip'].' </td>
            </tr>
            <tr>
            	<td> '.$email_address.' </td>
                <td>&nbsp;  </td>
                <td>&nbsp;  </td>
            </tr>
            <tr>
            	<td> '.$phone.' </td>
                <td>&nbsp;  </td>
                <td>&nbsp;  </td>
            </tr>
        </table>
		</div>
		<div class="product_info">
			<table>
				<tr>
					<th width="10%"> # </th>
					<th width="40%"> Item </th>
					<th width="10%"> Picture </th>
					<th width="15%"> Quantity </th>
					<th width="15%"> Unit Cost </th>
					<th width="10%"> Total </th>
				</tr>';
				$no = 1;
				$sql = "SELECT * FROM product_order WHERE order_id=$order_id";
				$product_result = $database->query($sql);
				while($products = $database->fetch_array($product_result)) { 
				$product_id = $products['product_id'];
				$quantity = $products['quantity'];
				$product_sql = $database->query("SELECT * FROM product WHERE product_id=$product_id");
				while($products_result = $database->fetch_array($product_sql)) {
					$product_name = $products_result['product_name'];
					$price = $products_result['price'];
					// Retrive Image of product
					$image_sql = $database->query("SELECT * FROM images WHERE product_id=$product_id LIMIT 1");
					$image_result = $database->fetch_array($image_sql);
					$image_name = $image_result['image_name'];
				$html .= '<tr>';
					$html .= '<td> '.$no++.' </td>';
					$html .= '<td> '.$product_name.' </td>';
					$html .= '<td style="text-align: center;"> <img src="../images/product_images/'.$image_name.'" width="40" height="40" /> </td>';
					$html .= '<td> '.$quantity.' </td>';
					$html .= '<td> '.$price.' </td>';
					$html .= '<td> '.($price * $quantity).' </td>';
				$html .= '</tr>';
				}
				}
				$html .= '
			</table>
		</div>
		<div class="footer_info">
			<table>
				<tr>
					<td> <strong>E-Mall</strong> </td>
					<td style="text-align: right;"> <strong>Sub-Total:</strong> $'.$sub_total.' </td>
				</tr>
				<tr>
					<td> <strong>7th Street Karta-e-Chahar</strong> </td>
					<td style="text-align: right;"> <strong>Shipping:</strong> $'.$shipping_cost.' </td>
				</tr>
				<tr>
					<td> <strong>District 3</strong> </td>
					<td style="text-align: right;"> <strong>Tax:</strong> $'.$tax.' </td>
				</tr>
				<tr>
					<td> <strong>Kabul - Afghanistan</strong> </td>
					<td style="text-align: right;"> <strong>Grand Total:</strong> $'.$grand_total.' </td>
				</tr>
				<tr>
					<td> <strong>+93-788103809</strong> </td>
					<td style="text-align: right;"> &nbsp; </td>
				</tr>
			</table>
		</div>
    </div>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Change to Avoid the PDF Error
ob_end_clean();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Order_'.$order_id.'_invoice.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}
