<?php
include("../models/balanceTrialModel.php");
/*
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}*/
$msg = "";
if (isset($_GET['transaction_id'])){
   $transactionId = $_GET['transaction_id'];
}

$update = deleteTransaction($transactionId);
if($update){
    $msg = "Transaction has been successfully deleted.";
    include("../views/BalanceTrialView.php");
    exit();
}else{
    $msg = "Failed to delete. Please try again later";
    include("../views/BalanceTrialView.php");
    exit();
}
?>