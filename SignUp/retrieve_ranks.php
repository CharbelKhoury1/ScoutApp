<?php
// Assuming you have included the necessary PHP code for database connection
$con = mysqli_connect("localhost", "root", "", "scoutproject");
if (!$con) {
  die("Could not connect to the database");
}

// Retrieve the regiments from the database
$query = "SELECT name FROM rank";
$result = mysqli_query($con, $query);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
  }
} else {
  echo "<option value=\"\">Error retrieving regiments</option>";
}
?>