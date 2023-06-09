<?php
session_start();
include("../models/transactionModel.php");
if (!isset($_COOKIE["user_id"])) {
    $_SESSION["error_message"] = "You do not have permission to access this page. <br> Please click <a href='../Login/Login.php'>here</a> to login.";

    header("Location: ../views/incomesView.php");
    exit();
    
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submitlbp"])) {
    $userId = $_COOKIE["user_id"];
    //$userId = 1;
    $isRank14 = getUserRank($userId);
    $currencyCode = 0; //LBP
    $typeCode = 1;//Expense
    if ($isRank14 == 14) {
        $unitId = getUnitId($userId);
        $incomeCount = count($_POST["description"]);
        for ($i = 0; $i < $incomeCount; $i++) {
            $description = SecureData($_POST["description"][$i]);
            $lbpAmount = SecureData($_POST["lbp"][$i]);
            insertTransaction($description, $lbpAmount, $unitId,$currencyCode,$typeCode);
        }
        
        $_SESSION["success_message"] = "Income records inserted successfully in the database.";
    
        header("Location: ../views/incomesView.php");
        exit();

    }else {
        $_SESSION["error_message"] = "You do not have permission to access this page. <br> Please click <a href='../Login/Login.php'>here</a> to login.";

        header("Location: ../views/incomesView.php");
        exit();
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submitusd"])) {
    $userId = $_COOKIE["user_id"];
    //$userId = 6;
    $isRank14 = getUserRank($userId);
    $currencyCode = 1;//USD
    $typeCode = 1;//Expense
    if ($isRank14 == 14) {
        $unitId = getUnitId($userId);
        $incomeCount = count($_POST["description"]);
        for ($i = 0; $i < $incomeCount; $i++) {
            $description = SecureData($_POST["description"][$i]);
            $usdAmount = SecureData($_POST["usd"][$i]);
            insertTransaction($description, $usdAmount, $unitId,$currencyCode,$typeCode);
        }
        $_SESSION["success_message"] = "Income records inserted successfully in the database.";
    
        header("Location: ../views/incomesView.php");
        exit();
        
    }else {
        $_SESSION["error_message"] = "You do not have permission to access this page. <br> Please click <a href='../Login/Login.php'>here</a> to login.";

        header("Location: ../views/incomesView.php");
        exit();
    }
}
?>

