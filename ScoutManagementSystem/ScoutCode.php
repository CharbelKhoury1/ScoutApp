<?php
session_start();

include 'Generate.php';
include 'SearchScout.php';
include 'CreateUnit.php';
include 'CreateCourse.php';

// Assuming you have included the necessary PHP code for database connection
include ("../common.inc.php");
include ("../utility.php");
$con=connection();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Scout Management System</title>
  <link rel="stylesheet" type="text/css" href="ScoutCode.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet">
  <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">
</head>
<body>
<div class="sidebar">
    <div class="logo">
        <img src="../Icons/menu-svgrepo-com.svg" alt="sds">
        <img src="../Icons/arrow-right-svgrepo-com.svg" alt="sdsd">
        <img src="../Icons/close-md-svgrepo-com.svg" alt="dsd">
    </div>
    <div class="links">

        <button class="" onclick="window.location.href='../Home/Home.php'">
            <img src="../Icons/home-alt-svgrepo-com.svg">Home
        </button>
        <?php
        // Assuming you have established a database connection
        if(isset($_SESSION['user_id'])){
            // Step 1: Retrieve feature names using a single SQL query with INNER JOIN
            $userID = $_SESSION['user_id'];
            $query = "SELECT f.description AS featureName
                      FROM unitrankhistory urh
                      INNER JOIN rankfeature rf ON urh.rankId = rf.rankid
                      INNER JOIN features f ON rf.featureid = f.feature_id
                      WHERE urh.userId = $userID AND urh.end_date IS NULL";

            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $transactionButtonDisplayed = false; // Flag to track if transaction button has been displayed

                while ($row = mysqli_fetch_assoc($result)) {
                    $featureName = $row['featureName'];

                     // Display the corresponding part based on the feature name
                      if ($featureName === "generate code") {
                        echo '<button id="codeButton" class="active" onclick="setActiveButton(\'codeButton\'); showSection(\'code-section\')">';
                        echo '<img src="../Icons//icons8-password.svg">Code/Pass Generator';
                        echo '</button>';
                      } elseif ($featureName === "search scout") {
                        echo '<button id="searchButton" class="" onclick="setActiveButton(\'searchButton\'); showSection(\'search-section\')">';
                        echo '<img src="../Icons/search-refraction-svgrepo-com.svg">Search Scout';
                        echo '</button>';
                      } elseif ($featureName === "create unit") {
                        echo '<button id="createButton" class="active" onclick="setActiveButton(\'createButton\'); showSection(\'create-section\')">';
                        echo '<img src="../Icons/add-svgrepo-com.svg">Create Unit';
                        echo '</button>';
                    } elseif ($featureName === "make request") {
                        echo '<button onclick="window.location.href=\'../Request/request.php\'">';
                        echo '<img src="../Icons/git-pull-request-svgrepo-com.svg">Requests';
                        echo '</button>';
                    } elseif ($featureName === "make transaction") {
                        // Check if "view transaction" has already been displayed
                        if (!$transactionButtonDisplayed) {
                            echo '<button onclick="window.location.href=\'../views/transactionView.php\'">';
                            echo '<img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance';
                            echo '</button>';
                            $transactionButtonDisplayed = true; // Set the flag to true
                        }
                    } elseif ($featureName === "view transaction") {
                        // Check if "make transaction" has already been displayed
                        if (!$transactionButtonDisplayed) {
                            echo '<button onclick="window.location.href=\'../views/transactionView.php\'">';
                            echo '<img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance';
                            echo '</button>';
                            $transactionButtonDisplayed = true; // Set the flag to true
                        }
                    }
                    elseif ($featureName === "create course") { // New elseif condition for 'view old ones'
                      echo '<button id="courseButton" class="" onclick="setActiveButton(\'courseButton\'); showSection(\'course-section\')">';
                      echo '<img src="../Icons/syllabus-svgrepo-com.svg">Create Course';
                      echo '</button>';
                  }
                  elseif ($featureName === "change required days") {
                    echo '<button onclick="window.location.href=\'../ScoutManagementSystem/changeDays.php\'">';
                    echo '<img src="../Icons/history-svgrepo-com.svg">Change Required Days';
                    echo '</button>';
                }
                elseif ($featureName === "view old ones") { // New elseif condition for 'view old ones'
                  echo '<button onclick="window.location.href=\'../ScoutManagementSystem/old_members.php\'">';
                  echo '<img src="../Icons/hourglass-svgrepo-com.svg">View Old Ones';
                  echo '</button>';
              }
                }
            }
        }
        ?>
        <!-- Add other static buttons here -->
        <button onclick="redirectToHomeAndScrollToSection('scoutGallery1')">
            <img src="../Icons/world-1-svgrepo-com.svg">Social Media
        </button>
        <button onclick="redirectToHomeAndScrollToSection('testimonial1')">
            <img src="../Icons/system-help-svgrepo-com.svg">About Us
        </button>
        <button onclick="window.location.href='../views/contactUsView.php'">
            <img src="../Icons/phone-svgrepo-com.svg">Contact Us
        </button>
    </div>
