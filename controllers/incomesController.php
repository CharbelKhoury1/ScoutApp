<?php
session_start();
include("../models/incomeModel.php");
if (!isset($_SESSION["user_id"])) {
  header("Location:../Login/Login.php");
  exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $userId = $_SESSION["user_id"];
  $isRank14 = getUserRank($userId);
  if ($isRank14 == 14) {
    $unitId = getUnitId($userId);
    $incomeCount = count($_POST["description"]);
    for ($i = 0; $i < $incomeCount; $i++) {
      $description = SecureData($_POST["description"][$i]);
      $lbpAmount = SecureData($_POST["lbp"][$i]);
      insertIncomeLBP($description, $lbpAmount, $unitId);
    }
  } else {
    header("Location:../Login/Login.php");
    exit();
  }
}
?>
