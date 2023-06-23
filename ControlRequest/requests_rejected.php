<?php
include("../ControlRequest/sidebarTest.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <title>History of rejected requests</title>
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

  </style>
</head>

<body>

    <div class="container">
        <div class="left">
            <h2 style="color:red;">Requests Rejected</h2>
        </div>
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
       
        include ("../common.inc.php");
        include ("../utility.php");
        $conn=connection();

$qr6 = "SELECT request_id FROM requeststatus WHERE statusCode = 2";
$res6 = mysqli_query($conn, $qr6);
$ids = array();

while ($row6 = mysqli_fetch_array($res6)) {
    $id = $row6[0];
    $ids[] = $id;
}

if (!empty($ids)) {
    $idList = implode(',', $ids);

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
                    <a href="control2.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">Change</a>
                </span>
            </div>
            <?php
        }
    } else {
        echo "No requests rejected yet!";
    }
} else {
    echo "No requests rejected yet!";
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
