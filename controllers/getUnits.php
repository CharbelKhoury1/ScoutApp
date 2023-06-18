<?php
include("../models/UnitsRegiments.php");

$regimentId = isset($_GET['regiment_id']) ? $_GET['regiment_id'] : null;

if ($regimentId) {
    $units = getUnitsByRegimentId($regimentId);
    header("Content-Type: application/json");
    echo json_encode($units);
}
?>

