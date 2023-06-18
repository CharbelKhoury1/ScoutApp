<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
include("../models/transactionModel.php");
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submitlbp"])) {
    //$userId = 6;
    $currencyCode = 0; // LBP
    $typeCode = 1; // Expense
    $unitId = getUserUnit($userId);
    if($unitId){
        $expenseCount = count($_POST["description"]);
        for ($i = 0; $i < $expenseCount; $i++) {
            $description = SecureData($_POST["description"][$i]);
            $lbpAmount = SecureData($_POST["lbp"][$i]);
            insertTransaction($description, $lbpAmount, $unitId,$currencyCode,$typeCode);
        }
        $_SESSION["success_message"] = "Income records inserted successfully in the database.";
    
        header("Location: ../views/incomesView.php");
        exit();
    }
    else {
        $_SESSION["error_message"] = "You do not have permission to access this page. <br> Please click <a href='../Login/Login.php'>here</a> to login.";

        header("Location: ../views/incomesView.php");
        exit();
       
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submitusd"])) {
    //$userId = $_COOKIE["user_id"];
    //$userId = 6;
    $currencyCode = 1; // USD
    $typeCode = 1; // Expense
    $unitId = getUserUnit($userId);
    if($unitId){
        $expenseCount = count($_POST["description"]);
        for ($i = 0; $i < $expenseCount; $i++) {
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