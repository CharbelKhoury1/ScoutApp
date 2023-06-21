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
function getUserProfilePhoto($userId) {
    $con = connection();
    
    $selectImageQRY = "SELECT image_path FROM user_images WHERE user_id = ?";
    $selectImageStatement = mysqli_prepare($con, $selectImageQRY);
    
    if (!$selectImageStatement) {
        die("Failed to prepare statement: " . mysqli_error($con));
    }
    mysqli_stmt_bind_param($selectImageStatement, "i", $userId);
    mysqli_stmt_execute($selectImageStatement);
    mysqli_stmt_bind_result($selectImageStatement, $imagePath);
    
    mysqli_stmt_fetch($selectImageStatement);
    
    mysqli_stmt_close($selectImageStatement);
    mysqli_close($con); 
    
    return $imagePath;
}

function updateProfilePhoto($userId, $imagePath, $imageContent)
{
    $con = connection();
    if (!$con) {
        die("Failed to connect to the database: " . mysqli_connect_error());
    }

    // Check if the row for the user already exists
    $selectQuery = "SELECT COUNT(*) FROM user_images WHERE user_id = ?";
    $selectStatement = mysqli_prepare($con, $selectQuery);

    if (!$selectStatement) {
        die("Failed to prepare statement: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($selectStatement, "i", $userId);
    mysqli_stmt_execute($selectStatement);
    mysqli_stmt_bind_result($selectStatement, $rowCount);
    mysqli_stmt_fetch($selectStatement);
    mysqli_stmt_close($selectStatement);

    if ($rowCount === 0) {
        $insertQuery = "INSERT INTO user_images (user_id, image_path, image_content) VALUES (?, ?, ?)";
        $insertStatement = mysqli_prepare($con, $insertQuery);

        if (!$insertStatement) {
            die("Failed to prepare statement: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($insertStatement, "iss", $userId, $imagePath, $imageContent);

        if (mysqli_stmt_execute($insertStatement)) {
            mysqli_stmt_close($insertStatement);
            mysqli_close($con);
            return true;
        } else {
            $error = mysqli_error($con);
            error_log("Error inserting profile photo: " . $error);
            mysqli_stmt_close($insertStatement);
            mysqli_close($con);
            return false;
        }
    } else {
        $updateQuery = "UPDATE user_images SET image_path = ?, image_content = ? WHERE user_id = ?";
        $updateStatement = mysqli_prepare($con, $updateQuery);

        if (!$updateStatement) {
            die("Failed to prepare statement: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($updateStatement, "ssi", $imagePath, $imageContent, $userId);

        if (mysqli_stmt_execute($updateStatement)) {
            mysqli_stmt_close($updateStatement);
            mysqli_close($con);
            return true;
        } else {
            $error = mysqli_error($con);
            error_log("Error updating profile photo: " . $error);
            mysqli_stmt_close($updateStatement);
            mysqli_close($con);
            return false;
        }
    }
}
function getUploadErrorMessage($errorCode)
{
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded.';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded.';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder.';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk.';
        case UPLOAD_ERR_EXTENSION:
            return 'A PHP extension stopped the file upload.';
        default:
            return 'Unknown upload error.';
    }
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