<?php
        include ("../common.inc.php");
        include ("../utility.php");
        $conn=connection();
include("../ControlRequest/sidebarTest.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <title>History of approved requests</title>
  <style>
    .container {
      display: flex;
      justify-content: space-between;
    }
    .left {
      width: 70%;
      padding: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
      text-decoration: underline;
    }
    .right {
      width: 20%;
      padding: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .right code {
      display: block;
    }
    .hidden{
        display: none;
    }
    select {
      width: 160px;
      height: 40px;
      padding: 8px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #fff;
      border-color: green;
      border-width: 2px;
      color: #333;
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
    }
    select:focus {
      outline: none;
      border-color: green;
    }




    body {
    background-color: rgb(235, 232, 227);
    font-family: sans-serif;
    font-size: 16px;
}

.policy-table {
    color: black;
    text-align: center;
}

.headings, .policy {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    margin-bottom: 1em;
    padding: 1em;
    margin-top: 30px;
}

.heading {
    flex-basis: 33.333%;
    font-weight: bold;
}

.policy {
    border-radius: 2em;
    background-color: white;
    margin-bottom: 20px;
    -moz-box-shadow: 0 0 3px grey;
    -webkit-box-shadow: 0 0 3px grey;
    box-shadow: 0 0 5px grey;
}

span {
    flex-basis: 33.333%;
}

a {
    text-decoration: none;
    color: #4c4c4c;
}

.error{
    background: rgb(128, 214, 128);
    color: white;
    padding: 10px;
    width: 95%;
    border-radius: 5px;
    margin: 20px auto;
    justify-content: center;
}

input[type='date']{

      width: 160px;
      height: 40px;
      padding: 8px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #fff;
      border-color: green;
      border-width: 2px;
      color: #333;
}

.filter{
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 30px;
}
.green-button{
    background-color: green;
    font-size: 1.2em;
    font-family: sans-serif ;
    color: white;
    padding: 5px 10px;
    border: none;
}
.green-button:hover{
    background: rgb(143, 219, 143);
}
  </style>
</head>

<body>

    <div class="container">
        <div class="left">
            <h2 style="color: lightgreen;">Requests Approved</h2>
        </div>
    </div>

    <div class="filter">
      <form action="" method="POST">
        <label><b>From:</b></label>
        <input type="date" name="dateFrom">

        <label><b>To:</b></label>
        <input type="date" name="dateTo">

        <label><b>Type of file:</b></label>
        <?php $sql = "SELECT Form_description FROM forms";
        $result = mysqli_query($conn, $sql);

        // Check if any results are returned
        if (mysqli_num_rows($result) > 0) {
          // Start generating the select dropdown
          echo '<select name="Form_description">';
          echo '<option value="All files">All files</option>';

          // Loop through the results and generate option tags
          while ($row = mysqli_fetch_assoc($result)) {
            $fileName = $row['Form_description'];
            echo '<option value="' . $fileName . '">' . $fileName . '</option>';
          }

          echo '</select>';
        } else {
          echo "No files found in the database.";
        }?>
        <input type="submit" class="green-button" id="submitBtn" name="btn" value="Apply">
      </form>
    </div>




    <div class="policy-container">

        <div class="policy-table">
        <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; unset($_GET['error'])?></p>
        <?php } ?>

            <div class="headings">
                <span class="heading">Request ID</span>
                <span class="heading">Sender</span>
                <span class="heading">File</span>
                <span class="heading">Actions</span>
            </div>

        <?php
        // Add your database connection and query here
       

        

$qr6 = "SELECT request_id FROM requeststatus WHERE statusCode = 1";
$res6 = mysqli_query($conn, $qr6);
$ids = array();

while ($row6 = mysqli_fetch_array($res6)) {
    $id = $row6[0];
    $ids[] = $id;
}

if (!empty($ids)) {
  $idList = implode(',', $ids);

  if (isset($_POST['btn'])) {
      
      if (!empty($_POST['dateFrom']) && empty($_POST['dateTo']) && !empty($_POST['Form_description'])) {
        // dateFrom and Form_description are set, retrieve files from dateFrom till SYSDATE() of the specified Form_description
        $from = $_POST['dateFrom'];
        $des = $_POST['Form_description'];
        $desWithExtension = $des . ".pdf";
        if($des == 'All files'){
          $sql = "SELECT request_id, name, submitter FROM requests WHERE date_submitted >= '$from' AND date_submitted <= CURDATE() AND request_id IN ($idList)";
          $res = mysqli_query($conn, $sql);
          // Execute the query and handle the results
          if ($res && mysqli_num_rows($res) > 0) {
              while ($row7 = mysqli_fetch_assoc($res)) {
                  $name = $row7['request_id'];
                  $lastUpdated = $row7['submitter'];
                  $link = $row7['name'];
                  
                  // Output the data for each record
                  ?>
                  <div class="policy">
                      <span><?php echo $name; ?></span>
                      <span><?php echo $lastUpdated; ?></span>
                      <span><?php echo $link; ?></span>
                      <span>
                          <a href="control1GenCom.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">Change</a>
                      </span>
                  </div>
                  <?php
                }
            }else{ echo "No requests approved yet!";}
        }else{
        
          $sql = "SELECT request_id, name, submitter FROM requests WHERE date_submitted >= '$from' AND date_submitted <= CURDATE() AND name = '$desWithExtension' AND request_id IN ($idList)";
          $res = mysqli_query($conn, $sql);
          // Execute the query and handle the results
          if ($res && mysqli_num_rows($res) > 0) {
            while ($row7 = mysqli_fetch_assoc($res)) {
                $name = $row7['request_id'];
                $lastUpdated = $row7['submitter'];
                $link = $row7['name'];
                
                // Output the data for each record
                ?>
                <div class="policy">
                    <span><?php echo $name; ?></span>
                    <span><?php echo $lastUpdated; ?></span>
                    <span><?php echo $link; ?></span>
                    <span>
                        <a href="control1GenCom.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">Change</a>
                    </span>
                </div>
                <?php
              }
          } else {
            echo "No requests approved yet!";
          }
        }

      } elseif (empty($_POST['dateFrom']) && empty($_POST['dateTo']) && !empty($_POST['Form_description'])) {
        // dateFrom and Form_description are set, retrieve files from dateFrom till SYSDATE() of the specified Form_description
        $des = $_POST['Form_description'];
        $desWithExtension = $des . ".pdf";
        if($des == 'All files'){
          $qr7 = "SELECT request_id, name, submitter FROM requests WHERE request_id IN ($idList)";
          $res7 = mysqli_query($conn, $qr7);
          if ($res7 && mysqli_num_rows($res7) > 0) {
            while ($row7 = mysqli_fetch_assoc($res7)) {
                $name = $row7['request_id'];
                $lastUpdated = $row7['submitter'];
                $link = $row7['name'];
                
                // Output the data for each record
                ?>
                <div class="policy">
                    <span><?php echo $name; ?></span>
                    <span><?php echo $lastUpdated; ?></span>
                    <span><?php echo $link; ?></span>
                    <span>
                        <a href="control1GenCom.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">Change</a>
                    </span>
                </div>
                <?php
              }
          } else {
            echo "No requests approved yet!";
          }
        } else {
          $sql = "SELECT request_id, name, submitter FROM requests WHERE name = '$desWithExtension' AND request_id IN ($idList)";
          $res = mysqli_query($conn, $sql);
          // Execute the query and handle the results
          if ($res && mysqli_num_rows($res) > 0) {
            while ($row7 = mysqli_fetch_assoc($res)) {
                $name = $row7['request_id'];
                $lastUpdated = $row7['submitter'];
                $link = $row7['name'];
                
                // Output the data for each record
                ?>
                <div class="policy">
                    <span><?php echo $name; ?></span>
                    <span><?php echo $lastUpdated; ?></span>
                    <span><?php echo $link; ?></span>
                    <span>
                        <a href="control1GenCom.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">Change</a>
                    </span>
                </div>
                <?php
              }
          } else {
            echo "No requests approved yet!";
          }
        }

      
      } elseif (!empty($_POST['dateFrom']) && !empty($_POST['dateTo']) && !empty($_POST['Form_description'])) {
        // dateFrom, dateTo, and Form_description are all set, retrieve files between the specified dates of the specified Form_description
        $from = $_POST['dateFrom'];
        $to = $_POST['dateTo'];
        $des = $_POST['Form_description'];
        $desWithExtension = $des . ".pdf";
        if($des == 'All files'){
          $sql = "SELECT request_id, name, submitter FROM requests WHERE date_submitted >= '$from' AND date_submitted <= '$to' AND request_id IN ($idList)";
          $res = mysqli_query($conn, $sql);
          // Execute the query and handle the results
            if ($res && mysqli_num_rows($res) > 0) {
              while ($row7 = mysqli_fetch_assoc($res)) {
                $name = $row7['request_id'];
                $lastUpdated = $row7['submitter'];
                $link = $row7['name'];
                // Output the data for each record
                ?>
                <div class="policy">
                    <span><?php echo $name; ?></span>
                    <span><?php echo $lastUpdated; ?></span>
                    <span><?php echo $link; ?></span>
                    <span>
                        <a href="control1GenCom.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">Change</a>
                    </span>
                </div>
                <?php
              }
            } else {
            echo "No requests approved yet!";
            }

        }else{
        
          $sql = "SELECT request_id, name, submitter FROM requests WHERE date_submitted >= '$from' AND date_submitted <= '$to' AND name = '$desWithExtension' AND request_id IN ($idList)";
          $res = mysqli_query($conn, $sql);
          // Execute the query and handle the results
          if ($res && mysqli_num_rows($res) > 0) {
            while ($row7 = mysqli_fetch_assoc($res)) {
                $name = $row7['request_id'];
                $lastUpdated = $row7['submitter'];
                $link = $row7['name'];
                // Output the data for each record
                ?>
                <div class="policy">
                    <span><?php echo $name; ?></span>
                    <span><?php echo $lastUpdated; ?></span>
                    <span><?php echo $link; ?></span>
                    <span>
                        <a href="control1GenCom.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">Change</a>
                    </span>
                </div>
                <?php
              }
          } else {
            echo "No requests approved yet!";
          }
        }
      }
  }else{

        $qr7 = "SELECT request_id, name, submitter FROM requests WHERE request_id IN ($idList)";
        $res7 = mysqli_query($conn, $qr7);

        if ($res7 && mysqli_num_rows($res7) > 0) {
          while ($row7 = mysqli_fetch_assoc($res7)) {
            $name = $row7['request_id'];
            $lastUpdated = $row7['submitter'];
            $link = $row7['name'];
            
            // Output the data for each record
            ?>
            <div class="policy">
                <span><?php echo $name; ?></span>
                <span><?php echo $lastUpdated; ?></span>
                <span><?php echo $link; ?></span>
                <span>
                    <a href="control1GenCom.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">Change</a>
                </span>
            </div>
            <?php
          }
      } else {
        echo "No requests approved yet!";
      }
      
  }
  
}


?>

    


    </div>
  </div>

  <script>
  function setRequestId(requestId) {
    document.cookie = "request_id=" + requestId;
  }
</script>
  
</body>
</html>
