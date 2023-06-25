<?php
require_once("../utility.php");
require_once("../common.inc.php");

function getUserUnit($userId) {
    $con = connection();
    if (!$con) {
        logError("Failed to connect to the database.");
        return false;
    }

    $selectUnitIdQry = "SELECT ur.unitId
                        FROM unitrankhistory ur
                        JOIN `rank` r ON ur.rankId = r.rank_id
                        JOIN rankfeature rf ON r.rank_id = rf.rankid
                        WHERE ur.userId = ? 
                        AND r.rank_id = rf.rankid
                        AND rf.featureid = 2
                        AND (ur.end_date IS NULL OR ur.end_date = '0000-00-00' OR ur.end_date >= CURDATE())";
                        
    $selectUnitIdStatement = mysqli_prepare($con, $selectUnitIdQry);
    if (!$selectUnitIdStatement) {
        logError("Failed to prepare SQL statement: " . mysqli_error($con));
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($selectUnitIdStatement, "i", $userId);
    if (!mysqli_stmt_execute($selectUnitIdStatement)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($selectUnitIdStatement));
        mysqli_stmt_close($selectUnitIdStatement);
        mysqli_close($con);
        return false;
    }

    $result = mysqli_stmt_get_result($selectUnitIdStatement);
    if (!$result) {
        logError("Failed to get result from SQL statement: " . mysqli_error($con));
        mysqli_stmt_close($selectUnitIdStatement);
        mysqli_close($con);
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    $unitId = $row['unitId'];

    mysqli_stmt_close($selectUnitIdStatement);
    mysqli_close($con);

    if (!$unitId) {
        logError("Failed to retrieve unitId for userId: " . $userId);
        echo "hi";
    }

    return $unitId;
}

function showTransaction($unitID, $currencyCode, $typeCode){
    $con = connection();
    if (!$con) {
        logError("Failed to connect to the database.");
        return false;
    }

    $QRY = "SELECT `transaction_id`, `transaction_amount`, `transaction_description`, `Date` FROM `transaction` WHERE unitID = ? AND currencyCode = ? AND typeCode = ? ORDER BY `Date`";
    $stmt = mysqli_prepare($con, $QRY);
    if (!$stmt) {
        logError("Failed to prepare SQL statement: " . mysqli_error($con));
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iii", $unitID, $currencyCode, $typeCode);
    if (!mysqli_stmt_execute($stmt)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        logError("Failed to get result from SQL statement: " . mysqli_error($con));
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }

    $dataRecords = array();
    while ($resultQRY = mysqli_fetch_assoc($result)) {
        $dataRecords[] = $resultQRY;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    return $dataRecords;
}

function showTransactionByID($transactionId) {
    $con = connection();
    if (!$con) {
        logError("Failed to connect to the database.");
        return false;
    }

    $QRY = "SELECT  `transaction_amount`, `transaction_description`, `Date` FROM `transaction` WHERE transaction_id = ?";
    $stmt = mysqli_prepare($con, $QRY);
    if (!$stmt) {
        logError("Failed to prepare SQL statement: " . mysqli_error($con));
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $transactionId);
    if (!mysqli_stmt_execute($stmt)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        logError("Failed to get result from SQL statement: " . mysqli_error($con));
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }

    $dataRecords = array();
    while ($resultQRY = mysqli_fetch_assoc($result)) {
        $dataRecords[] = $resultQRY;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    return $dataRecords;
    
}

function updateTransaction($transactionId, $newAmount, $newDescription, $newDate) {
    $con = connection();
    if (!$con) {
        logError("Failed to connect to the database.");
        return false;
    }

    // Check if the transaction exists
    $checkQuery = "SELECT 1 FROM `transaction` WHERE transaction_id = ?";
    $checkStmt = mysqli_prepare($con, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "i", $transactionId);
    if (!mysqli_stmt_execute($checkStmt)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($checkStmt));
        mysqli_stmt_close($checkStmt);
        mysqli_close($con);
        return false;
    }

    $result = mysqli_stmt_get_result($checkStmt);
    if (mysqli_num_rows($result) === 0) {
        logError("Transaction not found.");
        mysqli_stmt_close($checkStmt);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_close($checkStmt);

    // Update the transaction details
    $updateQuery = "UPDATE `transaction` SET transaction_amount = ?, transaction_description = ?, `Date` = ? WHERE transaction_id = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "dssi", $newAmount, $newDescription, $newDate, $transactionId);
    if (!mysqli_stmt_execute($updateStmt)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($updateStmt));
        mysqli_stmt_close($updateStmt);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_close($updateStmt);
    mysqli_close($con);

    return true;
}

function deleteTransaction($transactionId) {
    $con = connection();
    if (!$con) {
        logError("Failed to connect to the database.");
        return false;
    }

    // Check if the transaction exists
    $checkQuery = "SELECT 1 FROM `transaction` WHERE transaction_id = ?";
    $checkStmt = mysqli_prepare($con, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "i", $transactionId);
    if (!mysqli_stmt_execute($checkStmt)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($checkStmt));
        mysqli_stmt_close($checkStmt);
        mysqli_close($con);
        return false;
    }

    $result = mysqli_stmt_get_result($checkStmt);
    if (mysqli_num_rows($result) === 0) {
        logError("Transaction not found.");
        mysqli_stmt_close($checkStmt);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_close($checkStmt);

    // Delete the transaction
    $deleteQuery = "DELETE FROM `transaction` WHERE transaction_id = ?";
    $deleteStmt = mysqli_prepare($con, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $transactionId);
    if (!mysqli_stmt_execute($deleteStmt)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($deleteStmt));
        mysqli_stmt_close($deleteStmt);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_close($deleteStmt);
    mysqli_close($con);

    return true;
}
// Add error logging to all functions

function logError($errorMessage) {
    error_log($errorMessage);
}
  
?>


