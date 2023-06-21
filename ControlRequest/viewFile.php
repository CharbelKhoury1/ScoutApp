<?php
session_start();
include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

if (isset($_COOKIE['request_id'])) {
  $selectedRequestId = $_COOKIE['request_id'];

  // Retrieve data related to the selected request_id
  $query = "SELECT * FROM requests WHERE request_id = $selectedRequestId";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the data
    $row = mysqli_fetch_assoc($result);
    $file = $row['name'];

    // Access the individual fields
    $fileData = $row['data'];

    // Set appropriate headers for PDF display
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $file . '"');
    header('Content-Length: ' . strlen($fileData));

    // Output the PDF data
    ob_clean();
    flush();
    echo $fileData;
    exit();

  } else {
    echo "No data found for the selected request.";
  }
} else {
  echo "No request_id selected.";
}

// Close the database connection
mysqli_close($conn);
?>
