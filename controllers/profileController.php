<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
include("../models/profileModel.php");

$userDetails = getUserDetails($userId);

if($userDetails){
    $user = mysqli_fetch_assoc($userDetails);
    mysqli_free_result($userDetails);
    $firstName = $user['fname'];
    $lastName = $user['lname'];
    $email = $user['email'];
    $phone = $user['mobile'];
    $title = $user['scoutTitle'];
    include("../views/profileView.php");
    exit();
} else {
    $notFound = "Don't have an account yet? Please login";
}
?>