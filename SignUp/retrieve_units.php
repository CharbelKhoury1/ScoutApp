<?php
// Assuming you have included the necessary PHP code for database connection
$conn = mysqli_connect('localhost', 'root', '', 'scoutproject');
if (!$conn) {
  die('Could not connect to the database');
}

// Check if the 'regiment' parameter is passed
if (isset($_POST['regiment'])) {
  $selectedRegiment = $_POST['regiment'];

  // Retrieve units based on the selected regiment
  $unitsQuery = "SELECT unit.name FROM unit INNER JOIN regiment ON unit.regimentId = regiment.regiment_id WHERE regiment.name = '$selectedRegiment'";
  $unitsResult = mysqli_query($conn, $unitsQuery);
  
  if ($unitsResult) {
    $units = mysqli_fetch_all($unitsResult, MYSQLI_ASSOC);

    // Prepare the JSON response
    $response = array('units' => array_column($units, 'name')); // Extract the 'name' column from the units array
    echo json_encode($response);
  } else {
    echo json_encode(array('units' => [])); // Return an empty array if no units are found
  }
}
?>
