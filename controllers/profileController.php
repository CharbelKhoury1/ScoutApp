<?php 
require_once("../sideBar/profileSideBar.php");
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
include("../models/profileModel.php");

$userPersonalDetails = getUserDetails($userId);
$userDetails = getUserUnitRegimentRank($userId);
$userProfilePhoto = getUserProfilePhoto($userId);

if($userPersonalDetails && $userDetails){
    $user = mysqli_fetch_assoc($userPersonalDetails);
    mysqli_free_result($userPersonalDetails);
    $firstName = $user['fname'];
    $lastName = $user['lname'];
    $email = $user['email'];
    $phone = $user['mobile'];
    $title = $user['scoutTitle'];
    $unitName = $userDetails['unitName'];
    $regimentName = $userDetails['regimentName'];
    $rankName = $userDetails['rankName'];
    include("../views/profileView.php");
    exit();
} else {
    $notFound = "Don't have an account yet? Please login";
}
?>