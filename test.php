<?php 
session_start();
function connection(){
	$conn=mysqli_connect("127.0.0.1","root","","scoutproject") or die( "Failed to connect to database: ". mysqli_error($conn));
	return $conn;
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
                        AND rf.featureid = 2
                        AND (ur.end_date IS NULL OR ur.end_date >= CURDATE())";
                        
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




function showTransaction($unitID, $currencyCode, $typeCode) {
    $con = connection();
    if (!$con) {
        logError("Failed to connect to the database.");
        return false;
    }

    $QRY = "SELECT `transaction_amount`, `transaction_description`, `Date` FROM `transaction` WHERE unitID = ? AND currencyCode = ? AND typeCode = ? ORDER BY `Date`";
    $stmt = mysqli_prepare($con, $QRY);
    if (!$stmt) {
        logError("Failed to prepare SQL statement: " . mysqli_error($con));
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iii", $unitID, $currencyCode, $typeCode);
    if (!mysqli_stmt_execute($stmt)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        logError("Failed to get result from SQL statement: " . mysqli_error($con));
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }

    $dataRecords = array();
    while ($resultQRY = mysqli_fetch_assoc($result)) {
        $dataRecords[] = $resultQRY;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    return $dataRecords;
    
}


function showTransaction_byDate($unitID, $currencyCode, $typeCode, $date) {
    $con = connection();
    if (!$con) {
        logError("Failed to connect to the database.");
        return false;
    }

    $QRY = "SELECT `transaction_amount`, `transaction_description`, `Date` FROM `transaction` WHERE unitID = ? AND currencyCode = ? AND typeCode = ? AND `Date`= ?";
    $stmt = mysqli_prepare($con, $QRY);
    if (!$stmt) {
        logError("Failed to prepare SQL statement: " . mysqli_error($con));
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iiis", $unitID, $currencyCode, $typeCode, $date);
    if (!mysqli_stmt_execute($stmt)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        logError("Failed to get result from SQL statement: " . mysqli_error($con));
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        return false;
    }

    $dataRecords = array();
    while ($resultQRY = mysqli_fetch_assoc($result)) {
        $dataRecords[] = $resultQRY;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    return $dataRecords;
}

function getDates($unitID, $currencyCode, $typeCode){
    $con = connection();
    if (!$con) {
        logError("Failed to connect to the database.");
        return false;
    }

    $query = "SELECT DISTINCT `Date` FROM `transaction` WHERE unitID = ? AND currencyCode = ? AND typeCode = ? ORDER BY `Date` DESC";
    $statement = mysqli_prepare($con, $query);
    if (!$statement) {
        logError("Failed to prepare SQL statement: " . mysqli_error($con));
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($statement, "iii", $unitID, $currencyCode, $typeCode);
    if (!mysqli_stmt_execute($statement)) {
        logError("Failed to execute SQL statement: " . mysqli_stmt_error($statement));
        mysqli_stmt_close($statement);
        mysqli_close($con);
        return false;
    }

    $result = mysqli_stmt_get_result($statement);
    if (!$result) {
        logError("Failed to get result from SQL statement: " . mysqli_error($con));
        mysqli_stmt_close($statement);
        mysqli_close($con);
        return false;
    }

    $dates = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dates[] = $row['Date'];
    }

    mysqli_stmt_close($statement);
    mysqli_close($con);

    return $dates;

}

// Add error logging to all functions

function logError($errorMessage) {
    error_log($errorMessage);
}


if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
$userId = 6;
$unitId = getUserUnit($userId);
$currencyCode = 0;
$typeCode = 0;
$transactions = showTransaction($unitId, $currencyCode, $typeCode);
echo $transactions;
?>

