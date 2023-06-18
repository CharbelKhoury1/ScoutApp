<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
include("../models/profileModel.php");
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        //$userId = 5;
        $landline = SecureData($_POST['landline']);
        $mobile = SecureData ($_POST['mobile']);
        $fatherJob = SecureData ($_POST['fatherJob']);
        $motherJob = SecureData ($_POST['motherJob']);
        $fatherMobile = SecureData ($_POST['fatherMobile']);
        $motherMobile = SecureData ($_POST['motherMobile']);
        $education = SecureData ($_POST['education']);
        $job = SecureData ($_POST['job']);
        $medicalCondition = SecureData($_POST['medicalCondition']);

        $update = updateDetails($userId, $landline, $mobile, $fatherJob, $motherJob, $fatherMobile, $motherMobile, $education, $job, $medicalCondition);
        if($update){
            $msg = "Your personal details have been successfully updated.";
            include("../views/editView.php");
			exit();
        }else{
            $msg = "Failed to update your information. Please try again later";
            include("../views/editView.php");
			exit();
        }
    }
}
?>