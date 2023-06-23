<?php
include("../models/balanceTrialModel.php");
/*
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}*/
if (isset($_GET['transaction_id'])){
   $transactionId = $_GET['transaction_id'];
}

$data = showTransactionByID($transactionId);
if($data){
    $record = $data[0]; 
    $description = $record['transaction_description'];
    $amount = $record['transaction_amount'];
    $date = $record['Date'];
    include("../views/updateTransactionView.php");
    exit();
}

?>