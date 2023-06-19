<?php

session_start();
include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

if (isset($_POST['submit'])) {
  if (isset($_POST['dateN']) && isset($_POST['receiverN']) && isset($_POST['descriptionN']) && isset($_FILES['file'])) {
    $d = $_POST['dateN'];
    $rec = $_POST['receiverN'];
    $desc = $_POST['descriptionN'];
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];

    // Read file data
    $fileData = file_get_contents($fileTmpName);

    $f = explode('.', $fileName);
    $fileExt = strtolower($f[1]);

    $allowedExt = array('pdf');
    if (in_array($fileExt, $allowedExt)) {
      $sql = "INSERT INTO `requests` (`date_submitted`, `date_of_event`, `approver`, `description`, `name`, `data`) VALUES (SYSDATE(), ?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      
      // Bind the parameters
      mysqli_stmt_bind_param($stmt, 'sssss', $d, $rec, $desc, $fileName, $fileData);
      
      // Execute the statement
      $result = mysqli_stmt_execute($stmt);
      
      if ($result) {
        header("Location: process.html?");

        $qr4 = "SELECT max(request_id) FROM requests";
        $res4 = mysqli_query($conn, $qr4);
        $row4 = mysqli_fetch_array($res4);
        $idd = $row4[0];

        $qr5 = "INSERT INTO `requeststatus`(`date`, `statusCode`, `request_id`, `userId`) VALUES (SYSDATE() , '0' , '$idd' , '1')";
        $res5 = mysqli_query($conn, $qr5);

        if (isset($_FILES['mediaFile']) || isset($_POST['caption'])) {
          $cap = $_POST['caption'];
          $mediaFile = $_FILES['mediaFile'];

          $fileN = $mediaFile['name'];
          $fileTmpLocat = $mediaFile['tmp_name'];

          $fM = explode('.', $fileN);
          $fileExtension = strtolower($fM[1]);

          $allowedExtension = array('jpeg', 'jpg', 'png');
          if (in_array($fileExtension, $allowedExtension)) {
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
            } else {
              header("Location: request.php?error=An error occurred. Not Added!");
            }
          }else{
            header("Location: request.php?error=File not supported!");
          }
        }else{
          header("Location: request.php?error=All fields are required!");
        }
      }else{
        header("Location: request.php?error=An error occurred!");
      }
    } else {
      header("Location: request.php?error=File not supported!");
    }
  } else {
    header("Location: request.php?error=All fields are required!");
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
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">
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

      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
        <h2>Request Details</h2>
        <div class="container">
          <input type = "file" name="file" id = "file-input" accept=".pdf"  required/>
          <label for = "file-input">
            <i class="fa-solid fa-arrow-up-from-bracket"></i>
            &nbsp; Choose Files To Upload
          </label>
          <div id = "num-of-files">No Files Choosen</div>
            <ul id = "files-list"></ul>  
          </div>
          <table class="input-table">
            <tr>
              <td><label for="date">Select Event Date:</label></td>
              <td><input type="date" name="dateN" id="date" required></td>
            </tr>
            <tr>
              <td><label for="user">Receiver:</label></td>
              <td><select name="receiverN" id="receiver" required>
              <option value="Mofawad 3am">Mofawad 3am</option>
              <option value="Ra2is">ra2is</option>
              <option value="Ne2ib">Ne2ib</option>
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
              <input type = "file" id = "f-input" name="mediaFile" accept="image/*" multiple/>
              <label for = "f-input">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                &nbsp; Choose Files To Upload On Social Media
              </label>
              <div id = "num-files">No Files Choosen</div>
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
    <script src="download.js"></script>
    <script src="notify.js"></script>
    <script src="testing.js"></script>
    <script src="uploadFiles.js"></script>
    <script src="uploadSocialMedia.js"></script>
    <script src="hidden.js"></script>
  </body>


</html>