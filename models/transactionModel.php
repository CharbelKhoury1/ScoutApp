<?php
include("../utility.php");
include("../common.inc.php");

function hasTransactionPermission($userId) {
  $con = connection();
  if (!$con) {
      logError("Failed to connect to the database.");
      return false;
  }

  $selectRankFeatureQry = "SELECT rf.featureid
                           FROM `rank` r
                           JOIN rankfeature rf ON r.rank_id = rf.rankid
                           JOIN unitrankhistory ur ON ur.rankId = r.rank_id
                           WHERE ur.userId = ?
                           AND (ur.end_date IS NULL OR ur.end_date >= CURDATE())
                           AND rf.featureid = 1";

  $selectRankFeatureStatement = mysqli_prepare($con, $selectRankFeatureQry);
  if (!$selectRankFeatureStatement) {
      logError("Failed to prepare SQL statement: " . mysqli_error($con));
      mysqli_close($con);
      return false;
  }
  mysqli_stmt_bind_param($selectRankFeatureStatement, "i", $userId);
  if (!mysqli_stmt_execute($selectRankFeatureStatement)) {
      logError("Failed to execute SQL statement: " . mysqli_stmt_error($selectRankFeatureStatement));
      mysqli_stmt_close($selectRankFeatureStatement);
      mysqli_close($con);
      return false;
  }

  $result = mysqli_stmt_get_result($selectRankFeatureStatement);
  if (!$result) {
      logError("Failed to get result from SQL statement: " . mysqli_error($con));
      mysqli_stmt_close($selectRankFeatureStatement);
      mysqli_close($con);
      return false;
  }

  $hasPermission = mysqli_num_rows($result) > 0;

  mysqli_stmt_close($selectRankFeatureStatement);
  mysqli_close($con);

  return $hasPermission;
}


function getUserUnit($userId) {
  $con = connection();
  if (!$con) {
      logError("Failed to connect to the database.");
      return false;
  }
  $selectUnitIdQry = "SELECT ur.unitId
                      FROM unitrankhistory ur
                      JOIN `rank` r ON ur.rankId = r.rank_id
                      JOIN rankfeature rf ON r.rank_id = rf.rankid
                      WHERE ur.userId = ? 
                      AND r.rank_id = rf.rankid
                      AND rf.featureid = 1
                      AND (ur.end_date IS NULL OR ur.end_date = '0000-00-00' OR ur.end_date >= CURDATE())";
                      
  $selectUnitIdStatement = mysqli_prepare($con, $selectUnitIdQry);
  if (!$selectUnitIdStatement) {
      logError("Failed to prepare SQL statement: " . mysqli_error($con));
      mysqli_close($con);
      return false;
  }
  mysqli_stmt_bind_param($selectUnitIdStatement, "i", $userId);
  if (!mysqli_stmt_execute($selectUnitIdStatement)) {
      logError("Failed to execute SQL statement: " . mysqli_stmt_error($selectUnitIdStatement));
      mysqli_stmt_close($selectUnitIdStatement);
      mysqli_close($con);
      return false;
  }

  $result = mysqli_stmt_get_result($selectUnitIdStatement);
  if (!$result) {
      logError("Failed to get result from SQL statement: " . mysqli_error($con));
      mysqli_stmt_close($selectUnitIdStatement);
      mysqli_close($con);
      return false;
  }

  $row = mysqli_fetch_assoc($result);
  $unitId = $row['unitId'];

  mysqli_stmt_close($selectUnitIdStatement);
  mysqli_close($con);

  if (!$unitId) {
      logError("Failed to retrieve unitId for userId: " . $userId);
      echo "hi";
  }

  return $unitId;
}

function insertTransaction($description, $amount, $unitId, $currencyCode, $typeCode, $attachment) {
  $con = connection();
  $date = date("Y-m-d");
  $content = file_get_contents($attachment);
  $insertQRY = 'INSERT INTO transaction (transaction_amount, transaction_description, `Date`, `attachment`, currencyCode, typeCode, unitId) VALUES(?,?,?,?,?,?,?)';
  $insertStatement = mysqli_prepare($con, $insertQRY);
  mysqli_stmt_bind_param($insertStatement, "dsssiii", $amount, $description, $date, $content, $currencyCode, $typeCode, $unitId);
  $success = mysqli_stmt_execute($insertStatement);
  mysqli_close($con);
  return $success;
}

function logError($errorMessage) {
  error_log($errorMessage);
}
?>