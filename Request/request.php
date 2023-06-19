<?php

session_start();

include ("../common.inc.php");
include ("../utility.php");
$conn=connection();


function calculateDaysDifference($d) {
  $sysDate = date('Y-m-d'); // Get the current system date in 'Y-m-d' format

  // Convert the selected date and system date to Unix timestamps
  $selectedTimestamp = strtotime($d);
  $sysTimestamp = strtotime($sysDate);

  // Calculate the difference in seconds
  $difference = $selectedTimestamp - $sysTimestamp;

  // Convert the difference to days
  $daysDifference = floor($difference / (60 * 60 * 24));

  return $daysDifference;
}


if (isset($_POST['submit'])) {
  if (!empty($_POST['dateN']) && !empty($_POST['receiverN']) && !empty($_POST['descriptionN']) && !empty($_FILES['file'])) {
    $d = $_POST['dateN'];
    $rec = $_POST['receiverN'];
    $desc = $_POST['descriptionN'];
    $file = $_FILES['file'];

    $days = calculateDaysDifference($d);
    if($days >= 14){

      $fileName = $file['name'];
      $fileTmpName = $_FILES['file']['tmp_name'];

      // Read file data
      $fileData = file_get_contents($fileTmpName);

      $f = explode('.', $fileName);
      $fileExt = strtolower($f[1]);

      $allowedExt = array('pdf');
      if (in_array($fileExt, $allowedExt)) {
        $sql = "INSERT INTO `requests` (`date_submitted`, `date_of_event`, `approver`, `description`, `name`, `data`) VALUES (SYSDATE(), ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
      
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, 'sssss', $d, $rec, $desc, $fileName, $fileData);
      
        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
      
        if ($result) {
        //header("Location: process.html?");

          $qr4 = "SELECT max(request_id) FROM requests";
          $res4 = mysqli_query($conn, $qr4);
          $row4 = mysqli_fetch_array($res4);
          $idd = $row4[0];

          $qr5 = "INSERT INTO `requeststatus`(`date`, `statusCode`, `request_id` , `userId` ) VALUES (SYSDATE() , '0' , '$idd' , '15')";
          $res5 = mysqli_query($conn, $qr5);

          if (isset($_FILES['mediaFile']) || isset($_POST['caption'])) {

            $cap = $_POST['caption'];
            $mediaFile = $_FILES['mediaFile'];

            $fileN = $mediaFile['name'];
            $fileTmpLocat = $mediaFile['tmp_name'];

            $fM = explode('.', $fileN);
            $fileExtension = strtolower($fM[1]);

            $allowedExtension = array('jpeg', 'jpg', 'png');
            if (in_array($fileExtension, $allowedExtension)) {
              $qr1 = "SELECT max(request_id) FROM requests";
              $res1 = mysqli_query($conn, $qr1);
              $row1 = mysqli_fetch_array($res1);
              $id = $row1[0];

              $qr2 = "SELECT date_of_event FROM requests WHERE request_id=$id";
              $res2 = mysqli_query($conn, $qr2);
              $row2 = mysqli_fetch_array($res2);
              $doe = $row2[0];

              $qr3 = "INSERT INTO `event`(`description`, `date_of_event`, `request_id`) VALUES ('$cap' , '$doe' , '$id')";
              $res3 = mysqli_query($conn, $qr3);

              if ($res3) {
                header("Location: process.html?");
              } else {
                header("Location: requestIndex.php?error=An error occurred. res3!");
              }
            } else{
              header("Location: requestIndex.php?error=File not supported!");
            }
          }else{
            header("Location: requestIndex.php?error=All fields are required!");
          }
        }else{
          header("Location: requestIndex.php?error=An error! result");
        }
      } else {
        header("Location: requestIndex.php?error=File error supported!");
      }
    }else {
      header("Location: requestIndex.php?error=Event date must be 14 days apart from today's date!");
    }
  //header("Location: process.html?");
  } else {
    header("Location: requestIndex.php?error=All fields are required! big");
  }
  //header("Location: process.html?");
}
?>

