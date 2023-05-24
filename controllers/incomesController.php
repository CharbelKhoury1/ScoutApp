<?php
include("../models/incomeModel.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the submitted income data
  $descriptions = $_POST["description"];
  $usdAmounts = $_POST["usd"];
  $lbpAmounts = $_POST["lbp"];

  // Process the income data (you can customize this part according to your needs)
  $incomeCount = count($descriptions);
  for ($i = 0; $i < $incomeCount; $i++) {
    $description = $descriptions[$i];
    $usdAmount = $usdAmounts[$i];
    $lbpAmount = $lbpAmounts[$i];
	echo $description;
	echo $usdAmount;
	echo $lbpAmount;

    // Perform necessary operations with the income data (e.g., save to database)
    // Example: Inserting income data into a database table
    // $query = "INSERT INTO incomes (description, usd, lbp) VALUES ('$description', '$usdAmount', '$lbpAmount')";
    // Execute the query
    // ...
  }

  // Redirect or display a success message
  // ...
}
?>
