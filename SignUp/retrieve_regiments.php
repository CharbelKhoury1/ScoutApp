<?php
// Assuming you have included the necessary PHP code for database connection
$conn = mysqli_connect("localhost", "root", "", "scoutproject");
if (!$conn) {
  die("Could not connect to the database");
}

// Retrieve the regiments from the database
$query = "SELECT DISTINCT name FROM regiment";
$result = mysqli_query($conn, $query);
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<option value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
  }
} else {
  echo "<option value=\"\">Error retrieving regiments</option>";
}
?>
