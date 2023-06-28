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
            $attachment = null;
            if (!empty($_FILES["attachment"]["tmp_name"][$i]) && !empty($_FILES["attachment"]["name"][$i])) {
                $attachmentName = $_FILES["attachment"]["name"][$i];
                $attachment = $_FILES["attachment"]["tmp_name"][$i];  
                insertTransaction($description, $lbpAmount, $unitId, $currencyCode, $typeCode, $attachment);
            }else{
                insertTransaction($description, $lbpAmount, $unitId, $currencyCode, $typeCode, NULL);
            }
        }
        $_SESSION["success_message"] = "Expenses records inserted successfully in the database.";
    
        header("Location: ../views/expensesView.php");
        exit();
    }
    else {
        $_SESSION["error_message"] = "You do not have permission to access this page. <br> Please click <a href='../Login/Login.php'>here</a> to login.";

        header("Location: ../views/expensesView.php");
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
            $attachment = null;
            if (!empty($_FILES["attachment"]["tmp_name"][$i]) && !empty($_FILES["attachment"]["name"][$i])) {
                $attachmentName = $_FILES["attachment"]["name"][$i];
                $attachment = $_FILES["attachment"]["tmp_name"][$i];  
                insertTransaction($description, $usdAmount, $unitId, $currencyCode, $typeCode, $attachment); 
            }else{
                insertTransaction($description, $usdAmount, $unitId, $currencyCode, $typeCode, NULL);
            }
            
        }
        $_SESSION["success_message"] = "Expenses records inserted successfully in the database.";
    
        header("Location: ../views/expensesUSDView.php");
        exit();
    }else {
        $_SESSION["error_message"] = "You do not have permission to access this page. <br> Please click <a href='../Login/Login.php'>here</a> to login.";

        header("Location: ../views/expensesUSDView.php");
        exit();
        
    }
}
?>