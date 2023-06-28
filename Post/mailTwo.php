<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require '../controllers/phpmailer/vendor/autoload.php';

// SMTP server configuration
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'paul.ojeil2@gmail.com'; // put the email of the sender
$smtpPassword = 'vxckeqmkjwjyvnok'; // get this from APP Paswords in google security

// Email content
$subject = "National Scouts and Guides";
$message = "A new request has been sent to you!\n\n";
$message .= "After the approval of the General Commissioner, the request has been redirected to you. Check pending requests section for more details.\n\n";
$message .= "Best regards,\nNational Scouts and Guides";

// Send email using PHPMailer library
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
$mail->SMTPDebug = SMTP::DEBUG_OFF; // Set the debug mode as per your requirement
$mail->SMTPAutoTLS = false;
$mail->SMTPDebug = 0;
$mail->setFrom($smtpUsername);
$mail->Subject = $subject;
$mail->Body = $message;

// Add recipient(s)
$mail->addAddress('paul.ojeil2@gmail.com'); // Add recipient email address

// Send the email
if ($mail->send()) {
    echo 'Email sent successfully!';
} else {
    echo 'Failed to send email. Error: ' . $mail->ErrorInfo;
}
?>