<?php
session_start();
if(isset($_SESSION['user_id']) || isset($_COOKIE['username']) || isset($_COOKIE['scoutcode']) || isset($_COOKIE['password'])){
	unset($_SESSION['user_id']);
	setcookie('scoutcode', '', time() - 3600, '/');
	setcookie('password', '', time() - 3600, '/');
	setcookie('username', '', time() - 3600, '/');
}
header("location: ../Home/Home.php");
exit();
?>
