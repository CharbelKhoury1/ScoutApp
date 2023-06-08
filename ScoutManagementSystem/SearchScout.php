<?php

$con = mysqli_connect("127.0.0.1", "root", "", "scoutproject") or die("Failed to connect to database: " . mysqli_error($con));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $rank = mysqli_real_escape_string($con, $_POST['rank']);
    $regiment = mysqli_real_escape_string($con, $_POST['regiment']);
    $unit = mysqli_real_escape_string($con, $_POST['unit']);

    $sql = "SELECT u.fname, u.lname, r.name as rank_name, reg.name as regiment_name, un.name as unit_name
            FROM unitrankhistory urh
            INNER JOIN user u ON urh.userId = u.user_id
            INNER JOIN rank r ON urh.rankId = r.rank_id
            INNER JOIN regiment reg ON urh.regimentId = reg.regiment_id
            INNER JOIN unit un ON urh.unitId = un.unit_id
            WHERE 1=1";

    if (!empty($fname)) {
        $sql .= " AND u.fname LIKE '%$fname%'";
    }

    if (!empty($lname)) {
        $sql .= " AND u.lname LIKE '%$lname%'";
    }

    if (!empty($rank)) {
        $sql .= " AND r.name LIKE '%$rank%'";
    }

    if (!empty($regiment)) {
        $sql .= " AND reg.name LIKE '%$regiment%'";
    }

    if (!empty($unit)) {
        $sql .= " AND un.name LIKE '%$unit%'";
    }

    $sql .= " AND urh.end_date IS NULL";

}

?>
