<?php
// Assuming you have included the necessary PHP code for database connection
$con = mysqli_connect("localhost", "root", "", "scoutproject");
if (!$con) {
  die("Could not connect to the database");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
  $sql = "SELECT u.fname, u.lname, r.name AS rank_name, reg.name AS regiment_name, un.name AS unit_name, deg.name AS degree_name, tc.name AS trainingcourses_name, u.blood_type, YEAR(CURRENT_DATE()) - YEAR(u.birth_date) AS age, u.scoutTitle as scout_title, u.scoutTitle_date, u.scoutAdmission_date as admission_date, u.scoutOath_date as oath_date
  FROM unitrankhistory urh
  INNER JOIN user u ON urh.userId = u.user_id
  INNER JOIN rank r ON urh.rankId = r.rank_id
  INNER JOIN unit un ON urh.unitId = un.unit_id
  LEFT JOIN degreehistory dh ON u.user_id = dh.userId
  LEFT JOIN degree deg ON dh.degreeId = deg.degree_id
  LEFT JOIN regiment reg ON un.regimentId = reg.regiment_id
  LEFT JOIN traininghistory th ON urh.userId = th.userId
  LEFT JOIN trainingcourses tc ON th.courseId = tc.course_id
  WHERE (urh.end_date IS NULL OR urh.end_date = '0000-00-00' OR urh.end_date >= CURDATE())";

  // Construct the WHERE clause based on the available search criteria
  $whereClause = "";

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $fname = isset($_POST['fname']) ? mysqli_real_escape_string($con, $_POST['fname']) : "";
    $lname = isset($_POST['lname']) ? mysqli_real_escape_string($con, $_POST['lname']) : "";
    $rank = isset($_POST['rank']) ? mysqli_real_escape_string($con, $_POST['rank']) : "";
    $regiment = isset($_POST['regiment']) ? mysqli_real_escape_string($con, $_POST['regiment']) : "";
    $unit = isset($_POST['unit']) ? mysqli_real_escape_string($con, $_POST['unit']) : "";
    $scoutTitle = isset($_POST['scouttitle-checkbox']) ? mysqli_real_escape_string($con, $_POST['scouttitle-checkbox']) : "";
    $scoutTitleValue = isset($_POST['scouttitle']) ? mysqli_real_escape_string($con, $_POST['scouttitle']) : "";
    $scoutTitleDate = isset($_POST['scouttitle-date']) ? mysqli_real_escape_string($con, $_POST['scouttitle-date']) : "";
    $oathDate = isset($_POST['oathdate-checkbox']) ? mysqli_real_escape_string($con, $_POST['oathdate-checkbox']) : "";
    $oathDateValue = isset($_POST['oathdate']) ? mysqli_real_escape_string($con, $_POST['oathdate']) : "";
    $admissionTime = isset($_POST['admissiontime-checkbox']) ? mysqli_real_escape_string($con, $_POST['admissiontime-checkbox']) : "";
    $admissionTimeValue = isset($_POST['admissiontime']) ? mysqli_real_escape_string($con, $_POST['admissiontime']) : "";
    $admissionUnit = isset($_POST['admissionunit']) ? mysqli_real_escape_string($con, $_POST['admissionunit']) : "";
    $bloodType = isset($_POST['blood-type']) ? mysqli_real_escape_string($con, $_POST['blood-type']) : "";
    $age = isset($_POST['age']) ? mysqli_real_escape_string($con, $_POST['age']) : "";
    $trainingCourses = isset($_POST['trainingcourses']) ? mysqli_real_escape_string($con, $_POST['trainingcourses']) : "";
    $scoutClass = isset($_POST['scoutclass']) ? mysqli_real_escape_string($con, $_POST['scoutclass']) : "";
    $oldOnes = isset($_POST['oldones-checkbox']) ? mysqli_real_escape_string($con, $_POST['oldones-checkbox']) : "";

    // Construct the WHERE clause based on the available search criteria
    if (!empty($fname)) {
      $whereClause .= " AND u.fname LIKE '%$fname%'";
    }

    if (!empty($lname)) {
      $whereClause .= " AND u.lname LIKE '%$lname%'";
    }

    if (!empty($rank)) {
      $whereClause .= " AND r.name LIKE '%$rank%'";
    }

    if (!empty($regiment)) {
      $whereClause .= " AND reg.name LIKE '%$regiment%'";
    }

    if (!empty($unit)) {
      $whereClause .= " AND un.name LIKE '%$unit%'";
    }

    if (!empty($scoutTitle) && $scoutTitle === 'on') {
      if (!empty($scoutTitleValue)) {
        $whereClause .= " AND (u.scoutTitle LIKE '%$scoutTitleValue%')";
        if (!empty($scoutTitleDate)) {
          $whereClause .= " AND (u.scoutTitle_date IS NOT NULL OR u.scoutTitle_date NOT LIKE '0000-00-00' OR u.scoutTitle_date LIKE '%$scoutTitleDate%')";
        }
      } else {
        $whereClause .= " AND u.scoutTitle IS NOT NULL";
      }
    }

    if (!empty($oathDate) && $oathDate === 'on') {
      if (!empty($oathDateValue)) {
        $whereClause .= " AND (u.scoutOath_date >= '$oathDateValue')";
      } else {
        $whereClause .= " AND (u.scoutOath_date IS NOT NULL OR u.scoutOath_date NOT LIKE '0000-00-00')";
      }
    }

    if (!empty($admissionTime) && $admissionTime === 'on') {
      if (!empty($admissionTimeValue) && !empty($admissionUnit)) {
        // Calculate the admission date based on the admission time and admission unit
        switch ($admissionUnit) {
          case 'weeks':
            $whereClause .= " AND DATE_ADD(u.scoutAdmission_date, INTERVAL $admissionTimeValue WEEK) <= CURDATE()";
            break;
          case 'months':
            $whereClause .= " AND DATE_ADD(u.scoutAdmission_date, INTERVAL $admissionTimeValue MONTH) <= CURDATE()";
            break;
          case 'years':
            $whereClause .= " AND DATE_ADD(u.scoutAdmission_date, INTERVAL $admissionTimeValue YEAR) <= CURDATE()";
            break;
          case 'days':
            $whereClause .= " AND DATE_ADD(u.scoutAdmission_date, INTERVAL $admissionTimeValue DAY) <= CURDATE()";
            break;
        }
      } else {
        $whereClause .= " AND u.scoutAdmission_date IS NOT NULL";
      }
    }

    if (!empty($bloodType)) {
      $whereClause .= " AND u.blood_type LIKE '%$bloodType%'";
    }

    if (!empty($age)) {
      $whereClause .= " AND (YEAR(CURRENT_DATE()) - YEAR(u.birth_date)) >= '$age'";
    }

    if (!empty($trainingCourses)) {
      $whereClause .= " AND tc.name LIKE '%$trainingCourses%'";
    }

    if (!empty($scoutClass)) {
      $whereClause .= " AND deg.name LIKE '%$scoutClass%'";
    }

    // Append the WHERE clause to the main SQL query
    if (!empty($whereClause)) {
      $sql .= $whereClause;
    }

    // Add the condition for the 'active' field based on the 'Old Ones' checkbox
    if (!empty($oldOnes) && $oldOnes === 'on') {
      $sql .= " AND u.active = 0";
    } else {
      $sql .= " AND u.active = 1";
    }
  }
}

?>
