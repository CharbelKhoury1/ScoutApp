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
  
  $slt = "SELECT approver FROM requests WHERE request_id = $selectedRequestId";
  $res = mysqli_query($conn, $slt);
  $rw = mysqli_fetch_array($res);
  $approver = $rw[0];
  
  if($approver == "General Commissioner and General Commander (مفوض عام و رئيس)"){

    $query = "UPDATE `requeststatus` SET `date`=SYSDATE(),`statusCode`='1', `flag` = 1 WHERE request_id= $selectedRequestId";
    $result = mysqli_query($conn, $query);
  
    if ($result) {
      header("Location: ../ControlRequest/controlRequest.php?error=Request Approved!");
      include("../Post/mailTwo.php");
    } else {
      echo "An error occurred: " . mysqli_error($conn);
    }
  }
  else{
    $qry = "UPDATE `requeststatus` SET `date`=SYSDATE(),`statusCode`='1' , `flag`= 1 WHERE request_id= $selectedRequestId";
    $rslt = mysqli_query($conn, $qry);
  
    if ($rslt) {
      header("Location: ../ControlRequest/controlRequest.php?error=Request Approved!");
    } else {
      echo "An error occurred: " . mysqli_error($conn);
    }
  }


 
}

mysqli_close($conn);
?>
