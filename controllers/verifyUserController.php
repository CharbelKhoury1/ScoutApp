<?php
//session_start();
include("../models/resetPassModel.php");
include("mail.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = SecureData($_POST['username']);
    $email = SecureData($_POST['email']);
    $name = verifyUser($username, $email);
    if($name){
		$sent = changePassword($email, $name);
        if ($sent) {
            $_SESSION['username'] = $username;
            $successMsg = "We send you an email. Please check your email inbox.";
			include("../views/verifyUser.php");
        }else{
            $errorMsg = "An email will be sent to you.";
			include("../views/verifyUser.php");
        }
    }else{
        $errorMsg = "An email will be sent to you.";
		include("../views/verifyUser.php");
    }
}

?>