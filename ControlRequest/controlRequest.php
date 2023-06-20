<!DOCTYPE html>
<head>
<link rel = "stylesheet" href = "test.css"/>
</head>

<body>



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
      session_start();
      include ("../common.inc.php");
      include ("../utility.php");
      $conn=connection();

      $qr6 = "SELECT request_id FROM requeststatus WHERE statusCode = 0";
      $res6 = mysqli_query($conn , $qr6);
      $ids = array();
      while($row6 = mysqli_fetch_array($res6)){
        $id = $row6[0];
        $ids[] = $id;
      }

      $idList = implode(',', $ids); 

      $qr7 = "SELECT request_id , name , approver FROM requests WHERE request_id IN ($idList)";
      $res7 = mysqli_query($conn, $qr7);

      while ($row7 = mysqli_fetch_assoc($res7)) {
        $name = $row7['request_id'];
        $lastUpdated = $row7['approver'];
        $link = $row7['name'];
      ?>
        <div class="policy">
          <span><?php echo $name; ?></span>
          <span><?php echo $lastUpdated; ?></span>
          <span><?php echo $link; ?></span>
          <span>
          <!--<a href="control.php?request_id=<?php //echo $name; ?>">view</a>-->
          <a href="control.php?request_id=<?php echo $name; ?>" onclick="setRequestId('<?php echo $name; ?>')">View</a>
          </span>
        </div>
      <?php
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
