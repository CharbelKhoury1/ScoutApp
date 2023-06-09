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
/*
function getBalanceLBP($unitID){
    $con = connection();
    $query = "SELECT 
                SUM(CASE WHEN typeCode = 0 AND currencyCode = 0 AND unitId = ? THEN transaction_amount ELSE 0 END) AS lbp_income,
                SUM(CASE WHEN typeCode = 1 AND currencyCode = 0 AND unitId = ? THEN transaction_amount ELSE 0 END) AS lbp_expense
              FROM transaction";

    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "ii", $unitID, $unitID);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $lbp_balance = $data['lbp_income']- $data['lbp_expense'];;
        mysqli_free_result($result);
        mysqli_close($con);
        return $lbp_balance;
    } else {
        mysqli_close($con);
        return 0;
    }
}

function getBalanceUSD($unitId) {
    $con = connection();
    $query = "SELECT 
                SUM(CASE WHEN typeCode = 0 AND currencyCode = 1 AND unitId = ? THEN transaction_amount ELSE 0 END) AS usd_income,
                SUM(CASE WHEN typeCode = 1 AND currencyCode = 1 AND unitId = ? THEN transaction_amount ELSE 0 END) AS usd_expense
              FROM transaction";

    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "ii", $unitId, $unitId);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $usd_balance = $data['usd_income'] - $data['usd_expense'];
        mysqli_close($con);
        return $usd_balance;
    }else {
        mysqli_close($con);
        return 0;
    }
}
*/

function getSumLBP($unitID) {
    $con = connection();
    $query = "SELECT 
                SUM(CASE WHEN typeCode = 0 AND currencyCode = 0 AND unitId = ? THEN transaction_amount ELSE 0 END) AS lbp_income,
                SUM(CASE WHEN typeCode = 1 AND currencyCode = 0 AND unitId = ? THEN transaction_amount ELSE 0 END) AS lbp_expense
              FROM transaction";

    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "ii", $unitID, $unitID);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $lbp_income = $data['lbp_income'];
        $lbp_expense = $data['lbp_expense'];
        mysqli_free_result($result);
        mysqli_close($con);
        return array('income' => $lbp_income, 'expense' => $lbp_expense);
    } else {
        mysqli_close($con);
        return array('income' => 0, 'expense' => 0);
    }
}

function getSumUSD($unitId) {
    $con = connection();
    $query = "SELECT 
                SUM(CASE WHEN typeCode = 0 AND currencyCode = 1 AND unitId = ? THEN transaction_amount ELSE 0 END) AS usd_income,
                SUM(CASE WHEN typeCode = 1 AND currencyCode = 1 AND unitId = ? THEN transaction_amount ELSE 0 END) AS usd_expense
              FROM transaction";

    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "ii", $unitId, $unitId);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $usd_income = $data['usd_income'];
        $usd_expense = $data['usd_expense'];
        mysqli_close($con);
        return array('income' => $usd_income, 'expense' => $usd_expense);
    } else {
        mysqli_close($con);
        return array('income' => 0, 'expense' => 0);
    }
}



?>