</div>

  <h1>Scout Management System</h1>

  <!-- Section: Generate Unique Code and Password -->
  <section id="code-section" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
    <h2>Generate Unique Code and Password</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <table class="input-table">
        <tr>
          <td><label for="first-name">First Name:</label></td>
          <td><input type="text" id="first-name" name="first-name" required></td>
        </tr>
        <tr>
          <td><label for="last-name">Last Name:</label></td>
          <td><input type="text" name="last-name" id="last-name" required></td>
        </tr>
        <tr>
          <td><label for="email">Email:</label></td>
          <td><input type="email" id="email" name="email"></td>
        </tr>
      </table>
      <button type="submit" name="generate">Generate</button>
    </form>

    <table id="result-table">
      <thead>
        <tr>
          <th>Generated Code</th>
          <th>Password</th>
        </tr>
      </thead>
      <tbody>
      <?
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    // Handle the Generate button click event
    // Generate code and password, send email, and display the result
    // Make sure to define $mail, $code, and $password variables
    $email = $_POST['email'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];

    // Check if code and password generation has already been performed for this email
    if (isset($_SESSION['last_email']) && $_SESSION['last_email'] === $email) {
        $result = 'Code and password already generated for this email!';
        echo '<tr>
                <td></td>
                <td></td>
                <td>'.$result.'</td>
              </tr>';
    } else {
        // Generate code and password
        // ...

        // Check if email is already in the sent emails array
        if (isset($_SESSION['sent_emails']) && in_array($email, $_SESSION['sent_emails'])) {
            $result = 'Email already sent a code and password!';
            echo '<tr>
                    <td></td>
                    <td></td>
                    <td>'.$result.'</td>
                  </tr>';
        } else {
            if ($mail->send() && isset($mail) && isset($code) && isset($password)) {
                echo '<tr>
                        <td>'.$code.'</td>
                        <td>'.$password.'</td>
                        <td>Email sent successfully!</td>
                      </tr>';

                // Store the email in the session variable to track the last email entered
                $_SESSION['last_email'] = $email;

                // Add the email to the sent emails array
                $_SESSION['sent_emails'][] = $email;

                // Insert the code, password, and user ID into the database
                // ...

                // Prepare and execute the INSERT statement
                $stmt = mysqli_prepare($con, "INSERT INTO usercredentials (scoutcode, password) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt, 'ss', $code, $password);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    echo "Record was inserted successfully into your database.";
                } else {
                    echo "Error: " . mysqli_error($con);
                }

                mysqli_stmt_close($stmt);
            } else {
                $code = generateCode(6);
                $password = generatePassword($firstName, $lastName);

                // Prepare and execute the INSERT statement
                $stmt = mysqli_prepare($con, "INSERT INTO usercredentials (scoutcode, password) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt, 'ss', $code, $password);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    echo "Record was inserted successfully into your database.";
                    echo '<tr>
                            <td>'.$code.'</td>
                            <td>'.$password.'</td>
                            <td>Operation completed without email!</td>
                          </tr>';

                    // Add the email to the sent emails array
                    $_SESSION['sent_emails'][] = $email;
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            }
        }
    }
}
?>



      </tbody>
    </table>
  </section>



  <!-- Section: Search Scout Members -->
  <section id="search-section" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
    <h2>Search Scout Members</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <table class="input-table">
        <?php
        // Assuming you have established a database connection
        if (isset($_SESSION['user_id'])) {
          ?>
          <tr>
            <td><label for="first-name">First Name:</label></td>
            <td><input type="text" id="first-name" name="fname"></td>
          </tr>
          <tr>
            <td><label for="last-name">Last Name:</label></td>
            <td><input type="text" name="lname" id="last-name"></td>
          </tr>
          <tr>
            <td><label for="rank">Rank:</label></td>
            <td>
              <select id="rank" name="rank">
                <option disabled selected>Select Rank</option> <!-- Disabled placeholder option -->
                <?php
                // Loop through the ranks table to populate options
                $rankQuery = "SELECT `name` FROM `rank`";
                $rankResult = mysqli_query($con, $rankQuery);
                // var_dump($rankResult);
                while ($rankRow = mysqli_fetch_assoc($rankResult)) {
                  // $selected = ($rankRow['name'] == $row['name']) ? 'selected' : '';
                  echo '<option value="' . $rankRow['name'] . '" >' . $rankRow['name'] . '</option>';
                }
                ?>
              </select>
            </td>
          </tr>
          <!-- Rest of the fields -->
          <tr>
            <td><label for="regiment">Regiment:</label></td>
            <td>
              <select id="regiment" name="regiment">
                <option disabled selected>Select Regiment</option> <!-- Disabled placeholder option -->
                <?php
                // Loop through the regiments table to populate options
                $regimentQuery = "SELECT name FROM regiment";
                $regimentResult = mysqli_query($con, $regimentQuery);
                while ($regimentRow = mysqli_fetch_assoc($regimentResult)) {
                  // $selected = ($regimentRow['name'] == $row['name']) ? 'selected' : '';
                  echo '<option value="' . $regimentRow['name'] . '">' . $regimentRow['name'] . '</option>';
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="unit">Unit:</label></td>
            <td>
              <select id="unit" name="unit">
                <option disabled selected>Select Unit</option> <!-- Disabled placeholder option -->
                <?php
                // Loop through the units table to populate options
                $unitQuery = "SELECT name FROM unit";
                $unitResult = mysqli_query($con, $unitQuery);
                while ($unitRow = mysqli_fetch_assoc($unitResult)) {
                  // $selected = ($unitRow['name'] == $row['name']) ? 'selected' : '';
                  echo '<option value="' . $unitRow['name'] . '">' . $unitRow['name'] . '</option>';
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="scoutclass">Scout Class:</label></td>
            <td>
              <select id="scoutclass" name="scoutclass">
                <option disabled selected>Select Scout Class</option> <!-- Disabled placeholder option -->
                <?php
                mysqli_set_charset($con, "utf8"); // Set character encoding
                // Loop through the scout classes table to populate options
                $scoutClassQuery = "SELECT `name` FROM degree";
                $scoutClassResult = mysqli_query($con, $scoutClassQuery);
                while ($scoutClassRow = mysqli_fetch_assoc($scoutClassResult)) {
                  // $selected = ($scoutClassRow['name'] == $row['name']) ? 'selected' : '';
                  echo '<option value="' . $scoutClassRow['name'] . '">' . $scoutClassRow['name'] . '</option>';
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="trainingcourses">Training Courses:</label></td>
            <td>
              <select id="trainingcourses" name="trainingcourses">
                <option disabled selected>Select Training Course</option> <!-- Disabled placeholder option -->
                <?php
                // Loop through the training courses table to populate options
                $trainingCoursesQuery = "SELECT name FROM trainingcourses";
                $trainingCoursesResult = mysqli_query($con, $trainingCoursesQuery);
                while ($trainingCoursesRow = mysqli_fetch_assoc($trainingCoursesResult)) {
                  // $selected = ($trainingCoursesRow['name'] == $row['name']) ? 'selected' : '';
                  echo '<option value="' . $trainingCoursesRow['name'] . '">' . $trainingCoursesRow['name'] . '</option>';
                }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="bloodtype">Blood Type:</label></td>
            <td>
              <select id="bloodtype" name="blood-type">
                <option disabled selected>Select Blood Type</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="age">Age:</label></td>
            <td><input type="number" id="age" name="age"></td>
          </tr>
          
          <tr>
        <td><label for="scouttitle-checkbox">Scout Title:</label></td>
        <td>
          <input type="checkbox" id="scouttitle-checkbox" name="scouttitle-checkbox">
          <label for="scouttitle-checkbox">Has Scout Title</label>
        </td>
      </tr>

      <tr id="scouttitle-row" style="display: none;">
        <td><label for="scouttitle">Scout Title:</label></td>
        <td>
          <input type="text" id="scouttitle" name="scouttitle" disabled>
        
          <input type="Date" id="scouttitle-date" name="scouttitle-date" disabled>
              </td>
      </tr>

      <tr>
        <td><label for="oathdate-checkbox">Scout Oath:</label></td>
        <td>
          <input type="checkbox" id="oathdate-checkbox" name="oathdate-checkbox">
          <label for="oathdate-checkbox">Has Oath Date</label>
        </td>
      </tr>

      <tr id="oathdate-row" style="display: none;">
        <td><label for="oathdate">Oath Date:</label></td>
        <td>
          <input type="date" id="oathdate" name="oathdate" disabled>
        </td>
      </tr>
      <tr>
        <td><label for="admissiontime-checkbox">Scout Admission Time:</label></td>
        <td>
          <input type="checkbox" id="admissiontime-checkbox" name="admissiontime-checkbox">
          <label for="admissiontime-checkbox">Has Admission Date</label>
        </td>
      </tr>

      <tr id="admissiontime-row" style="display: none;">
        <td><label for="admissiontime">Admission Time:</label></td>
        <td>
          <input type="number" id="admissiontime" name="admissiontime" min="0" disabled>
              </td>
              <td>
          <select name="admissionunit" >
          <option disabled selected>Select Unit Time</option>
            <option value="years">Years</option>
            <option value="months">Months</option>
            <option value="weeks">Weeks</option>
            <option value="days">Days</option>
          </select>
              </td>
        </td>
      </tr>
      <tr>
        <td><label for="old-ones-checkbox">Old Ones:</label></td>
        <td>
          <input type="checkbox" id="old-ones-checkbox" name="oldones-checkbox">
          <label for="old-ones-checkbox">Old Ones</label>
        </td>
      </tr>

          <?php
        }
        ?>
      </table>
      <button type="submit" name="search">Search</button>
    </form>


    <table id="search-result-table">
      <thead>
        <tr>
          <th>First Name:</th>
          <th>Last Name:</th>
          <th>Rank</th>
          <th>Regiment</th>
          <th>Unit</th>
          <th>Scout Class</th>
          <th>Training Courses</th>
          <th>Blood Type</th>
          <th>Age</th>
          <th>Scout Title</th>
          <th>Scout Admission Date</th>
          <th>Scout Oath Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            // Handle the Search button click event
            // Execute the query
            $result = mysqli_query($con, $sql);
            if (!$result) {
                die('Error executing the query: ' . mysqli_error($con));
            }

            // Display the search results
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['fname'] . '</td>';
                echo '<td>' . $row['lname'] . '</td>';
                echo '<td>' . $row['rank_name'] . '</td>';
                echo '<td>' . $row['regiment_name'] . '</td>';
                echo '<td>' . $row['unit_name'] . '</td>';
                echo '<td>' . $row['degree_name'] . '</td>';
                echo '<td>' . $row['trainingcourses_name'] . '</td>';
                echo '<td>' . $row['blood_type'] . '</td>';
                echo '<td>' . $row['age'] . '</td>';
                echo '<td>' . $row['scout_title'] . '</td>';
                echo '<td>' . $row['admission_date'] . '</td>';
                echo '<td>' . $row['oath_date'] . '</td>';
                echo '</tr>';
            }
        }
        ?>
      </tbody>
    </table>
  </section>


  <!-- Section: Create Scout Units -->
  <section id="create-section" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
    <h2>Create Scout Units</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <table class="input-table">
        <tr>
          <td><label for="unit-name">Unit Name:</label></td>
          <td><input type="text" id="unit-name" name="unit-name" required></td>
        </tr>
        <tr>
          <td><label for="unit-regiment">Regiment:</label></td>
          <td>
            <select name="unit-regiment" id="unit-regiment" required>
              <!-- Populate the dropdown options with regiments from the database -->
              <?php
              // Assuming you have already established a database connection using mysqli_connect
              $query = "SELECT DISTINCT name FROM regiment";
              $result = mysqli_query($con, $query);

              if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $regiment = $row['name'];
                  echo "<option value='$regiment'>$regiment</option>";
                }
                mysqli_free_result($result);
              } else {
                echo "Error: " . mysqli_error($con);
              }

              mysqli_close($con);
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><label for="unit-leader">Leader:</label></td>
          <td>
            <select name="unit-leader" id="unit-leader">
              <option value="charbel">Charbel</option>
            </select>
          </td>
        </tr>
      </table>
      <button type="submit" name="create">Create Unit</button>
    </form>
  </section>


  <!-- Section : Training courses  -->

  <section id="course-section" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-course'])) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
    <h2>Create Training Courses</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <table class="input-table">
            <tr>
                <td><label for="course-name">Course Name:</label></td>
                <td><input type="text" id="course-name" name="course-name" required></td>
            </tr>
            <tr>
                <td><label for="start-date">Start Date:</label></td>
                <td><input type="date" name="start-date" id="start-date" required></td>
            </tr>
            <tr>
                <td><label for="end-date">End Date:</label></td>
                <td><input type="date" name="end-date" id="end-date" required></td>
            </tr>
            <tr>
                <td><label for="location">Location:</label></td>
                <td><input type="text" name="location" id="location" required></td>
            </tr>
            <tr>
                <td><label for="status">Status:</label></td>
                <td>
                    <select name="status" id="status">
                        <option value="Active">Active</option>
                        <option value="Not Active">Not Active</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="instructor">Instructor:</label></td>
                <td><input type="text" name="instructor" id="instructor" required></td>
            </tr>
        </table>
        <button type="submit" name="create-course">Create Course</button>
    </form>
