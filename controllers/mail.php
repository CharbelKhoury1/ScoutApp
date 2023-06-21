<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
	use PHPMailer\PHPMailer\SMTP;
require 'phpmailer\vendor\autoload.php';

function verificationMail($to) {
    $email = new PHPMailer(TRUE);
    $email->isSMTP();
    $email->Host = 'smtp.office365.com'; // or smtp.gmail.com for Gmail
    $email->Port = 587;
    $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $email->SMTPAuth = true;
    $email->Username = 'elyssadaou@hotmail.com'; // email address used as SMTP server
    $email->Password = 'Elyss@04';

    $email->setFrom('elyssadaou@hotmail.com', 'National Orthodox Scout'); // same email used as SMTP server
    $email->addAddress($to);

    $email->Subject = 'You have successfully changed your password';
    $email->Body = "<html><body><h4>You have successfully changed your password! 
				<br><br>If you have any questions, kindly contact <a href='mailto:elyssadaou@hotmail.com'>our Scout IT Team</a> who would be happy to assist you.
				<br><br>Thank you,
				<br><br>National Orthodox Scout Team<br><br>
				<br><br>Please do not reply to this email.</h4>";
    $email->isHTML(true);

    try {
        $email->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


function changePassword($email, $name) {
    $mail = new PHPMailer(TRUE);
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com'; // or smtp.gmail.com for Gmail
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;
    $mail->Username = 'elyssadaou@hotmail.com'; // email address used as SMTP server
    $mail->Password = 'Elyss@04';

    $mail->setFrom('elyssadaou@hotmail.com', 'National Orthodox Scout'); // same email used as SMTP server
    $mail->addAddress($email);

    $mail->Subject = 'Reset your Password';

    // Create the HTML content for the email body
    $emailBody = "
        <html>
        <head>
            <style>
                .button {
                    display: inline-block;
                    background-color: #4CAF50;
                    border: none;
                    color: white;
                    text-align: center;
                    font-size: 16px;
                    padding: 10px 24px;
                    cursor: pointer;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <h4>Hello $name</h4>
            <h4>Forgot your password? Let's get a new one.</h4>
            <h4>
                Click the button below to reset your password:
                <br>
                <a href=\"http://localhost:3000/controllers/resetPassController.php\" class=\"button\">Reset Password</a>
            </h4>
			<h4>National Orthodox Scout Team</h4>
        </body>
        </html>
    ";

    $mail->Body = $emailBody;
    $mail->isHTML(true);

    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


?>
