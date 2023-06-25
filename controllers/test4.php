<?php

function connection()
{
    $conn = mysqli_connect("127.0.0.1", "root", "", "scoutproject") or die("Failed to connect to database: " . mysqli_error($conn));
    return $conn;
}

$con = connection();

$query = "SELECT * FROM `transaction` WHERE transaction_id = 65";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fileData = $row['attachment'];

    $fileExtension = pathinfo($row['attachment'], PATHINFO_EXTENSION);

    $contentType = 'application/pdf';
        
      
    header('Content-Type: ' . $contentType);
    header('Content-Disposition: attachment; filename="transaction_attachment.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . strlen($fileData));

    ob_clean();

       
    echo $fileData;
    exit();
    } 
?>