</section>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#unit-regiment').on('change', function() {
        var selectedRegiment = $(this).val();
        var unitDropdown = $('#unit-leader');

        $.ajax({
          url: 'retrieve_leaders.php', // Replace with the actual PHP file retrieving leaders
          method: 'POST',
          data: { regiment: selectedRegiment },
          dataType: 'json',
          success: function(response) {
            unitDropdown.empty();
            $.each(response.leaders, function(index, leader) {
              unitDropdown.append($('<option>', {
                value: leader,
                text: leader
              }));
            });
          },
          error: function() {
            console.log('Error occurred during leaders retrieval');
          }
        });
      });
    });
  </script>

<script>
  // sidebar js
document.querySelector(".sidebar .logo").addEventListener("click",
function(){
  document.querySelector(".sidebar").classList.toggle("active");
})
</script>

<!-- awal script houwe kermel eza jina mn l home aw hayalla page tenye , ta yzabet l display hasab l button l kabasne -->
<script>
  // Get the fragment identifier from the URL
  const sectionId = window.location.hash.substr(1);

  // Show the corresponding section based on the fragment identifier
  if (sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
      section.style.display = "block";
      const sectionWord = sectionId.split("-")[0]; // Extract the "word" content
      setActiveButton(sectionWord + 'Button'); // Make the corresponding button active
    }
  }
