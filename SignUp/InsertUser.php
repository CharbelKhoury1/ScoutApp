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
      $code = $_POST['scoutcode'];
      $password = $_POST['password'];

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

      //insert the email in the session
      $_SESSION['email']=$email;

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
              
        // Store the 'user_id' in a session variable
        $_SESSION['user_id'] = $userId;

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
      // exit();

  }

  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['SignUp2'])) {
    // Check if the 'user_id' is set in the session
    
    if (isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id'];  
    }

      // Retrieve the form data
      // $scoutClass = $_POST['scoutclass'];
      $affiliationDate = $_POST['affiliationdate'];
      $oathDate = $_POST['oathdate'];
      $scoutTitle = $_POST['scouttitle'];
      $dateOfTheTitle = $_POST['dateofthetitle'];
      $placeOfTheTitle = $_POST['placeofthetitle'];
      // $trainingCourses = $_POST['trainingcourses'];
      
      // Perform database operations (assumed connection is established)
      
      // scoutClass = '$scoutClass',
      //  trainingCourses = '$trainingCourses'
      
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

          $scoutRank = $_POST['scoutrank'];

          // Retrieve the rank_id based on the scout rank from the rank table
          $query = "SELECT rank_id FROM rank WHERE name = '$scoutRank'";
          $result = mysqli_query($con, $query);
          if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $rankId = $row['rank_id'];

            // Update the rank_id in the user table
            $updateQuery = "UPDATE user SET rank_id = '$rankId' WHERE user_id = '$userId'";
            if (mysqli_query($con, $updateQuery)) {
              echo "Rank ID updated successfully in the user table";
            } else {
              echo "Error updating rank ID: " . mysqli_error($con);
            }
          } else {
            echo "Error retrieving rank ID from the rank table";
          }


          // Insert a new record into the regiment table
          // $scoutUnit = $_POST['scoutunit']; //Assuming you have a select field with the name 'unit'
        //  $regimentName = $_POST['nameofregiment'];


    //   // Retrieve the unit_id based on the unit name from the unit table
    //   $unitQuery = "SELECT unit_id FROM unit WHERE name = '$unitName'";
    //   $unitResult = mysqli_query($con, $unitQuery);
    //   if ($unitResult && mysqli_num_rows($unitResult) > 0) {
    //     $unitRow = mysqli_fetch_assoc($unitResult);
    //     $unitId = $unitRow['unit_id'];

    //     // Insert the record into the regiment table
    //     $insertQuery = "INSERT INTO regiment (name, user_id, unit_id) VALUES ('$regimentName', '$userId', '$unitId')";
    //     if (mysqli_query($con, $insertQuery)) {
    //       echo "Record inserted successfully into the regiment table";
    //     } else {
    //       echo "Error inserting record: " . mysqli_error($con);
    //     }
    //   } else {
    //     echo "Error retrieving unit ID from the unit table";
    //   }
    //  } else {
    //   echo "Error retrieving rank ID from the rank table";
    // }
      
    header("Location: ../Home/Home.php");

      // Close the database connection
      mysqli_close($con);
  } 
  ?>