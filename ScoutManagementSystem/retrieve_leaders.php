<?php

// Assuming you have included the necessary PHP code for database connection
$con = mysqli_connect("localhost", "root", "", "scoutproject");
if (!$con) {
  die("Could not connect to the database");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the selected regiment from the AJAX request
  $selectedRegiment = mysqli_real_escape_string($con, $_POST['unit-regiment']);

  // Prepare the SQL query to retrieve the leaders
  $query = "SELECT CONCAT(u.fname, ' ', u.lname) AS leader
            FROM unitrankhistory urh
            INNER JOIN user u ON u.user_id = urh.userId 
            INNER JOIN regiment reg ON reg.regiment_id = urh.regimentId 
            WHERE reg.name = '$selectedRegiment' AND (urh.end_date IS NULL OR urh.end_date = '0000-00-00' OR urh.end_date >= CURDATE())";

  $result = mysqli_query($con, $query);

  if ($result) {
    $leaders = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $leaders[] = $row['leader'];
    }
    mysqli_free_result($result);

    // Return the leaders as JSON response
    echo json_encode(['leaders' => $leaders]);
  } else {
    echo "Error: " . mysqli_error($con);
  }
}

mysqli_close($con);
?>
