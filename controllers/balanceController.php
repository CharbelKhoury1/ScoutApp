<?php
include("../models/balanceModel.php");

/*
if (!isset($_COOKIE["user_id"])) {
    echo "<html>
            <head>
                <link rel='stylesheet' href='../views/css/income.css'>
            </head>
            <body>
                <div class='alert-container'>
                    <div class='alert1'>
                        <p>You do not have permission to access this page. Please <a href='../Login/Login.php'>login</a>.</p>
                    </div>
                </div>
            </body>
          </html>";
    exit();
}
$userId = $_COOKIE["user_id"];*/
$userId = 6;
$isRank14 = getUserRank($userId);
if ($isRank14 == 14){
    $unitId = getUnitId($userId);
    $lbp_data = getSumLBP($unitId);
    $usd_data = getSumUSD($unitId);

    // Calculate the balance
    $lbp_balance = $lbp_data['income'] - $lbp_data['expense'];
    $usd_balance = $usd_data['income'] - $usd_data['expense'];

    // Create the balance messages
    $balanceMessagelbp = ($lbp_balance === 0) ? "There are currently no income or expense records in LBP." : "";
    $balanceMessageUsd = ($usd_balance === 0) ? "There are currently no income or expense records in USD." : "";

    // Build the JSON response
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