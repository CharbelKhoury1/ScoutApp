<?php
session_start();
include("../models/balanceTrialModel.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Home/Home.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currency_code']) && isset($_POST['type_code'])) {
    $currencyCode = $_POST['currency_code'];
    $typeCode = $_POST['type_code'];
    $userId = $_SESSION['user_id'];
    $unitId = getUserUnit($userId);
    if($unitId){
        $transactionRecords = showTransaction($unitId, $currencyCode, $typeCode);
        if($transactionRecords){
            $responseData = array(
                'transactionRecords' => $transactionRecords
            );
            header('Content-Type: application/json');
            echo json_encode($responseData);
        }else{
            logError("Failed to retrieve transaction records.");
        }
    }else{
        logError("Failed to retrieve user unit.");
    }
    
   
}

?>




