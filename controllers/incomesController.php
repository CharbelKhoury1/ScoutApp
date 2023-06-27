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
    $currencyCode = 0; //LBP
    $typeCode = 0; // Incomes
    $unitId = getUserUnit($userId);
    if ($unitId) {
        $incomeCount = count($_POST["description"]);
        $success = true; // Initialize success flag

        for ($i = 0; $i < $incomeCount; $i++) {
            $description = SecureData($_POST["description"][$i]);
            $lbpAmount = SecureData($_POST["lbp"][$i]);

            if (!empty($_FILES["attachment"]["tmp_name"][$i]) && !empty($_FILES["attachment"]["name"][$i])) {
                $attachmentName = $_FILES["attachment"]["name"][$i];
                $attachment = $_FILES["attachment"]["tmp_name"][$i];
                $insertSuccess = insertTransaction($description, $lbpAmount, $unitId, $currencyCode, $typeCode, $attachment);
            } else {
                $insertSuccess = insertTransaction($description, $lbpAmount, $unitId, $currencyCode, $typeCode, NULL);
            }

            if (!$insertSuccess) {
                $success = false; 
                $errorMessage = mysqli_stmt_error($insertStatement); 
                break; 
            }
        }

        if ($success) {
            $_SESSION["success_message"] = "Income records inserted successfully in the database.";
            header("Location: ../views/incomesView.php");
            exit();
        } else {
            $_SESSION["error_message"] = "Couldn't insert the records. Please Try again Later";
            header("Location: ../views/incomesView.php");
            exit();     
        }

    } else {
        $_SESSION["error_message"] = "You do not have permission to access this page. <br> Please click <a href='../Login/Login.php'>here</a> to login.";
        header("Location: ../views/incomesView.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submitusd"])) {
    //$userId = 6;
    $currencyCode = 1;//USD
    $typeCode = 0;//Incomes
    $unitId = getUserUnit($userId);
    if ($unitId) {
        $incomeCount = count($_POST["description"]);
        for ($i = 0; $i < $incomeCount; $i++) {
            $description = SecureData($_POST["description"][$i]);
            $usdAmount = SecureData($_POST["usd"][$i]);
            //$attachment = NULL;
            if (!empty($_FILES["attachment"]["tmp_name"][$i]) && !empty($_FILES["attachment"]["name"][$i])) {
                $attachmentName = $_FILES["attachment"]["name"][$i];
                $attachment = $_FILES["attachment"]["tmp_name"][$i];  
                $success = insertTransaction($description, $usdAmount, $unitId, $currencyCode, $typeCode, $attachment);
            }else{
                $success = insertTransaction($description, $usdAmount, $unitId, $currencyCode, $typeCode, NULL);
            }

            //insertTransaction($description, $usdAmount, $unitId,$currencyCode,$typeCode);
        }
        if($success){
            $_SESSION["success_message"] = "Income records inserted successfully in the database.";
            header("Location: ../views/incomesUSDView.php");
            exit();
        }else{
            $_SESSION["error_message"] = "Couldn't insert the records. Please Try again later.";

        header("Location: ../views/incomesUSDView.php");
        exit();
        }
        
    }else {
        $_SESSION["error_message"] = "You do not have permission to access this page. <br> Please click <a href='../Login/Login.php'>here</a> to login.";

        header("Location: ../views/incomesUSDView.php");
        exit();
    }
}
?>

