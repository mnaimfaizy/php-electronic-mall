<?php

    $name       = @trim(stripslashes($_POST['name'])); 
    $email      = @trim(stripslashes($_POST['email'])); 
    $subject    = @trim(stripslashes($_POST['subject'])); 
    $message    = @trim(stripslashes($_POST['message'])); 

    $email_from = $email;
    $email_to = 'e-mall@yourdomain.com';//replace with your email

    $body = 'Name: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;
    $success1 = mail($email_to, $subject, $body, 'From: <'.$email_from.'>');

	if($success1) {
		header("Location: contact_us.php?res=true");	
	} else {
		header("Location: contact_us.php?res=false");
	}
?>

<?php
	// Get the email address of the client for the latest updates
	if(isset($_POST['email_address'])) {
		$name = @trim(stripslashes($_POST['customer_name']));
		$email = @trim(stripslashes($_POST['email_address']));	
		$subject = 'Send latest product info';
		
		$email_from = $email;
		$email_to = 'e-mall@mnfprofile.com';
		
		$body = 'Name: ' . $name . "\n\n" . 'Email: ' . $email . "\n\n" . 'Subject : ' . $subject;
		
		$success2 = mail($email_to, $subject, $body, 'From: <'.$email_from.'>');
		
		$page_name = $_POST['page_name'];
		if($success2) {
			header("Location: " . $page_name . "?emailResult=true");
		} else {
			header("Location: " . $page_name . "?emailResult=false");
		}
	}
?>