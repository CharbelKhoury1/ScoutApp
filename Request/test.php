<?php
// Perform your SQL queries here or any other necessary actions
// Add your PHP code logic for the desired action

// Example SQL query
session_start();
include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

$query = "INSERT INTO `event`(`event_id`, `name`, `description`, `date_of_event`, `duration`, `request_id`) VALUES ('96','no name','no desc','2024-01-01','66','17')";
$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: ../ControlRequest/controlRequest.php?error=Request Approved!");
} else {
  echo "An error occurred: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
