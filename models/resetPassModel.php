<?php
include("../utility.php");
include("../common.inc.php");

function checkUsername($username) {
    $con = connection();
    if (!$con) {
        // Handle connection error
        echo "Connection error: " . mysqli_connect_error();
        return false;
    }

    $query = "SELECT u.user_id FROM user AS u
              INNER JOIN usercredentials AS uc ON u.user_id = uc.userId
              WHERE uc.scoutcode = ?";
    
    $statement = mysqli_prepare($con, $query);
    if (!$statement) {
        // Handle query preparation errori
        echo "Query preparation error: " . mysqli_error($con);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($statement, "s", $username);
    if (!mysqli_stmt_execute($statement)) {
        // Handle query execution error
        echo "Query execution error: " . mysqli_stmt_error($statement);
        mysqli_stmt_close($statement);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_store_result($statement);
    $count = mysqli_stmt_num_rows($statement);
    mysqli_stmt_close($statement);
    mysqli_close($con);

    return $count > 0; 
}
function verifyUser($username, $email)
{
    $con = connection();
    $selectQry = "SELECT uc.scoutcode, u.fname
                FROM usercredentials uc
                INNER JOIN user u ON uc.userId = u.user_id
                WHERE uc.scoutcode = ? 
                AND u.email = ?
                AND uc.userId = u.user_id";
    $selectStatement = mysqli_prepare($con, $selectQry);
    if (!$selectStatement) {
        // Handle query preparation error
        echo "Query preparation error: " . mysqli_error($con);
        mysqli_close($con);
        return false;
    }
    mysqli_stmt_bind_param($selectStatement, "ss", $username, $email);
    if (!mysqli_stmt_execute($selectStatement)) {
        // Handle query execution error
        echo "Query execution error: " . mysqli_stmt_error($selectStatement);
        mysqli_stmt_close($selectStatement);
        mysqli_close($con);
        return false;
    }
    mysqli_stmt_store_result($selectStatement);
    $count = mysqli_stmt_num_rows($selectStatement);
    mysqli_stmt_bind_result($selectStatement, $scoutcode, $name);
    mysqli_stmt_fetch($selectStatement);
    mysqli_stmt_close($selectStatement);
    mysqli_close($con);

    if ($count > 0) {
        return $name;
    } else {
        return false;
    }
}

function resetPass($username, $password) {
    $con = connection();
    if (!$con) {
        // Handle connection error
        echo "Connection error: " . mysqli_connect_error();
        return false;
    }

    $selectQry = "SELECT password FROM usercredentials WHERE scoutcode=?";
    $selectStatement = mysqli_prepare($con, $selectQry);
    if (!$selectStatement) {
        // Handle query preparation error
        echo "Query preparation error: " . mysqli_error($con);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($selectStatement, "s", $username);
    if (!mysqli_stmt_execute($selectStatement)) {
        // Handle query execution error
        echo "Query execution error: " . mysqli_stmt_error($selectStatement);
        mysqli_stmt_close($selectStatement);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_result($selectStatement, $existingPasswordHash);
    mysqli_stmt_fetch($selectStatement);
    mysqli_stmt_close($selectStatement);

    if (password_verify($password, $existingPasswordHash)) {
        mysqli_close($con);
        return false;
    } else {
        $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
        $updateQry = "UPDATE usercredentials SET password = ? WHERE scoutcode= ?";
        $updateStatement = mysqli_prepare($con, $updateQry);
        if (!$updateStatement) {
            // Handle query preparation error
            echo "Query preparation error: " . mysqli_error($con);
            mysqli_close($con);
            return false;
        }

        mysqli_stmt_bind_param($updateStatement, "ss", $newPasswordHash, $username);
        if (!mysqli_stmt_execute($updateStatement)) {
            // Handle query execution error
            echo "Query execution error: " . mysqli_stmt_error($updateStatement);
            mysqli_stmt_close($updateStatement);
            mysqli_close($con);
            return false;
        }

        $success = mysqli_stmt_affected_rows($updateStatement) > 0;
        mysqli_stmt_close($updateStatement);
        mysqli_close($con);
        return $success;
    }
}

function getEmailByUsername($username) {
    $con = connection();
    if (!$con) {
        // Handle connection error
        echo "Connection error: " . mysqli_connect_error();
        return false;
    }

    $query = "SELECT u.email FROM user AS u
              INNER JOIN usercredentials AS uc ON u.user_id = uc.userId
              WHERE uc.scoutcode= ?";
    
    $statement = mysqli_prepare($con, $query);
    if (!$statement) {
        // Handle query preparation error
        echo "Query preparation error: " . mysqli_error($con);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_param($statement, "s", $username);
    if (!mysqli_stmt_execute($statement)) {
        // Handle query execution error
        echo "Query execution error: " . mysqli_stmt_error($statement);
        mysqli_stmt_close($statement);
        mysqli_close($con);
        return false;
    }

    mysqli_stmt_bind_result($statement, $email);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);
    mysqli_close($con);

    return $email;
}
?>

