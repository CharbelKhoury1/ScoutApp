<?php
session_start();
$con=mysqli_connect("127.0.0.1","root","","scoutproject") or die( "Failed to connect to database: ". mysqli_error($con));?>
<!DOCTYPE html>
<html>
  <head>
    <title>My Website</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../views/css/sideBar.css">
  </head>
  <body> 
  <div class="sidebar">
    <div class="logo">
        <img src="../Icons/menu-svgrepo-com.svg" alt="sds">
        <img src="../Icons/arrow-right-svgrepo-com.svg" alt="sdsd">
        <img src="../Icons/close-md-svgrepo-com.svg" alt="dsd">
    </div>
    <div class="links">

        <button  onclick="window.location.href = '../Home/Home.php'">
            <img src="../Icons/home-alt-svgrepo-com.svg">Home
        </button>
        <?php

        // Assuming you have established a database connection
        if(isset($_SESSION['user_id'])){
            // Step 1: Retrieve feature names using a single SQL query with INNER JOIN
            $userID = $_SESSION['user_id'];
            $query = "SELECT f.description AS featureName
                      FROM unitrankhistory urh
                      INNER JOIN rankfeature rf ON urh.rankId = rf.rankid
                      INNER JOIN features f ON rf.featureid = f.feature_id
                      WHERE urh.userId = $userID AND urh.end_date IS NULL";

            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $transactionButtonDisplayed = false; // Flag to track if transaction button has been displayed

                while ($row = mysqli_fetch_assoc($result)) {
                    $featureName = $row['featureName'];

                    // Display the corresponding part based on the feature name
                    if ($featureName === "generate code") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#code-section\'">';
                        echo '<img src="../Icons//icons8-password.svg">Code/Pass Generator';
                        echo '</button>';
                    } elseif ($featureName === "search scout") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#search-section\'">';
                        echo '<img src="../Icons/search-refraction-svgrepo-com.svg">Search Scout';
                        echo '</button>';
                    } elseif ($featureName === "create unit") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#create-section\'">';
                        echo '<img src="../Icons/add-svgrepo-com.svg">Create Unit';
                        echo '</button>';
                    } elseif ($featureName === "make request") {
                        echo '<button onclick="window.location.href=\'../Request/request.php\'">';
                        echo '<img src="../Icons/git-pull-request-svgrepo-com.svg">Requests';
                        echo '</button>';
                    } elseif ($featureName === "make transaction") {
                        // Check if "view transaction" has already been displayed
                        if (!$transactionButtonDisplayed) {
                            echo '<button onclick="window.location.href=\'../views/transactionView.php\'">';
                            echo '<img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance';
                            echo '</button>';
                            $transactionButtonDisplayed = true; // Set the flag to true
                        }
                    } elseif ($featureName === "view transaction") {
                        // Check if "make transaction" has already been displayed
                        if (!$transactionButtonDisplayed) {
                            echo '<button onclick="window.location.href=\'../views/transactionView.php\'">';
                            echo '<img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance';
                            echo '</button>';
                            $transactionButtonDisplayed = true; // Set the flag to true
                        }
                    }
                }
            }
        }
        ?>
        <!-- Add other static buttons here -->
     
        <button onclick="redirectToHomeAndScrollToSection('scoutGallery1')">
            <img src="../Icons/world-1-svgrepo-com.svg">Social Media
        </button>
        <button onclick="redirectToHomeAndScrollToSection('testimonial1')">
            <img src="../Icons/system-help-svgrepo-com.svg">About Us
        </button>
        <button class="" onclick="window.location.href='../views/contactUsView.php'">
            <img src="../Icons/phone-svgrepo-com.svg">Contact Us
        </button>
    </div>
</div>
    <script src="../views/javascript/sideBar.js"></script>
  </body>
</html>
