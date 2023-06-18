<?php

// Assuming you have included the necessary PHP code for database connection
$con = mysqli_connect("localhost", "root", "", "scoutproject");
if (!$con) {
  die("Could not connect to the database");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    // Get form input values
    $unitName = $_POST['unit-name'];
    $leader = $_POST['unit-leader'];
    $selectedRegiment = $_POST['unit-regiment'];

    // Convert the unit name to lowercase
    $unitNameLower = strtolower($unitName);

    // Check if the unit already exists
    $stmt = $con->prepare("SELECT * FROM unit WHERE LOWER(name) = ?");
    $stmt->bind_param('s', $unitNameLower);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // echo "Unit already exists.";
    } else {
        // Get the regiment ID based on the selected regiment name
        $query = "SELECT regiment_id FROM regiment WHERE name = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $selectedRegiment);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $row = $result->fetch_assoc();
            $regimentId = $row['regiment_id'];
        } else {
            echo "Error: " . $con->error;
            exit();
        }

        // Prepare and execute the INSERT statement
        $stmt = $con->prepare("INSERT INTO unit (name, leader, regimentId) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $unitName, $leader, $regimentId);
        $result = $stmt->execute();

        if ($result) {
            echo "Unit created and data inserted successfully.";
        } else {
            echo "Error: " . $con->error;
        }
    }

    $stmt->close();
}

$con->close();

?>
