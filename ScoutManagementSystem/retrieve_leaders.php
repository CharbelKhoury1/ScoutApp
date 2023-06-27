<?php
// Assuming you have included the necessary PHP code for database connection
$con = mysqli_connect("localhost", "root", "", "scoutproject");
if (!$con) {
  die("Could not connect to the database");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the selected regiment from the Ajax request
  $selectedRegiment = $_POST['unit-regiment'];

  // Assuming you have already established a database connection using mysqli_connect
  $query = "SELECT CONCAT(u.fname, ' ', u.lname) AS name
            FROM user u
            INNER JOIN unitrankhistory urh ON u.user_id = urh.userId
            INNER JOIN unit un ON urh.unitId = un.unitd
            INNER JOIN regiment reg ON un.regimentId = reg.regiment_id
            WHERE reg.name = '$selectedRegiment'
            AND urh.end_date IS NULL
            AND u.fname <> un.leader";

  $result = mysqli_query($con, $query);

  if ($result) {
    $leaderOptions = array();

    while ($row = mysqli_fetch_assoc($result)) {
      $leaderName = $row['name'];
      $leaderOptions[] = $leaderName;
    }

    mysqli_free_result($result);
    mysqli_close($con);

    // Send the leader options as a JSON response
    header('Content-Type: application/json');
    echo json_encode($leaderOptions);
    exit(); // Terminate the script execution after sending the response
  } else {
    echo "Error: " . mysqli_error($con);
  }
}
?>
