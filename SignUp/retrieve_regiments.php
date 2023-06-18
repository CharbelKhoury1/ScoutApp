<?php
// Assuming you have included the necessary PHP code for database connection
include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

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
