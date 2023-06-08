<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require 'phpmailer\vendor\autoload.php';

function verificationMail($to){
	$email = new PHPMailer(TRUE);
	$email->isSMTP();
	$email->Host = 'smtp.office365.com';//smtp.gmail.com
	$email->Port = 587;
	$email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;;
	$email->SMTPAuth = true;
	$email->Username = 'elyssadaou@hotmail.com';//email address used as smtp server
	$email->Password = 'Elyss@04';

	$email->setFrom('elyssadaou@hotmail.com', 'National Orthodox Scout');//same email used as smtp server
	$email->addAddress($to);
	
	$email->Subject = 'You have successfully changed your password';
	$email->Body = 'Hello,<br><br>You have successfully changed your password! 
				<br><br>If you have any question, kindly contact <a href="mailto:elyssadaou@hotmail.com">our Scout IT Team</a> who would be happy to assist you.
				<br><br>Thank You,
				<br><br>National Orthodox Scout Team<br><br>
				<br><br>Please do not reply to this email.';
	$email->isHTML(true);
	
	try {
		$email->send();
		return true;
	} catch (Exception $e) {
		return false;
		
	}
}
?>
