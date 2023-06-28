<?php
session_start();

$code = ""; 
$password = "";

if (isset($_GET['code']) && isset($_GET['password'])) {
    // Retrieve the code and password from the query parameters
    $code = $_GET['code'];
    $password = $_GET['password'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="icon" type="image/x-icon" href="ScoutsLogo.gif">
  <link rel="stylesheet" href="SignUp.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet">
  <style>
    .required {
      color: red;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>General Info</h1>
    <form method="post" action="InsertUser.php">
      <label for="firstName">First Name<span class="required">*</span>:</label>
      <input type="text" id="firstName" name="fname" required>

      <label for="lastName">Last Name<span class="required">*</span>:</label>
      <input type="text" id="lastName" name="lname" required>

      <label for="fathername">Father Name<span class="required">*</span>:</label>
      <input type="text" id="fathername" name="father_name" required>

      <label for="mothername">Mother Name<span class="required">*</span>:</label>
      <input type="text" id="mothername" name="mother_name" required>

      <label for="dateofbirth">Date of birth<span class="required">*</span>:</label>
      <input type="date" id="dateofbirth" name="birth_date" required>

      <label for="placeofbirth">Place of birth<span class="required">*</span>:</label>
      <input type="text" id="placeofbirth" name="birth_place" required>

      <label for="bloodtype">Blood Type<span class="required">*</span>:</label>
      <select id="bloodtype" name="blood_type" required>
        <option value="">Select Blood Type</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
      </select>

      <label for="landline">LandLine<span class="required">*</span>:</label>
      <input type="tel" id="landline" name="landline" required>

      <label for="phonenumber">Phone Number:</label>
      <input type="tel" id="phonenumber" name="mobile" pattern="^(03|70|71|76|78|79)\d{6}$" onkeypress="return isNumberKey(event)">

      <label for="fatherjob">Father Job<span class="required">*</span>:</label>
      <input type="text" id="fatherjob" name="father_job" required>

      <label for="fatherphonenumber">Father Phone Number<span class="required">*</span>:</label>
      <input type="tel" id="fatherphonenumber" name="father_mobile" pattern="^(03|70|71|76|78|79)\d{6}$" required onkeypress="return isNumberKey(event)">

      <label for="motherphonenumber">Mother Phone Number:<span class="required">*</span></label>
      <input type="tel" id="motherphonenumber" name="mother_mobile" pattern="^(03|70|71|76|78|79)\d{6}$" onkeypress="return isNumberKey(event)">

      <label for="motherjob">Mother Job<span class="required">*</span>:</label>
      <input type="text" id="motherjob" name="mother_job" required>

      <label for="education">Education Level<span class="required">*</span>:</label>
      <select id="education" name="education" required>
        <option value="">Select Education Level</option>
        <option value="highSchool">High School</option>
        <option value="college">College</option>
        <option value="graduate">Graduate</option>
      </select>

      <label for="job">Job:</label>
      <input type="text" id="job" name="job">

      <label for="email">Email:</label>
      <input type="email" id="email" name="email">

      <label for="medicalcondition">Medical Condition:<span class="required">*</span></label>
      <input type="text" id="medicalcondition" name="medical_condition">

      <input type="hidden" name="scoutcode" value="<?php echo $code; ?>">
      <input type="hidden" name="password" value="<?php echo $password; ?>">

      <input type="submit" name="SignUp1" value="Continue">
    </form>
  </div>
  <script src="SignUp.js"></script>
  <script>
    function isNumberKey(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
