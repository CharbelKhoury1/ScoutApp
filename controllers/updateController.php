<?php
include("../models/balanceTrialModel.php");
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        $amount = SecureData($_POST['amount']);
        $description = SecureData ($_POST['description']);
        $date = SecureData ($_POST['date']);
        $transactionId = SecureData($_POST['transactionId']);
        

        $update = updateTransaction($transactionId, $amount, $description, $date);
        if($update){
            $msg = "Transaction has been successfully updated.";
            include("../views/updateTransactionView.php");
			exit();
        }else{
            $msg = "Failed to update. Please try again later";
            include("../views/updateTransactionView.php");
			exit();
        }
    }
}
?>