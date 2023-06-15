<?php

// Start a session
session_start();

// Establish a database connection
$con = new mysqli("localhost", "root", "", "scoutproject");

// Check the database connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['SignUp1'])) {
    // Retrieve the form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $fatherName = $_POST['father_name'];
    $motherName = $_POST['mother_name'];
    $birthDate = $_POST['birth_date'];
    $birthPlace = $_POST['birth_place'];
    $bloodType = $_POST['blood_type'];
    $landline = $_POST['landline'];
    $mobile = $_POST['mobile'];
    $fatherJob = $_POST['father_job'];
    $motherJob = $_POST['mother_job'];
    $fatherMobile = $_POST['father_mobile'];
    $motherMobile = $_POST['mother_mobile'];
    $education = $_POST['education'];
    $job = $_POST['job'];
    $email = $_POST['email'];

    // Set the email cookie
    setcookie('email', $email, time() + (30 * 24 * 60 * 60));

    $medicalCondition = $_POST['medical_condition'];


    $code = $_POST['scoutcode'];
    $password = $_POST['password'];
    
    // Perform database operations (assumed connection is established)
    
    // Insert data into the 'user' table
    $sql = "INSERT INTO user (fname, lname, father_name, mother_name, birth_date, birth_place, blood_type, landline, mobile, father_job, mother_job, father_mobile, mother_mobile, education, job, email, medical_condition) 
            VALUES ('$fname', '$lname', '$fatherName', '$motherName', '$birthDate', '$birthPlace', '$bloodType', '$landline', '$mobile', '$fatherJob', '$motherJob', '$fatherMobile', '$motherMobile', '$education', '$job', '$email', '$medicalCondition')";
    
    if (mysqli_query($con, $sql)) {
      // Retrieve the auto-incremented 'user_id'
      $userId = mysqli_insert_id($con);
            
      // Store the 'user_id' in a cookie variable
      setcookie('user_id', $userId , time() + (30 * 24 * 60 * 60));

      // Update 'userId' for the existing record in 'usercredentials' table
      $sqlCredentials = "UPDATE usercredentials SET userId = '$userId' WHERE scoutcode = '$code' AND password = '$password'";
    
      if (mysqli_query($con, $sqlCredentials)) {
        // Data updated successfully
        echo "User registered successfully!";
      } else {
        // Failed to update data in 'usercredentials' table
        echo "Error updating data in 'usercredentials' table: " . mysqli_error($con);
      }
    } else {
      // Failed to insert data into 'user' table
      echo "Error inserting data into 'user' table: " . mysqli_error($con);
    }
    // Redirect to SignUp2.php
    header('Location: SignUp2.php');
    
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['SignUp2'])) {
  // Check if the 'user_id' is set in the session
  
  if (isset($_COOKIE['user_id'])) {
    $userId = $_COOKIE['user_id'];  
    }

    // Retrieve the form data
    $affiliationDate = $_POST['affiliationdate'];
    $oathDate = $_POST['oathdate'];
    $scoutTitle = $_POST['scouttitle'];
    $dateOfTheTitle = $_POST['dateofthetitle'];
    $placeOfTheTitle = $_POST['placeofthetitle'];
    
    // Update the 'user' table
    $sqlUpdate = "UPDATE user SET
                    scoutAdmission_date = '$affiliationDate',
                    scoutOath_date = '$oathDate',
                    scoutTitle = '$scoutTitle',
                    scoutTitle_date = '$dateOfTheTitle',
                    scoutTitle_place = '$placeOfTheTitle'             
                    WHERE user_id = '$userId'";
    
    if (mysqli_query($con, $sqlUpdate)) {
      // Data updated successfully
      echo "User data updated successfully!";
    } else {
      // Failed to update data in 'user' table
      echo "Error updating data in 'user' table: " . mysqli_error($con);
    }


    $scoutRankPresent = $_POST['scoutrankpresent'];
    $scoutRegimentPresent = $_POST['nameofregiment-present'];
    $scoutUnitPresent = $_POST['unit-present'];
    $scoutStartDatePresent = $_POST['startdate-present'];
    
    echo $scoutRankPresent."  ".$scoutRegimentPresent."  ".$scoutUnitPresent."  ".$scoutStartDatePresent;

    // // Retrieve rank_id from the rank table
    $query = "SELECT rank_id FROM rank WHERE name = '$scoutRankPresent'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $rankId = $row['rank_id'];
    } else {
      echo "Error: sasasas Rank not found.";
      exit;
    }
    
    
    // Retrieve unit_id from the unit table
    $query1 = "SELECT unit_id FROM unit WHERE name = '$scoutUnitPresent'";
    $result = mysqli_query($con, $query1);
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $unitId = $row['unit_id'];
    } else {
      echo "Error: Unit not found.";
      exit;
    }
    
    // Insert data into the unitrankhistory table using the retrieved IDs
    $query2 = "INSERT INTO unitrankhistory (start_date, end_date, userId, unitId, rankId) 
              VALUES ('$scoutStartDatePresent', NULL , '$userId', '$unitId', '$rankId')";
     
    if (mysqli_query($con, $query2)) {
      echo "Present Data inserted into unitrankhistory table successfully."."<br>";
    } else {
      echo "Error: " . mysqli_error($con);
    }
  

