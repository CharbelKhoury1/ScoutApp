<?php 
function connection(){
    $conn = mysqli_connect("127.0.0.1","root","","scoutproject") or die("Failed to connect to database: " . mysqli_error($conn));
    return $conn;
}

function insertTransaction($description, $amount, $unitId, $currencyCode, $typeCode, $attachment) {
    $con = connection();
    $date = date("Y-m-d");
    $content = file_get_contents($attachment);
    $insertQRY = 'INSERT INTO transaction (transaction_amount, transaction_description, `Date`, `attachment`, currencyCode, typeCode, unitId) VALUES(?,?,?,?,?,?,?)';
    $insertStatement = mysqli_prepare($con, $insertQRY);
    mysqli_stmt_bind_param($insertStatement, "dsssiii", $amount, $description, $date, $content, $currencyCode, $typeCode, $unitId);
    $success = mysqli_stmt_execute($insertStatement);
    mysqli_close($con);
    return $success;
}


$con = connection();
$query = "SELECT * FROM `transaction`";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the data
    $row = mysqli_fetch_assoc($result);
    $fileData = $row['attachment'];

    // Set appropriate headers for PDF display
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline;');
    header('Content-Length: ' . strlen($fileData));

    // Output the PDF data
    ob_clean();
    flush();
    echo $fileData;
    exit();
  
    
}


    

?>

<!DOCTYPE html>
<html>
<head>
    <title>PDF File Upload</title>
</head>
<body>
    <h1>PDF File Upload</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileUpload" accept="application/pdf">
        <button type="submit">Upload</button>
    </form>

    
    
</body>
</html>

<?php 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["fileUpload"]) && $_FILES["fileUpload"]["error"] === UPLOAD_ERR_OK) {
        $attachment = $_FILES["fileUpload"]["tmp_name"];

        // Call the insertTransaction function with the provided values and attachment
        $success = insertTransaction("la", 123, 8, 0, 1, $attachment);

        if ($success) {
            echo "Transaction inserted successfully.";
        } else {
            echo "Failed to insert transaction.";
        }
    }
}
?>

