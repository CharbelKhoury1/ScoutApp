<?php
// Assuming you have already established a database connection using mysqli_connect

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    // Get form input values
    $unitName = $_POST['unit-name'];
    $regiment = $_POST['unit-regiment'];
    $leader = $_POST['unit-leader'];
    $numPersons = $_POST['unit-members'];
    $selectedRegiment = $_POST['unit-regiment'];

    $query = "SELECT  regiment_id FROM regiment WHERE regiment.name='".$selectedRegiment."'";
    $result = mysqli_query($con, $query);

    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        $regimentId = $row['regiment_id'];
      }
    }

    // Prepare and execute the INSERT statement
    $stmt = mysqli_prepare($con, "INSERT INTO unit (name, nb_person, leader, userId, regimentId) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssii', $unitName, $numPersons, $leader, $userId, $regimentId);

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
