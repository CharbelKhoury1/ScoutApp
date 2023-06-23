<?php
// Assuming you have included the necessary PHP code for database connection
include ("../common.inc.php");
include ("../utility.php");
$con=connection();

// Check if the 'regiment' parameter is passed
if (isset($_POST['course'])) {
  $selectedCourse = $_POST['course'];

  // Retrieve units based on the selected regiment
  $locationQuery = "SELECT DISTINCT location FROM trainingcourses WHERE trainingcourses.name = '$selectedCourse'";
  $locationsResult = mysqli_query($con, $locationQuery);
  
  if ($locationsResult) {
    $locations = mysqli_fetch_all($locationsResult, MYSQLI_ASSOC);

    // Prepare the JSON response
    $response = array('locations' => array_column($locations, 'location')); // Extract the 'name' column from the units array
    echo json_encode($response);
  } else {
    echo json_encode(array('locations' => [])); // Return an empty array if no units are found
  }
}
?>