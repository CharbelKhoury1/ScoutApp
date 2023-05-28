<?php

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
       
    header('Location: SignUp2.php?user_id=' . $userId);

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['SignUp2'])) {
    // Retrieve the user_id from the URL
    $userId = $_GET['user_id'];
   
    // Retrieve the form data
    $scoutRank = $_POST['scoutrank'];
    $regimentName = $_POST['nameofregiment'];
    $scoutUnit = $_POST['scoutunit'];
    $scoutClass = $_POST['scoutclass'];
    $affiliationDate = $_POST['affiliationdate'];
    $oathDate = $_POST['oathdate'];
    $scoutTitle = $_POST['scouttitle'];
    $dateOfTheTitle = $_POST['dateofthetitle'];
    $placeOfTheTitle = $_POST['placeofthetitle'];
    $trainingCourses = $_POST['trainingcourses'];
    
    // Perform database operations (assumed connection is established)
    
    // Update the 'user' table
    $sqlUpdate = "UPDATE user SET
                    scoutRank = '$scoutRank',
                    regimentName = '$regimentName',
                    scoutUnit = '$scoutUnit',
                    scoutClass = '$scoutClass',
                    affiliationDate = '$affiliationDate',
                    oathDate = '$oathDate',
                    scoutTitle = '$scoutTitle',
                    dateOfTheTitle = '$dateOfTheTitle',
                    placeOfTheTitle = '$placeOfTheTitle',
                    trainingCourses = '$trainingCourses'
                  WHERE user_id = '$userId'";
    
    if (mysqli_query($con, $sqlUpdate)) {
      // Data updated successfully
      echo "User data updated successfully!";
    } else {
      // Failed to update data in 'user' table
      echo "Error updating data in 'user' table: " . mysqli_error($con);
    }
    
    // Close the database connection
    mysqli_close($con);
    
    }
?>