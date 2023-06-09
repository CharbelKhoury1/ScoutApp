<?php
include("../utility.php");
include("../common.inc.php");

function getUserRank($userId) {
  $con = connection();
  $selectRankIdQry = "SELECT rankId FROM unitrankhistory WHERE userId = ? AND (end_date IS NULL OR end_date >= CURDATE())";
  $selectRankIdStatement = mysqli_prepare($con, $selectRankIdQry);
  mysqli_stmt_bind_param($selectRankIdStatement, "i", $userId);
  mysqli_stmt_execute($selectRankIdStatement);
  $result = mysqli_stmt_get_result($selectRankIdStatement);
  $row = mysqli_fetch_assoc($result);
  $rankId = $row['rankId'];
  mysqli_close($con);
  return $rankId;
}

function getUnitId($userId) {
  $con = connection();
  $selectUnitIdQry = "SELECT u.unit_id FROM unit u
        JOIN unitrankhistory urh ON u.unit_id = urh.unitId
        WHERE urh.userId = ?";
  $selectUnitIdStatement = mysqli_prepare($con, $selectUnitIdQry);
  mysqli_stmt_bind_param($selectUnitIdStatement, "i", $userId);
  mysqli_stmt_execute($selectUnitIdStatement);
  $result = mysqli_stmt_get_result($selectUnitIdStatement);
  $row = mysqli_fetch_assoc($result);
  $unitId = $row['unit_id'];
  mysqli_close($con);
  return $unitId;
}

function insertTransaction($description, $amount, $unitId, $currencyCode, $typeCode) {
  $con = connection();
  $date = date("Y-m-d");
  $insertQRY = 'INSERT INTO transaction (transaction_amount, transaction_description, Date, currencyCode, typeCode, unitId) VALUES(?,?,?,?,?,?)';
  $insertStatement = mysqli_prepare($con, $insertQRY);
  mysqli_stmt_bind_param($insertStatement, "dssiii", $amount, $description, $date, $currencyCode, $typeCode, $unitId);
  $success = mysqli_stmt_execute($insertStatement);
  mysqli_close($con);
  return $success;
}
?>