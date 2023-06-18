<head><link rel="stylesheet" type="text/css" href="../views/css/sideBar.css"></head>
<?php
include("../utility.php");
include("../common.inc.php");
include("contactUsEmail.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = SecureData($_POST['firstname']);
    $lname = SecureData($_POST['lastname']);
    $email = SecureData($_POST['email']);
    $msg = SecureData($_POST['message']);
    $phone = isset($_POST['phone']) ? SecureData($_POST['phone']) : '';

    $sent = contactUsMail($email, $fname, $lname, $msg, $phone);

    if ($sent) {
        $successMsg = "Message sent! Thank you for contacting us.";
        include("../views/contactUsView.php");
    } else {
        $errorMsg = "An error occurred while sending your message. Please try again later.";
        include("../views/contactUsView.php");
    }
} 
?> 


