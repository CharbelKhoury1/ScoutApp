<?php
include("../models/balanceModel.php");

if (isset($_GET['unitId'])) {
  $unitId = $_GET['unitId'];
  $lbp_data = getSumLBP($unitId);
  $usd_data = getSumUSD($unitId);

  $lbp_balance = $lbp_data['income'] - $lbp_data['expense'];
  $usd_balance = $usd_data['income'] - $usd_data['expense'];

  $balanceMessagelbp = ($lbp_balance === 0) ? "There are currently no income or expense records in LBP." : "";
  $balanceMessageUsd = ($usd_balance === 0) ? "There are currently no income or expense records in USD." : "";

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

  header('Content-Type: application/json');
  echo json_encode($response);
  exit;
}
?>
