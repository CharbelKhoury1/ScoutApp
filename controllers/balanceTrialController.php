<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
include("../models/balanceTrialModel.php");
/*
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['currency_code']) && isset($_GET['type_code'])) {
    $userId = 6;
    $unitId = getUserUnit($userId);
    $currencyCode = $_GET['currency_code'];
    $typeCode = $_GET['type_code'];

    $dates = getDates($unitId, $currencyCode, $typeCode);

    header('Content-Type: application/json');
    echo json_encode($dates);
}    
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currency_code']) && isset($_POST['type_code'])) {
    //$userId = 6;
    $unitId = getUserUnit($userId);
    $currencyCode = $_POST['currency_code'];
    $typeCode = $_POST['type_code'];
    //$selectedDate = isset($_POST['date']) ? $_POST['date'] : null;

    //if ($selectedDate) {
        //$transactions = showTransaction_byDate($unitId, $currencyCode, $typeCode, $selectedDate);
    //} else {
        $transactions = showTransaction($unitId, $currencyCode, $typeCode);
    //}

    $response = [
        'transactionRecords' => $transactions,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>


