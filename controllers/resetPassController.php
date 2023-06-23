<?php include("../sideBar/sideBar.php");?>
<?php
include("../models/resetPassModel.php");
include("mail.php");
if (isset($_COOKIE['username'])){
	$uname = SecureData($_COOKIE['username']);
}else{
	header("../Home/Home.php");
	exit();
}

if(!empty($_POST['password']) and !empty($_POST['confirmPassword'])){
	//$uname = SecureData($_POST['username']);
	$pass = SecureData($_POST['password']);
	$check = checkUsername($uname);
	if ($check){
		$reset = resetPass($uname, $pass);
		if ($reset === false) {
			$errorMsg = "New password is the same as the old password.";
			include("../views/resetPassView.php");
			return;
		}else if ($reset) {
			$mail = getEmailByUsername($uname);
			$sent = verificationMail($mail);
			if ($sent) {
                $successMsg = "Your password has been successfully changed. Please check your email inbox.";
				include("../views/resetPassView.php");
            } else {
                $successMsg = "Your password has been successfully changed. Please check your internet connection.";
                include("../views/resetPassView.php");
            }
		}else{
			$errorMsg = "An error occurred while resetting your password. Please try again later.";
			include("../views/resetPassView.php");
		}
	} else {
		$errorMsg = "Username not found in database.";
		include("../views/resetPassView.php");

	}
}else {
    include("../views/resetPassView.php");
}
?>
