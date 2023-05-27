<?php

$con=mysqli_connect("127.0.0.1","root","","scoutproject") or die( "Failed to connect to database: ". mysqli_error($con));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
         // Get the search parameters from the form
      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $rank = $_POST['rank'];
      $regiment = $_POST['regiment'];
      $unit = $_POST['unit'];

                  // Prepare the SQL query based on the search parameters
                  $sql = "SELECT user.fname, user.lname, rank.name as rank_name, regiment.name as regiment_name, unit.name as unit_name
                  FROM user
                  INNER JOIN rank ON user.rank_id = rank.rank_id
                  INNER JOIN regiment ON user.user_id = regiment.userId
                  INNER JOIN unit ON regiment.unitId = unit.unit_id
                  WHERE 1 = 1";

            if (!empty($_POST['fname'])) {
            $fname = mysqli_real_escape_string($con, $_POST['fname']);
            $sql .= " AND user.fname LIKE '%$fname%'";
            }

            if (!empty($_POST['lname'])) {
            $lname = mysqli_real_escape_string($con, $_POST['lname']);
            $sql .= " AND user.lname LIKE '%$lname%'";
            }

            if (!empty($_POST['rank'])) {
            $rank = mysqli_real_escape_string($con, $_POST['rank']);
            $sql .= " AND rank.name LIKE '%$rank%'";
            }

            if (!empty($_POST['regiment'])) {
            $regiment = mysqli_real_escape_string($con, $_POST['regiment']);
            $sql .= " AND regiment.name LIKE '%$regiment%'";
            }

            if (!empty($_POST['unit'])) {
            $unit = mysqli_real_escape_string($con, $_POST['unit']);
            $sql .= " AND unit.name LIKE '%$unit%'";
            }

            }
?>
