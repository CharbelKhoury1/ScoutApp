<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
include("../models/profileModel.php");

//$userId = 6;
$userDetails = getUserDetails($userId);

if($userDetails){
    $user = mysqli_fetch_assoc($userDetails);
    mysqli_free_result($userDetails);
    $landline = $user['landline'];
    $mobile = $user['mobile'];
    $fatherJob = $user['father_job'];
    $motherJob = $user['mother_job'];
    $fatherMobile = $user['father_mobile'];
    $motherMobile = $user['mother_mobile'];
    $education = $user['education'];
    $job = $user['job'];
    $medicalCondition = $user['medical_condition'];
    include("../views/editView.php");
    exit();
} 
?>.