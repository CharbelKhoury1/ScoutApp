<?php 
session_start();
$con=mysqli_connect("127.0.0.1","root","","scoutproject") or die( "Failed to connect to database: ". mysqli_error($con));?>
<!DOCTYPE html>
<html>
  <head>
    <title>My Website</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../views/css/sideBar.css">
  </head>
  <body> 
  <div class="sidebar">
    <div class="logo">
        <img src="../Icons/menu-svgrepo-com.svg" alt="sds">
        <img src="../Icons/arrow-right-svgrepo-com.svg" alt="sdsd">
        <img src="../Icons/close-md-svgrepo-com.svg" alt="dsd">
    </div>
    <div class="links">

    <button class="" onclick="redirectToHomeAndScrollToSection('hero')">
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
                        echo '<button active="class" onclick="window.location.href=\'../Request/request.php\'">';
                        echo '<img src="../Icons/git-pull-request-svgrepo-com.svg">Requests';
                        echo '</button>';
                    } elseif ($featureName === "make transaction" || $featureName === "view transaction") {
                        // Check if "make transaction" or "view transaction" has already been displayed
                        if (!$transactionButtonDisplayed) {
                            echo '<button onclick="window.location.href=\'../views/transactionView.php\'">';
                            echo '<img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance';
                            echo '</button>';
                            $transactionButtonDisplayed = true; // Set the flag to true
                        }
                    } elseif ($featureName === "change required days") {
                        echo '<button onclick="window.location.href=\'../ScoutManagementSystem/changeDays.php\'">';
                        echo '<img src="../Icons/history-svgrepo-com.svg">Change Required Days';
                        echo '</button>';
                    }
                    elseif ($featureName === "view old ones") { // New elseif condition for 'view old ones'
                      echo '<button onclick="window.location.href=\'../ScoutManagementSystem/old_members.php\'">';
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
    
  
    <script src="../Home/Home.js"></script>
  </body>
</html>



<?php



include ("../common.inc.php");
include ("../utility.php");
$conn=connection();


function calculateDaysDifference($dddd) {

  $sysDate = date('Y-m-d'); // Get the current system date in 'Y-m-d' format

  // Convert the selected date and system date to Unix timestamps
  $selectedTimestamp = strtotime($dddd);
  $sysTimestamp = strtotime($sysDate);

  // Calculate the difference in seconds
  $difference = $selectedTimestamp - $sysTimestamp;

  // Convert the difference to days
  $daysDifference = floor($difference / (60 * 60 * 24));

  return $daysDifference;
}


if (isset($_POST['submit'])) {
  if (!empty($_POST['dateN']) && !empty($_POST['receiverN'])  && !empty($_FILES['file'])) {
    $d = $_POST['dateN'];
    $rec = $_POST['receiverN'];
    $desc = $_POST['descriptionN'];
    $file = $_FILES['file'];

    $days = calculateDaysDifference($d);
    $dayquery = "SELECT days_difference FROM requestsetting";
    $dayresult = mysqli_query($conn, $dayquery);
    $dayrow = mysqli_fetch_array($dayresult);
    $nb = $dayrow[0];

    if($days >= $nb){

      $fileName = $file['name'];
      $fileTmpName = $_FILES['file']['tmp_name'];

      // Read file data
      $fileData = file_get_contents($fileTmpName);

      $f = explode('.', $fileName);
      $fileExt = strtolower($f[1]);

      $sql = "INSERT INTO `requests` (`date_submitted`, `date_of_event`, `approver`, `description`, `name`, `data`) VALUES (SYSDATE(), ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      
      // Bind the parameters
      mysqli_stmt_bind_param($stmt, 'sssss', $d, $rec, $desc, $fileName, $fileData);
      
      // Execute the statement
      $result = mysqli_stmt_execute($stmt);
      
      if ($result) {


        $qr4 = "SELECT max(request_id) FROM requests";
        $res4 = mysqli_query($conn, $qr4);
        $row4 = mysqli_fetch_array($res4);
        $idd = $row4[0];

        $qr5 = "INSERT INTO `requeststatus`(`date`, `statusCode`, `request_id` , `userId` ) VALUES (SYSDATE() , '0' , '$idd' , '15')";
        $res5 = mysqli_query($conn, $qr5);

        if (!empty($_FILES['mediaFile']) || !empty($_POST['caption'])) {

          $cap = $_POST['caption'];
          $mediaFile = $_FILES['mediaFile'];

          $fileN = $mediaFile['name'];
          $fileTmpLocat = $mediaFile['tmp_name'];

          $fM = explode('.', $fileN);
          $fileExtension = strtolower($fM[1]);

          $qr1 = "SELECT max(request_id) FROM requests";
          $res1 = mysqli_query($conn, $qr1);
          $row1 = mysqli_fetch_array($res1);
          $id = $row1[0];

          $qr2 = "SELECT date_of_event FROM requests WHERE request_id=$id";
          $res2 = mysqli_query($conn, $qr2);
          $row2 = mysqli_fetch_array($res2);
          $doe = $row2[0];

          $qr3 = "INSERT INTO `event`(`description`, `date_of_event`, `request_id`) VALUES ('$cap' , '$doe' , '$id')";
          $res3 = mysqli_query($conn, $qr3);

           if ($res3) {
            header("Location: process.html?");
            include("../Post/mail.php");
     
          } else {
                header("Location: request.php?error=An error occurred. res3!");
              }
        }else{
          header("Location: process.html?error=An error! result");
        }
      } else {
        header("Location: request.php?error error not supported!");
      }
    }else {
      $message = "Days difference is less than the required value $nb.";
      echo "<p class='error-message'>$message</p>";
      
    }

  } else {
    header("Location: request.php?error=All fields are required! big");
  }

}
?>


<!DOCTYPE html>
<html ng-app="app">

  <head>
    <title>Request Page</title>
    <script data-require="jquery@2.2.0" data-semver="2.2.0" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link data-require="bootstrap-css@3.3.6" data-semver="3.3.6" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" />
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel = "stylesheet" href = "design.css"/>
  </head>

  <body>

    <div class="container" ng-controller="FirstCtrl">
      <table class="table table-bordered table-downloads">
        <thead>
          <tr>
            <th>Select</th>
            <th>File name</th>
            <th>Downloads</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="tableData in tableDatas">
            <td>
              <div class="checkbox">
                <input type="checkbox" name="{{tableData.name}}" id="{{tableData.name}}" value="{{tableData.name}}" ng-model="tableData.checked" ng-change="selected()" />
              </div>
            </td>
            <td>{{tableData.fileName}}</td>
            <td>
              <a target="_self" id="download-{{tableData.name}}" ng-href="{{tableData.filePath}}" class="btn btn-success pull-right downloadable" download="">Download</a>
            </td>
          </tr>
        </tbody>
      </table>
      <a class="btn btn-success pull-right" ng-click="downloadAll()">Download Selected</a>
    </div>

    <section>

      <form action="" method="POST" enctype="multipart/form-data">
        <h2>Request Details</h2>

        <!--<div class="container">-->
          <div class="container1">
            <input type = "file" class="upload-box" name="file" id = "file-input" accept=".pdf" required/>
          </div>
          
          <table class="input-table">
            <tr>
            
            </tr>
            <tr>
              <div id="message"></div>
              <td><label for="date">Select Event Date:</label></td>
              <td><input type="date" name="dateN" id="date" required></td>
            </tr>
            <tr>

              <td><label for="user">Receiver:</label></td>
              <td><select name="receiverN" id="receiver">
              <option value="Mofawad 3am">General Commissioner (مفوض عام)</option>
              <option value="Ra2is">General Commissioner & General Commander (مفوض عام و رئيس)</option>
              </select></td>
            </tr>
            <tr>
              <td><label for="rank">Description:</label></td>
              <td><textarea  id="description" name="descriptionN" style="resize: none;" rows="7" cols="115"></textarea></td>
            </tr>
          </table>
      
          <h2>Social Media</h2>     
          Please note that this section is not required, and if filled it's not posted on social media until it's accepted by the receiver.
          <label for="checkbox"></label>
          <input type="checkbox" id="checkbox">
          <div id = "contentToHide"> 

            <div class="container">
             
              <div class="container1">
              <input type = "file" id = "f-input" name="mediaFile" accept="image/*" multiple/>
          </div>
              <div id = "num-files"></div>
                <ul id = "f-list"></ul>  
              </div>

              <table class="input-table">
                <tr>
                  <td><label for="rank">Caption:</label></td>
                  <td><textarea  style="resize: none;" id="caption" name="caption" rows="7" cols="115"></textarea></td>
                </tr>
              </table>
            </div>
          </div>
          <!--<a class="btn btn-success pull-right" type="submit" id="submitBtn" name="submit">Submit</a> -->
          <input type="submit" id="submitBtn" name="submit" value="Submit">
          <!--<button type="submit" id="submitBtn" name="submit">Submit</button>-->
        </div>
      </form>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <!-- <script src="daysDifference.js"></script> -->
    <!--<script src="notify.js"></script>-->
    <script src="download.js"></script>
    <!--<script src="uploadFiles.js"></script>-->
    <script src="uploadSocialMedia.js"></script>
    <script src="hidden.js"></script>

    
  </body>


</html>