</script>


<!-- tene script houwe kermel eza kenna b shi whde mn hawde l 3 , w bdna nrouh aa whde mennon , ta dghre taamol display lal part l me3niye -->
<script>
  // Function to show the specified section and hide the others
  function showSection(sectionId) {
    // Get all the sections
    const sections = document.getElementsByTagName('section');

    // Iterate through the sections
    for (let i = 0; i < sections.length; i++) {
      const section = sections[i];

      // Check if the section is the target section
      if (section.id === sectionId) {
        section.style.display = "block"; // Show the target section
      } else {
        section.style.display = "none"; // Hide the other sections
      }
    }

    // Update the URL with the section ID without adding a new history entry
 history.replaceState(null, null, `#${sectionId}`);

  // Set the active button and show the corresponding section on page load
  document.addEventListener("DOMContentLoaded", () => {
    if (sectionId) {
      const section = document.getElementById(sectionId);
      if (section) {
        section.style.display = "block";
        const button = document.getElementById(sectionId + "Button");
        if (button) {
          button.classList.add("active");
        }
      }
    }
  });

  }
</script>

<script>
   // Get all the buttons
const buttons = document.querySelectorAll('.links button');

// Add event listener to each button
buttons.forEach(button => {
  button.addEventListener('click', () => {
    // Check if the clicked button is already active
    if (!button.classList.contains('active')) {
      // Remove the active class from all buttons
      buttons.forEach(btn => btn.classList.remove('active'));

      // Add the active class to the clicked button
      button.classList.add('active');
    }
  });
});

