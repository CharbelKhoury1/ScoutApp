<?php

// Start a session
session_start();

include ("../common.inc.php");
include ("../utility.php");
$con = connection();

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
    $medicalCondition = $_POST['medical_condition'];
    $code = $_POST['scoutcode'];
    $password = $_POST['password'];

    // Prepare the insert statement for 'user' table
    $sql = "INSERT INTO user (fname, lname, father_name, mother_name, birth_date, birth_place, blood_type, landline, mobile, father_job, mother_job, father_mobile, mother_mobile, education, job, email, medical_condition) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sssssssssssssssss", $fname, $lname, $fatherName, $motherName, $birthDate, $birthPlace, $bloodType, $landline, $mobile, $fatherJob, $motherJob, $fatherMobile, $motherMobile, $education, $job, $email, $medicalCondition);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Retrieve the auto-incremented 'user_id'
            $userId = mysqli_insert_id($con);
        
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $userId;
            $_SESSION['name'] = $fname . " " . $lname;
        
            // Update 'userId' for the existing record in 'usercredentials' table
            $sqlCredentials = "UPDATE usercredentials SET userId = ? WHERE scoutcode = ? AND password = ?";
            
            // Prepare the statement
            if ($stmtCredentials = mysqli_prepare($con, $sqlCredentials)) {
                // Bind the parameters
                mysqli_stmt_bind_param($stmtCredentials, "iss", $userId, $code, $password);
        
                // Execute the statement
                if (mysqli_stmt_execute($stmtCredentials)) {
                    // Data updated successfully
                    echo "User registered successfully!";
                    // Redirect to SignUp2.php
                    header('Location: SignUp2.php');
                    exit;
                } else {
                    // Failed to update data in 'usercredentials' table
                    echo "Error updating data in 'usercredentials' table: " . mysqli_error($con);
                }
            } else {
                // Failed to prepare the statement for 'usercredentials' table
                echo "Error preparing statement for 'usercredentials' table: " . mysqli_error($con);
            }
        } else {
            // Failed to execute the insert statement for 'user' table
            echo "Error executing insert statement for 'user' table: " . mysqli_error($con);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Failed to prepare the insert statement for 'user' table
        echo "Error preparing statement for 'user' table: " . mysqli_error($con);
    }

  
  }

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['SignUp2'])) {
  // Check if the 'user_id' is set in the session
  
  if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];  
    }

    // Retrieve the form data
    $affiliationDate = isset($_POST['affiliationdate']) ? $_POST['affiliationdate'] : NULL;
    $oathDate = isset($_POST['oathdate']) ? $_POST['oathdate'] : NULL;
    $scoutTitle = isset($_POST['scouttitle']) ? $_POST['scouttitle'] : NULL;
    $dateOfTheTitle = isset($_POST['dateofthetitle']) ? $_POST['dateofthetitle'] : NULL;
    $placeOfTheTitle = isset($_POST['placeofthetitle']) ? $_POST['placeofthetitle'] : NULL;
    
    
    print_r($_SESSION);
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
      echo "User data updated successfully! ";
  
    } else {
      // Failed to update data in 'user' table
      echo "Error updating data in 'user' table: " . mysqli_error($con);
    }


    $scoutRankPresent = $_POST['scoutrankpresent'];
    $scoutRegimentPresent = $_POST['nameofregiment-present'];
    $scoutUnitPresent = $_POST['unit-present'];
    $scoutStartDatePresent = $_POST['startdate-present'];
    
    // echo $scoutRankPresent."  ".$scoutRegimentPresent."  ".$scoutUnitPresent."  ".$scoutStartDatePresent;

    // Retrieve rank_id from the rank table
    $query = "SELECT rank_id FROM rank WHERE name = '$scoutRankPresent'";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $rankId = $row['rank_id'];
    } else {
      echo "Error: Rank not found.";
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
  $scoutclass = isset($_POST['scoutclass']) ? $_POST['scoutclass'] : NULL;
  $startDate = isset($_POST['start-date']) ? $_POST['start-date'] : NULL;
  $endDate = isset($_POST['end-date']) ? $_POST['end-date'] : NULL;

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

    // Retrieve the posted form data
    $courses = $_POST['course'];
    $locations = $_POST['location'];
    $startDates = $_POST['start-date'];
    $endDates = $_POST['end-date'];
    
    // Prepare and execute the SQL insert statement
    $stmt = $con->prepare("INSERT INTO traininghistory (courseId, userId, location, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    
    for ($i = 0; $i < count($courses); $i++) {
      $courseName = $courses[$i];
      $location = $locations[$i];
      $startDate = $startDates[$i];
      $endDate = $endDates[$i];
    
      // Retrieve the course ID based on the selected course name
      $courseIdQuery = "SELECT course_id FROM trainingcourses WHERE name = ?";
      $courseIdStmt = $con->prepare($courseIdQuery);
      $courseIdStmt->bind_param("s", $courseName);
      $courseIdStmt->execute();
      $courseIdResult = $courseIdStmt->get_result();
      
      if ($courseIdResult->num_rows > 0) {
        $row = $courseIdResult->fetch_assoc();
        $courseId = $row['course_id'];
      } else {
        // Handle the case where the course ID is not found (e.g., display an error message)
        echo "Course ID not found for course: " . $courseName;
        continue;
      }
    
      // Bind the values to the prepared statement
      $stmt->bind_param("iisss", $courseId, $userId, $location, $startDate, $endDate);
    
      // Execute the statement
      $stmt->execute();

      $userId = null;
      $location = null;
      $startDate = null;
      $endDate = null;

    }
    
    // Close the statement and database connection
    $stmt->close();  
    header("Location: ../Home/Home.php");
  }
    // Close the database connection
    mysqli_close($con);
    ?>