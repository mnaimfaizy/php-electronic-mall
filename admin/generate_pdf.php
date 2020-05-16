<?php
ob_start();
// Include libraries
require_once("includes/initialize.php");
require_once("tcpdf/tcpdf.php");

/* -------------------------------------------- Generate Orders Report ------------------------------------------ */
if(isset($_GET['page']) && $_GET['page'] == 'orders') {
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mohammad Naim Faizy');
$pdf->SetTitle('Customers Order List');
$pdf->SetSubject('Orders List');
$pdf->SetKeywords('Orders, PDF, list, customers, customer, order list');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
 
 // define some HTML content with style
$html = '
<style>
	h1 { font-size: 20px; text-align:center; color: #414141; padding: 10px; }
	table { width: 100%; margin-bottom: 10px; border: 1px solid #CCCACA; }
	table th { background-color: #0084FF; color: #FFFFFF; padding: 5px; }
	table td { padding: 5px; border: 1px solid #CCCACA; }
</style>';
$html .= '<h1> Complete Report of Orders submitted by customers </h1>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<th> ID </th>
        <th> Status </th>
        <th> Date </th>
        <th> Customer </th>
        <th> IP Address </th>
		<th> Country </th>
        <th> Phone </th>
        <th> Total </th>
    </tr>';
	$sql = "SELECT * FROM orders ORDER BY order_id DESC"; 
	$result = $database->query($sql);
	while($customer = $database->fetch_array($result)) {
	$order_id = $customer['order_id'];
	$bill_id = $customer['bill_id'];
		$html .= '<tr>';
		$html .= '<td style="color:#0005FF; text-align:center;"> Order #'.$order_id.' </td>';
        $html .= '<td> '. $customer["status"] .' </td>';
        $html .= '<td> '.date("d/m/Y, h:i", $customer['date_ordered']).' </td>';
        $html .= '<td style="color:#0005FF; text-align:center;"> '.$customer["customer_name"].' </td>';
        $html .= '<td> '.$customer["ip_address"].' </td>';
		$ip_address = $customer['ip_address'];
		$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip_address));
		if($query && $query['status'] == 'success') {
			$country = $query['country'];	
		} else {
			$country = 'Localhost';
		}
        $html .= '<td> '.$country.' </td>';
		$query = "SELECT phone FROM billing WHERE bill_id=$bill_id LIMIT 1";
				$queryResult = $database->query($query);
				$phone = $database->fetch_array($queryResult);
		$html .= '<td> '.$phone['phone'].' </td>';
        $html .= '<td> $'.$customer["grand_total"].' </td>';
		$html .= '</tr>';
	}
    $html .= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Change to Avoid the PDF Error
ob_end_clean();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('customer_orders.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}

/* ------------------------------ Generate Orders done throug Pyapal Report --------------------------------- */
if(isset($_GET['page']) && $_GET['page'] == 'paypal') {
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mohammad Naim Faizy');
$pdf->SetTitle('PayPal Customers Order List');
$pdf->SetSubject('PayPal Orders List');
$pdf->SetKeywords('Orders, PDF, Paypal, list, customers, customer, order list');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
 
 // define some HTML content with style
$html = '
<style>
	h1 { font-size: 20px; text-align:center; color: #414141; padding: 10px; }
	table { width: 100%; margin-bottom: 10px; border: 1px solid #CCCACA; }
	table th { background-color: #0084FF; color: #FFFFFF; padding: 5px; }
	table td { padding: 5px; border: 1px solid #CCCACA; }
</style>';
$html .= '<h1> Complete Report of Orders submitted through Paypal by customers </h1>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<th>ID</th>
		<th>Status</th>
		<th>Date</th>
		<th>Customer</th>
		<th>Country</th>
		<th>IP Address</th>
		<th>email</th>
		<th>Total</th>
    </tr>';
	$sql = "SELECT * FROM paypal_checkout ORDER BY paypal_id DESC"; 
	$result = $database->query($sql);
	while($customer = $database->fetch_array($result)) {
	$paypal_order_id = $customer['paypal_id'];
		$html .= '<tr>';
		$html .= '<td style="color:#0005FF; text-align:center;"> Order #'.$paypal_order_id.' </td>';
        $html .= '<td> '. $customer["status"] .' </td>';
        $html .= '<td> '.$customer['payment_date'].' </td>';
        $html .= '<td style="color:#0005FF; text-align:center;"> '.$customer['first_name'] . " " . $customer['last_name'].' </td>';
        $html .= '<td> '.$customer['address_country'].' </td>';
        $html .= '<td> '.$customer['ip_address'].' </td>';
		$html .= '<td> '.$customer['payer_email'].' </td>';
        $html .= '<td> $'.$customer['payment_gross'].' </td>';
		$html .= '</tr>';
	}
    $html .= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Change to Avoid the PDF Error
ob_end_clean();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('paypal_orders.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}

/* ------------------------------ Generate Customers Report --------------------------------- */
if(isset($_GET['page']) && $_GET['page'] == 'customers') {
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mohammad Naim Faizy');
$pdf->SetTitle('Customers List');
$pdf->SetSubject('Complete List of Customer');
$pdf->SetKeywords('Customers, PDF, list, complete, customer');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
 
 // define some HTML content with style
$html = '
<style>
	h1 { font-size: 20px; text-align:center; color: #414141; padding: 10px; }
	table { width: 100%; margin-bottom: 10px; border: 1px solid #CCCACA; }
	table th { background-color: #0084FF; color: #FFFFFF; padding: 5px; }
	table td { padding: 5px; border: 1px solid #CCCACA; }
</style>';
$html .= '<h1> Complete Report of Customers List </h1>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<th>ID</th>
		<th>Customer Name</th>
		<th>E-Mail</th>
		<th>Date Added</th>
		<th>Orders</th>
    </tr>';
	$no = 1;
		$sql = "SELECT * FROM customer ORDER BY customer_id DESC"; 
		$result = $database->query($sql);
		while($customer = $database->fetch_array($result)) {
		$html .= '<tr>';
		$html .= '<td style="color:#0005FF; text-align:center;"> '.$no++.' </td>';
        $html .= '<td> '. $customer['customer_name'] .' </td>';
        $html .= '<td> '.$customer['email'].' </td>';
		$html .= '<td> '.date("d M Y", $customer['date_added']).' </td>';
		$customer_id = $customer['customer_id'];
			$query = $database->query("SELECT COUNT(*) AS total FROM orders WHERE customer_id=$customer_id");
			$total = $database->fetch_array($query);
			$orders = $total['total'];
        $html .= '<td style="color:#0005FF; text-align:center;"> '.$orders.' </td>';
		$html .= '</tr>';
	}
    $html .= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Change to Avoid the PDF Error
ob_end_clean();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('customer_list.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}

/* ------------------------------ Generate Guest Customers Report --------------------------------- */
if(isset($_GET['page']) && $_GET['page'] == 'guest') {
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mohammad Naim Faizy');
$pdf->SetTitle('Guest Customers List');
$pdf->SetSubject('Complete List of Guest Customer');
$pdf->SetKeywords('Customers, PDF, list, complete, customer, guest, Guest');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
 
 // define some HTML content with style
$html = '
<style>
	h1 { font-size: 20px; text-align:center; color: #414141; padding: 10px; }
	table { width: 100%; margin-bottom: 10px; border: 1px solid #CCCACA; }
	table th { background-color: #0084FF; color: #FFFFFF; padding: 5px; }
	table td { padding: 5px; border: 1px solid #CCCACA; }
</style>';
$html .= '<h1> Complete Report of Guest Customers List </h1>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<th>No</th>
		<th>Customer Name</th>
		<th>IP Address</th>
		<th>Payment Method</th>
		<th>Country</th>
		<th>Orders</th>
    </tr>';
	$no = 1;
	$sql = "SELECT * FROM orders ORDER BY order_id DESC"; 
	$result = $database->query($sql);
	while($customer = $database->fetch_array($result)) {
		$html .= '<tr>';
		$html .= '<td style="color:#0005FF; text-align:center;"> '.$no++.' </td>';
        $html .= '<td> '. $customer['customer_name'] .' </td>';
        $html .= '<td> '.$customer['ip_address'].' </td>';
		$html .= '<td> '.$customer['payment_method'].' </td>';
		 $ip_address = $customer['ip_address'];
		$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip_address));
		if($query && $query['status'] == 'success') {
			$country = $query['country'];	
		} else {
			$country = 'Localhost';
		}
		$html .= '<td> '.$country.' </td>';
		$customer_id = $customer['ip_address'];
		$query = $database->query("SELECT COUNT(*) AS total FROM orders WHERE ip_address='$ip_address'");
		$total = $database->fetch_array($query);
		$orders = $total['total'];
        $html .= '<td style="color:#0005FF; text-align:center;"> '.$orders.' </td>';
		$html .= '</tr>';
	}
    $html .= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Change to Avoid the PDF Error
ob_end_clean();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('guest_customer_list.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}

/* ------------------------------ Generate PayPal Customers Report --------------------------------- */
if(isset($_GET['page']) && $_GET['page'] == 'paypal_customers') {
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mohammad Naim Faizy');
$pdf->SetTitle('PayPal Customers List');
$pdf->SetSubject('Complete List of PayPal Customer');
$pdf->SetKeywords('Customers, PDF, list, complete, customer, PayPal');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
 
 // define some HTML content with style
$html = '
<style>
	h1 { font-size: 20px; text-align:center; color: #414141; padding: 10px; }
	table { width: 100%; margin-bottom: 10px; border: 1px solid #CCCACA; }
	table th { background-color: #0084FF; color: #FFFFFF; padding: 5px; }
	table td { padding: 5px; border: 1px solid #CCCACA; }
	.col_1 { width: 10%; }
	.col_2 { width: 20%; }
	.col_3 { width: 30%; }
	.col_4 { width: 40%; }
	.col_5 { width: 50%; }
</style>';
$html .= '<h1> Complete Report of Guest Customers List </h1>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<th class="col_1">No</th> 
		<th>Customer Name</th>                                           
		<th>Date</th>
		<th>email</th>
		<th>IP Address</th>
		<th>Country</th>
		<th>Orders</th>
		<th>Total</th>
    </tr>';
	$no = 1;
	$sql = "SELECT * FROM paypal_checkout ORDER BY paypal_id DESC"; 
	$result = $database->query($sql);
	while($customer = $database->fetch_array($result)) {
		$html .= '<tr>';
		$html .= '<td class="col_1" style="color:#0005FF; text-align:center;"> '.$no++.' </td>';
        $html .= '<td> '. $customer['first_name']." ".$customer['last_name'] .' </td>';
        $html .= '<td> '.$customer['payment_date'].' </td>';
		$html .= '<td> '.$customer['payer_email'].' </td>';
		$html .= '<td> '.$customer['ip_address'].' </td>';
		$html .= '<td> '.$customer['address_country'].' </td>';
        $html .= '<td style="color:#0005FF; text-align:center;"> '.$customer['num_cart_items'].' </td>';
		$html .= '<td> $'.$customer['mc_gross'].' </td>';
		$html .= '</tr>';
	}
    $html .= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

// Change to Avoid the PDF Error
ob_end_clean();
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('guest_customer_list.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}