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
    $transactionRecords = showTransaction($unitId, $currencyCode, $typeCode);
    $responseData = array(
	    'transactionRecords' => $transactionRecords
    );
    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
}

?>




