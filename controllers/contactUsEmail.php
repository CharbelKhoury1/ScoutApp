<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
require 'phpmailer\vendor\autoload.php';

function contactUsMail($mail, $fname, $lname, $message, $phone){
	$email = new PHPMailer(TRUE);
	$email->isSMTP();
	$email->Host = 'smtp.office365.com';//smtp.gmail.com
	$email->Port = 587;
	$email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;;
	$email->SMTPAuth = true;
	$email->Username = 'elyssadaou@hotmail.com';//email address used as smtp server
	$email->Password = 'Elyss@04';

	$email->setFrom('elyssadaou@hotmail.com');//same email used as smtp server
	$email->addAddress('elyssadaou@hotmail.com');
	
	$email->Subject = 'Contact Us Form Submission';
    $email->Body = "First Name: $fname"
        ."<br> Last Name: $lname"
        ."<br> Email: $mail"
		."<br> Phone: $phone"
        ."<br> Message: $message";
		
	$email->isHTML(true);
	
	try {
		$email->send();
		return true;
	} catch (Exception $e) {
		return false;
		
	}
}
?>







