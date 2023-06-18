<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
include("../models/balanceModel.php");

//$userId = 6;
$unitId = getUserUnit($userId);
if ($unitId){
    $lbp_data = getSumLBP($unitId);
    $usd_data = getSumUSD($unitId);

    // Calculate the balance
    $lbp_balance = $lbp_data['income'] - $lbp_data['expense'];
    $usd_balance = $usd_data['income'] - $usd_data['expense'];

    // Create the balance messages
    $balanceMessagelbp = ($lbp_balance === 0) ? "There are currently no income or expense records in LBP." : "";
    $balanceMessageUsd = ($usd_balance === 0) ? "There are currently no income or expense records in USD." : "";

    // Build the JSON response
    $response = array(
        'lbp_balance' => $lbp_balance,
        'usd_balance' => $usd_balance,
        'balanceMessageUsd' => $balanceMessageUsd,
        'balanceMessagelbp' => $balanceMessagelbp,
        'usd_income' => $usd_data['income'],
        'usd_expense' => $usd_data['expense'],
        'lbp_income' => $lbp_data['income'],
        'lbp_expense' => $lbp_data['expense']
    );

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;

}
?>