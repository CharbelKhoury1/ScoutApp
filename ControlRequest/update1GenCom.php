<?php
// Perform your SQL queries here or any other necessary actions
// Add your PHP code logic for the desired action

// Example SQL query
session_start();
include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

if (isset($_COOKIE['request_id'])) {
  $selectedRequestId = $_COOKIE['request_id'];
  $query = "UPDATE `requeststatus` SET `date`=SYSDATE(),`statusCode`='2' , `flag`= 3 WHERE request_id= $selectedRequestId";
  $result = mysqli_query($conn, $query);

  if ($result) {
    header("Location: ../ControlRequest/requests_approved_GenCom.php?error=Request Rejected!");
  } else {
    echo "An error occurred: " . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>
