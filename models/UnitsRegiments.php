<?php
include("../utility.php");
include("../common.inc.php");
function getAllRegimentNames() {
    $con = connection();
    $sql = "SELECT `regiment_id`, `name` FROM regiment";
    $result = mysqli_query($con, $sql);
    $regiments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $regiments[] = array(
            'name' => $row['name'],
            'regiment_id' => $row['regiment_id']
        );
    }
    mysqli_close($con);

    return $regiments;
}

function getUnitsByRegimentId($regimentId) {
    $con = connection();
    $sql = "SELECT `unit_id`, `name` FROM unit WHERE `regimentId` = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $regimentId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $unitId, $unitName);
    $units = array();
    while (mysqli_stmt_fetch($stmt)) {
        $units[] = array(
            'unit_id' => $unitId,
            'name' => $unitName
        );
    }
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    return $units;
}
?>