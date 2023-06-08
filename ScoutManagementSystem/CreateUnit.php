<?php

// Establish a database connection
$con = new mysqli("localhost", "root", "", "scoutproject");

// Check the database connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    // Get form input values
    $unitName = $_POST['unit-name'];
    $leader = $_POST['unit-leader'];
    $selectedRegiment = $_POST['unit-regiment'];

    $query = "SELECT  regiment_id FROM regiment WHERE regiment.name='".$selectedRegiment."'";
    $result = mysqli_query($con, $query);

    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        $regimentId = $row['regiment_id'];
      }
    }

    // Prepare and execute the INSERT statement
    $stmt = mysqli_prepare($con, "INSERT INTO unit (name,leader,regimentId) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssi', $unitName,$leader,$regimentId);

    // Assuming you have the values for userId and regimentId available
    // $userId = 1; // Replace with the actual value
    // $regimentId = 1; // Replace with the actual value

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "Unit created and data inserted successfully.";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
