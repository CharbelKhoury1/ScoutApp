<?php
require_once("../utility.php");
require_once("../common.inc.php");

function getUserDetails($userId){
    $con = connection();
    $selectDetailsQRY = "SELECT * FROM user WHERE user_id = ?";
    $selectDetailsStatement = mysqli_prepare($con, $selectDetailsQRY);

    if (!$selectDetailsStatement) {
        die("Failed to prepare statement: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($selectDetailsStatement, "i", $userId);
    mysqli_stmt_execute($selectDetailsStatement);
    $result = mysqli_stmt_get_result($selectDetailsStatement);

    if (!$result) {
        die("Failed to get result: " . mysqli_error($con));
    }

    mysqli_stmt_close($selectDetailsStatement);
    mysqli_close($con);
    return $result;
}

function updateDetails($userId, $landline, $mobile, $fatherJob, $motherJob, $fatherMobile, $motherMobile, $education, $job, $medicalCondition) {
    $con = connection();
    $updateQRY = "UPDATE user SET
                landline = ?,
                mobile = ?,
                father_job = ?,
                mother_job = ?,
                father_mobile = ?,
                mother_mobile = ?,
                education = ?,
                job = ?,
                medical_condition = ?
            WHERE user_id = ?";


    $stmt = mysqli_prepare($con, $updateQRY);

    mysqli_stmt_bind_param($stmt, "sssssssssi", $landline, $mobile, $fatherJob, $motherJob, $fatherMobile, $motherMobile, $education, $job, $medicalCondition, $userId);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return true;
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }
}

?>