if(isset($_POST['regiment'])) {

  $scoutRegiments = $_POST['regiment'];
  $scoutUnits = $_POST['unit'];
  $scoutRanks = $_POST['rank'];
  $scoutStartDates = $_POST['start-date'];
  $scoutEndDates = $_POST['end-date'];

  echo "scoutregimentsts:" . var_dump($scoutRegiments)."<br>";
  echo "scoutUnits".var_dump($scoutUnits)."<br>";
  echo "scoutranks".var_dump($scoutRanks)."<br>";
  echo "startdates".var_dump($scoutStartDates)."<br>";
  echo "scoutenddates". var_dump($scoutEndDates)."<br>";


  // Loop through the arrays to process each row
  for ($i = 0; $i < count($scoutRegiments); $i++) {
      $scoutRegiment = $scoutRegiments[$i];
      $scoutUnit = $scoutUnits[$i];
      $scoutRank = $scoutRanks[$i];
      $scoutStartDate = $scoutStartDates[$i];
      $scoutEndDate = $scoutEndDates[$i];

      // Process the row data as needed
    //      Retrieve rank_id from the rank table
    $query = "SELECT rank_id FROM rank WHERE name = '$scoutRank'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $rankId = $row['rank_id'];
    } else {
      echo "Error:  hahahaha Rank not found.";
      exit;
    }
    
    // Retrieve unit_id from the unit table
    $query3 = "SELECT unit_id FROM unit WHERE name = '$scoutUnit'";
    $result2 = mysqli_query($con, $query3);
    if ($result2 && mysqli_num_rows($result2) > 0) {
      $row = mysqli_fetch_assoc($result2);
      $unitId = $row['unit_id'];
    } else {
      echo "Error: Unit not found.";
      exit;
    }

        // Insert the dynamic form field values into the database
        $query4 = "INSERT INTO unitrankhistory (start_date,end_date, userId, unitId, rankId) VALUES ('$scoutStartDate', '$scoutEndDate', '$userId', '$unitId', '$rankId') ";
        if (mysqli_query($con, $query4)) {
          echo "Data inserted into unitrankhistory table successfully.";
        } else {
          echo "Error: " . mysqli_error($con);
        }

      }
    }
    // Scout class part
  // Retrieve the form data
  print_r($_POST);
  $scoutclass = $_POST['scoutclass'];
  $startDate = $_POST['start-Date'];
  $endDate = $_POST['end-Date'];

  // Initialize the INSERT query
  $query = "INSERT INTO degreehistory (userId, degreeId, start_date, end_date) VALUES ";
  
  if (isset($_POST['scoutclass'])){

  for ($i = 0; $i < count($scoutclass); $i++) {
    mysqli_set_charset($con, "utf8"); // Set character encoding to UTF-8
    // Inside the for loop
    $degreeName = mysqli_real_escape_string($con, $scoutclass[$i]);

    // Query the degree table to get the degreeId using prepared statement
    $degreeQuery = "SELECT degree_id FROM degree WHERE name = ?";
    $degreeStatement = mysqli_prepare($con, $degreeQuery);
    mysqli_stmt_bind_param($degreeStatement, 's', $degreeName);
    mysqli_stmt_execute($degreeStatement);
    $degreeResult = mysqli_stmt_get_result($degreeStatement);

    if ($degreeResult && mysqli_num_rows($degreeResult) > 0) {
     
      $degreeRow = mysqli_fetch_assoc($degreeResult);
      print_r($degreeRow);
      $degreeId = $degreeRow['degree_id'];

      // Continue with the rest of the code for inserting the record
      $startDateValue = mysqli_real_escape_string($con, $startDate[$i]);
      $endDateValue = mysqli_real_escape_string($con, $endDate[$i]);

      // Append the values to the query
      $query .= "('$userId', '$degreeId', '$startDateValue', '$endDateValue')";

      // Add a comma if it's not the last record
      if ($i < count($scoutclass) - 1) {
        $query .= ", ";
      }
    } else {
      // Handle the case when the degree query fails
      echo "Degree Query error";
    }
  }

  // Execute the INSERT query
  $result = mysqli_query($con, $query);

  // Check if the query was successful
  if ($result) {
    echo "Data inserted successfully!";
  } else {
    echo "Error: " . mysqli_error($con);
  }

  }

    header("Location: ../Home/Home.php");  
}
    // Close the database connection
    mysqli_close($con);
    ?>