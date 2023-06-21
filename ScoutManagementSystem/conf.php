<?php
// Perform your SQL queries here or any other necessary actions
// Add your PHP code logic for the desired action

// Example SQL query
session_start();
include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

$val = $_POST['quantity'];

$query = "UPDATE `requestsetting` SET `days_difference`=$val";
$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: ../ScoutManagementSystem/changeDays.php?error=Days difference changed successfully!");
} else {
  echo "An error occurred: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
