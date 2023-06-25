<?php
include("../models/balanceTrialModel.php");

$transactionId = 77;

$con = connection();
$query = "SELECT attachment FROM `transaction` WHERE transaction_id = ? AND attachment IS NOT NULL";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $transactionId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row && is_binary($row['attachment'])) {
    echo "yes";
} else {
    echo "No file found.";
}

function is_binary($data) {
    return preg_match('~[^\x20-\x7E\t\r\n]~', $data) > 0;
}
?>









