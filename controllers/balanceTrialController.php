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
    //$userId = 6;
    $userId = $_SESSION['user_id'];
    $unitId = getUserUnit($userId);
    // Fetch transaction records based on the submitted data
    $transactionRecords = showTransaction($unitId, $currencyCode, $typeCode);

    // Prepare the response data
    $responseData = array(
	    'transactionRecords' => $transactionRecords
    );

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
}

// Delete transaction
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $transactionId = $_POST['transaction_id'];
    #$currencyCode = $_POST['currency_code'];
    #$typeCode = $_POST['type_code'];

    // Modify this part to include your delete transaction logic
    // For example, call a function like deleteTransaction($transactionId) to delete the transaction record

    $success = deleteTransaction($transactionId); // Modify this line with your delete transaction logic

    if ($success) {
        $response = array(
            'success' => true,
            'message' => 'Transaction deleted successfully.'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Failed to delete the transaction.'
        );
    }

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>




