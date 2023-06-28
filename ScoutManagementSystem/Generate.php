<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require '../controllers/phpmailer/vendor/autoload.php';

// Check if the email has already been sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
              // Get form input values
      $firstName = $_POST["first-name"];
      $lastName = $_POST["last-name"];
      $email = $_POST["email"];

      // SMTP server configuration
      $smtpHost = 'smtp.gmail.com';
      $smtpPort = 587;
      $smtpUsername = 'ckhoury100@gmail.com';// put the email of the sender
      $smtpPassword = 'jrudddefbbmyfpmd';// get this from APP Paswords in google security

      // Recipient email
      $recipientEmail = $email;

      $code=generateCode(6);
      $password=generatePassword($firstName,$lastName);

      // Email content
      $subject = "National Scouts and Guides - Code and Password";
      $message = "Dear $firstName $lastName,\n\n";
      $message .= "Thank you for joining the National Scouts and Guides community!\n\n";
      $message .= "Here are your login details:\n";
      $message .= "Code: $code\n";
      $message .= "Password: $password\n\n";
      $message .= "We look forward to your active participation!\n\n";
      $message .= "Best regards,\nNational Scouts and Guides";

      // Email headers
      $headers = "From: $smtpUsername\r\n";
      $headers .= "Reply-To: $smtpUsername\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

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
      $mail->addAddress($recipientEmail);
      $mail->Subject = $subject;
      $mail->msgHTML(str_replace(['[CODE]', '[PASSWORD]'], [$code, $password], $message), $headers);
              
          }
  
// Function to generate a random code
function generateCode($length) {
  $characters = "0123456789";
  $code = "";
  for ($i = 0; $i < $length; $i++) {
    $randomIndex = mt_rand(0, strlen($characters) - 1);
    $code .= $characters[$randomIndex];
  }
  return $code;
}

// Function to generate password from first name and last name
function generatePassword($firstName, $lastName) {
  $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
  $randomDigits = mt_rand(1000, 9999);
  return $initials . $randomDigits;
}
?>