</script>

<script>
  // Function to handle the active state of buttons
  function setActiveButton(buttonId) {
    // Get all the buttons
    const buttons = document.querySelectorAll('.links button');

    // Remove the "active" class from all buttons
    buttons.forEach((button) => {
      button.classList.remove('active');
    });

    // Add the "active" class to the clicked button
    document.getElementById(buttonId).classList.add('active');
  }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    
    // Scout Title checkbox
    $('#scouttitle-checkbox').change(function() {
      if ($(this).is(':checked')) {
        $('#scouttitle-row').css('display', 'block');
        $('#scouttitle').prop('disabled', false);
        $('#scouttitle-date').prop('disabled', false);
      } else {
        $('#scouttitle-row').css('display', 'none');
        $('#scouttitle').prop('disabled', true);
        $('#scouttitle-date').prop('disabled', true);
      }
    });

    // Scout Oath checkbox
    $('#oathdate-checkbox').change(function() {
      if ($(this).is(':checked')) {
        $('#oathdate-row').css('display', 'block');
        $('#oathdate').prop('disabled', false);
      } else {
        $('#oathdate-row').css('display', 'none');
        $('#oathdate').prop('disabled', true);
      }
    });

    // Scout Admission Time checkbox
    $('#admissiontime-checkbox').change(function() {
      if ($(this).is(':checked')) {
        $('#admissiontime-row').css('display', 'block');
        $('#admissiontime').prop('disabled', false);
        $('select[name="admissionunit"]').prop('disabled', false);
      } else {
        $('#admissiontime-row').css('display', 'none');
        $('#admissiontime').prop('disabled', true);
        $('select[name="admissionunit"]').prop('disabled', true);
      }
    });
  });
</script>

<script>
  function redirectToHomeAndScrollToSection(sectionId) {
    window.location.href = '../Home/Home.php#' + sectionId;
    setTimeout(function () {
      scrollToSection(sectionId);
    }, 100); // Adjust the delay as needed
  }
  </script>
</body>
</html>
