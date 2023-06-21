<?php
include("../utility.php");
include("../common.inc.php");
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
                        AND rf.featureid = 2
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