<?php
include("../models/resetPassModel.php");
include("mail.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = SecureData($_POST['username']);
    $email = SecureData($_POST['email']);
    $name = verifyUser($username, $email);
    if($name){
        setcookie('username', $username, time() + 3600, '/');
        $sent = changePassword($email, $name);
        if ($sent) {
            $successMsg = "We send you an email. Please check your email inbox. You will be redirected to the login page in a few seconds";
			include("../views/verifyUser.php");
        }else{
            $errorMsg = "An email will be sent to you. You will be redirected to the login page in a few seconds ";
			include("../views/verifyUser.php");
        }
    }else{
        $errorMsg = "An email will be sent to you.";
		include("../views/verifyUser.php");
    }
}

?>