<?php
include("../models/balanceTrialModel.php");

if (isset($_GET['transaction_id'])){
    $transactionId = $_GET['transaction_id'];
    $con = connection();
    $query = "SELECT attachment FROM `transaction` WHERE transaction_id = ? AND attachment IS NOT NULL";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $transactionId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $fileData = $row['attachment'];
        $fileExtension = pathinfo($row['attachment'], PATHINFO_EXTENSION);
        $contentType = 'application/pdf';

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="transaction"');
        header('Content-Length: ' . strlen($fileData));

        // Output the PDF data
        ob_clean();
        flush();
        echo $fileData;
        exit();
    } 
}
?>