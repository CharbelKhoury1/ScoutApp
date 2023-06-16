<?php
$con = mysqli_connect("127.0.0.1", "root", "", "scoutproject") or die("Failed to connect to the database: " . mysqli_error($con));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $rank = mysqli_real_escape_string($con, $_POST['rank']);
    $regiment = mysqli_real_escape_string($con, $_POST['regiment']);
    $unit = mysqli_real_escape_string($con, $_POST['unit']);
    $scoutClass = mysqli_real_escape_string($con, $_POST['scoutclass']);
    $trainingCourses = mysqli_real_escape_string($con, $_POST['trainingcourses']);
    $bloodType = mysqli_real_escape_string($con, $_POST['blood-type']);
    $scoutTitle = mysqli_real_escape_string($con, $_POST['scouttitle']);
    $scoutTitleDate = mysqli_real_escape_string($con, $_POST['scouttitle-date']);
    $admissionTime = mysqli_real_escape_string($con, $_POST['admissiontime']);
    $admissionUnit = mysqli_real_escape_string($con, $_POST['admissionunit']);
    $oathDate = mysqli_real_escape_string($con, $_POST['oathdate']);

    $sql = "SELECT u.fname, u.lname, r.name AS rank_name, reg.name AS regiment_name, un.name AS unit_name, deg.name AS degree_name, tc.name AS trainingcourses_name, u.blood_type, YEAR(CURRENT_DATE()) - YEAR(u.birth_date) AS age, u.scoutTitle, u.scoutTitle_date, u.scoutAdmission_date, u.scoutOath_date
            FROM unitrankhistory urh
            INNER JOIN user u ON urh.userId = u.user_id
            INNER JOIN rank r ON urh.rankId = r.rank_id
            INNER JOIN unit un ON urh.unitId = un.unit_id
            LEFT JOIN degreehistory dh ON u.user_id = dh.userId
            LEFT JOIN degree deg ON dh.degreeId = deg.degree_id
            LEFT JOIN regiment reg ON un.regimentId = reg.regiment_id
            LEFT JOIN trainingcourses tc ON un.unit_id = tc.unit_id
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

    if (isset($_POST['scouttitle-checkbox'])) {
        $sql .= " AND (u.scoutTitle IS NOT NULL OR u.scoutTitle LIKE '%$scoutTitle%')";
    }

    if (isset($_POST['admissiontime-checkbox'])) {
        $sql .= " AND (u.scoutAdmission_date IS NOT NULL OR u.scoutAdmission_date LIKE '%$admissionTime%')";
    }

    if (isset($_POST['oathdate-checkbox'])) {
        $sql .= " AND (u.scoutOath_date IS NOT NULL OR u.scoutOath_date LIKE '%$oathDate%')";
    }

    if (!empty($scoutClass)) {
        $sql .= " AND deg.name = '$scoutClass'";
    }

    if (!empty($trainingCourses)) {
        $sql .= " AND tc.name = '$trainingCourses'";
    }

    if (!empty($bloodType)) {
        $sql .= " AND u.blood_type = '$bloodType'";
    }

    if (!empty($admissionUnit) && !empty($admissionTime)) {
        // Calculate the admission date based on the admission time and admission unit
        switch ($admissionUnit) {
            case 'weeks':
                $sql .= " AND DATE_ADD(u.scoutAdmission_date, INTERVAL $admissionTime WEEK) <= CURDATE()";
                break;
            case 'months':
                $sql .= " AND DATE_ADD(u.scoutAdmission_date, INTERVAL $admissionTime MONTH) <= CURDATE()";
                break;
            case 'years':
                $sql .= " AND DATE_ADD(u.scoutAdmission_date, INTERVAL $admissionTime YEAR) <= CURDATE()";
                break;
        }
    }

    $sql .= " AND urh.end_date IS NULL";
}
?>
