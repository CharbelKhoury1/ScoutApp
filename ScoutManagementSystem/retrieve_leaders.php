<?php
// Assuming you have included the necessary PHP code for database connection
include("../common.inc.php");
include("../utility.php");
$con = connection();

// Check if the 'selectedRegiment' parameter is passed
if (isset($_POST['selectedRegiment'])) {
  $selectedRegiment = $_POST['selectedRegiment'];

  // Retrieve leaders based on the selected regiment
  $query = "SELECT u.fname AS name
            FROM user u
            INNER JOIN unitrankhistory urh ON u.user_id = urh.userId
            INNER JOIN unit un ON urh.unitId = un.unit_id
            INNER JOIN regiment reg ON un.regimentId = reg.regiment_id
            WHERE reg.name = '$selectedRegiment'
            AND urh.end_date IS NULL
            AND u.fname != un.leader";

  $result = mysqli_query($con, $query);

  if ($result) {
    $leaders = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Prepare the JSON response
    $response = array('leaders' => array_column($leaders, 'name')); // Extract the 'name' column from the leaders array
    echo json_encode($response);
  } else {
    echo json_encode(array('leaders' => [])); // Return an empty array if no leaders are found
  }
}
?>
