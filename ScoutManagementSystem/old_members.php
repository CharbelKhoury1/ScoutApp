<?php
session_start();

include ("../common.inc.php");
include ("../utility.php");
$con=connection();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">
    <link rel="stylesheet" href="ScoutCode.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" 
  rel="stylesheet">
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
                      WHERE urh.userId = $userID AND (urh.end_date IS NULL OR urh.end_date = '0000-00-00' OR urh.end_date >= CURDATE())";

            $result = mysqli_query($con, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $transactionButtonDisplayed = false; // Flag to track if transaction button has been displayed

                while ($row = mysqli_fetch_assoc($result)) {
                    $featureName = $row['featureName'];

                    // Display the corresponding part based on the feature name
                    if ($featureName === "generate code") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#code-section\'">';
                        echo '<img src="../Icons//icons8-password.svg">Code/Pass Generator';
                        echo '</button>';
                    } elseif ($featureName === "search scout") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#search-section\'">';
                        echo '<img src="../Icons/search-refraction-svgrepo-com.svg">Search Scout';
                        echo '</button>';
                    } elseif ($featureName === "create unit") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#create-section\'">';
                        echo '<img src="../Icons/add-svgrepo-com.svg">Create Unit';
                        echo '</button>';
                    } elseif ($featureName === "make request") {
                        echo '<button onclick="window.location.href=\'../Request/request.php\'">';
                        echo '<img src="../Icons/git-pull-request-svgrepo-com.svg">Requests';
                        echo '</button>';
                    // } elseif ($featureName === "make transaction" || $featureName === "view transaction") {
                    //     // Check if "make transaction" or "view transaction" has already been displayed
                    //     if (!$transactionButtonDisplayed) {
                    //         echo '<button onclick="window.location.href=\'../views/transactionView.php\'">';
                    //         echo '<img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance';
                    //         echo '</button>';
                    //         $transactionButtonDisplayed = true; // Set the flag to true
                    //     }
                    // }

                    } elseif ($featureName === "change required days") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/changeDays.php\'">';
                        echo '<img src="../Icons/history-svgrepo-com.svg">Change Required Days';
                        echo '</button>';
                    }
                    elseif ($featureName === "view old ones") { // New elseif condition for 'view old ones'
                      echo '<button class="active" onclick="window.location.href=\'../ScoutManagementSystem/old_members.php\'">';
                      echo '<img src="../Icons/hourglass-svgrepo-com.svg">View Old Ones';
                      echo '</button>';
                  }
                  elseif ($featureName === "create course") { // New elseif condition for 'view old ones'
                    echo '<button onclick="window.location.href=\'../ScoutManagementSystem/ScoutCode.php#course-section\'">';
                    echo '<img src="../Icons/syllabus-svgrepo-com.svg">Create Course';
                    echo '</button>';
                }
              }
            }
          }
      
        ?>
        <!-- Add other static buttons here -->
        <!-- <button onclick="redirectToHomeAndScrollToSection('scoutGallery1')">
            <img src="../Icons/world-1-svgrepo-com.svg">Social Media
        </button>
        <button onclick="redirectToHomeAndScrollToSection('testimonial1')">
            <img src="../Icons/system-help-svgrepo-com.svg">About Us
        </button> -->
        <button onclick="window.location.href='../views/contactUsView.php'">
            <img src="../Icons/phone-svgrepo-com.svg">Contact Us
        </button>
    </div>
</div>

    
<?php
                mysqli_set_charset($con, "utf8"); // Set character encoding
// Step 2: Fetch old members' information from the database
$query = "SELECT u.fname, u.lname, r.name AS rank_name, reg.name AS regiment_name, un.name AS unit_name, deg.name AS degree_name, tc.name AS trainingcourses_name, u.blood_type, YEAR(CURRENT_DATE()) - YEAR(u.birth_date) AS age, u.scoutTitle as scout_title, u.scoutTitle_date, u.scoutAdmission_date as admission_date, u.scoutOath_date as oath_date
  FROM unitrankhistory urh
  INNER JOIN user u ON urh.userId = u.user_id
  INNER JOIN rank r ON urh.rankId = r.rank_id
  INNER JOIN unit un ON urh.unitId = un.unit_id
  LEFT JOIN degreehistory dh ON u.user_id = dh.userId
  LEFT JOIN degree deg ON dh.degreeId = deg.degree_id
  LEFT JOIN regiment reg ON un.regimentId = reg.regiment_id
  LEFT JOIN traininghistory th ON urh.userId = th.userId
  LEFT JOIN trainingcourses tc ON th.courseId = tc.course_id
  WHERE urh.end_date IS NULL AND u.active='0'";

$result = mysqli_query($con, $query);

// Step 3: Display member information
echo "<table>";
echo "<caption><h1>Old Ones</h1></caption>"; 
echo "<tr><th>Name</th><th>Rank</th><th>Regiment</th><th>Unit</th><th>Degree</th><th>Training Courses</th><th>Blood Type</th><th>Age</th><th>Scout Title</th><th>Scout Title Date</th><th>Admission Date</th><th>Oath Date</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['fname']." ".$row['lname'];
    $rank = $row['rank_name'];
    $regiment = $row['regiment_name'];
    $unit = $row['unit_name'];
    $degree = $row['degree_name'];
    $trainingCourses = $row['trainingcourses_name'];
    $bloodType = $row['blood_type'];
    $age = $row['age'];
    $scoutTitle = $row['scout_title'];
    $scoutTitleDate = $row['scoutTitle_date'];
    $admissionDate = $row['admission_date'];
    $oathDate = $row['oath_date'];

    echo "<tr>";
    echo "<td>$name</td>";
    echo "<td>$rank</td>";
    echo "<td>$regiment</td>";
    echo "<td>$unit</td>";
    echo "<td>$degree</td>";
    echo "<td>$trainingCourses</td>";
    echo "<td>$bloodType</td>";
    echo "<td>$age</td>";
    echo "<td>$scoutTitle</td>";
    echo "<td>$scoutTitleDate</td>";
    echo "<td>$admissionDate</td>";
    echo "<td>$oathDate</td>";
    echo "</tr>";
}

echo "</table>";


// Step 4: Close database connection
mysqli_close($con);
?>

</body>
<script src="../Home/Home.js"></script>
</html>
