<?php
// Perform your SQL queries here or any other necessary actions
// Add your PHP code logic for the desired action

// Example SQL query
session_start();
include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

if (isset($_GET['request_id'])) {
  $selectedRequestId = $_GET['request_id'];
  $query = "UPDATE `requeststatus` SET `date`=SYSDATE(),`statusCode`='2' WHERE request_id= $selectedRequestId";
  $result = mysqli_query($conn, $query);

  if ($result) {
    header("Location: ../ControlRequest/requests_approved.php?error=Request Rejected!");
  } else {
    echo "An error occurred: " . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>
