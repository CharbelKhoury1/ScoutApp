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

function getUserUnitRegimentRank($userId) {
    $con = connection();
    $sql = "SELECT u.name AS unit_name, r.name AS regiment_name, rk.name AS rank_name
            FROM unitrankhistory urh
            JOIN unit u ON u.unit_id = urh.unitId
            JOIN regiment r ON r.regiment_id = u.regimentId
            JOIN `rank` rk ON rk.rank_id = urh.rankId
            WHERE urh.userId = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $unitName, $regimentName, $rankName);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    $userDetails = array(
        'unitName' => $unitName,
        'regimentName' => $regimentName,
        'rankName' => $rankName
    );

    return $userDetails;
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