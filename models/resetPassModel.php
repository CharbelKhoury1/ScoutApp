<?php
include("../utility.php");
include("../common.inc.php");
function checkUsername($username) {
    $con = connection();
    $query = "SELECT u.user_id FROM user AS u
              INNER JOIN usercredentials AS uc ON u.user_id = uc.userId
              WHERE uc.username = ?";
    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "s", $username);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    $count = mysqli_stmt_num_rows($statement);
    mysqli_stmt_close($statement);
    mysqli_close($con);

    return $count > 0; 
}

function resetPass($username, $password) {
    $con = connection();
    $selectQry = "SELECT password FROM usercredentials WHERE username=?";
    $selectStatement = mysqli_prepare($con, $selectQry);
    mysqli_stmt_bind_param($selectStatement, "s", $username);
    mysqli_stmt_execute($selectStatement);
    mysqli_stmt_bind_result($selectStatement, $existingPasswordHash);
    mysqli_stmt_fetch($selectStatement);
    mysqli_stmt_close($selectStatement);
    
    if (password_verify($password, $existingPasswordHash)) {
        mysqli_close($con);
        return false;
    } else {
        $newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
        $updateQry = "UPDATE usercredentials SET password = ? WHERE username= ?";
        $updateStatement = mysqli_prepare($con, $updateQry);
        mysqli_stmt_bind_param($updateStatement, "ss", $newPasswordHash, $username);
        mysqli_stmt_execute($updateStatement);
        $success = mysqli_stmt_affected_rows($updateStatement) > 0;
        mysqli_stmt_close($updateStatement);
        mysqli_close($con);
        return $success;
    }
}

function getEmailByUsername($username) {
    $con = connection();
    $query = "SELECT u.email FROM user AS u
              INNER JOIN usercredentials AS uc ON u.user_id = uc.userId
              WHERE uc.username = ?";
    $statement = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($statement, "s", $username);
    mysqli_stmt_execute($statement);
    mysqli_stmt_bind_result($statement, $email);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);
    mysqli_close($con);

    return $email;
}



?>