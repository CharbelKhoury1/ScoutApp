

<?php
session_start();
include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

if (isset($_COOKIE['request_id'])) {
  $selectedRequestId = $_COOKIE['request_id'];

  // Retrieve data related to the selected request_id
  $query = "SELECT * FROM requests WHERE request_id = $selectedRequestId";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the data
    $row = mysqli_fetch_assoc($result);

    // Access the individual fields
    $requestId = $row['request_id'];
    //$sender = $row['sender'];
    $desc = $row['description'];



  } else {
    echo "No data found for the selected request.";
  }
} else {
  echo "No request_id selected.";
}

// Close the database connection
mysqli_close($conn);
?>




<!DOCTYPE html>
<head>
<link rel = "stylesheet" href = "test1.css"/>
<script>
  function viewFile(){
    window.location.href = "../ControlRequest/viewFile.php";
  }
</script>
<script>
    
  function cancelAction() {
    var result = confirm("Are you sure you want to proceed?");
    if (result) {
      window.location.href = "../ControlRequest/requests_approved.php";
    } else {s
      alert("Action cancelled!");
    }
  }
</script>

  </script>

<script>
    function confirmReject() {
      var resultRej = confirm("Are you sure you want to proceed?");
      if (resultRej) {
        window.location.href = "../ControlRequest/update1.php";
      } else {
        alert("Action cancelled!");
      }
    }
  </script>
</head>

<tbody>


    <div>
      <table class="input-table">
        <tr><td><label>Request ID:</label></td>
          <td> <?php echo $row['request_id']  ?> </td>
        </tr>
        <tr><td><label>Sender:</label></td>
          <td> <?php echo $row['submitter']  ?> </td>
        </tr>
        <tr><td><label>Description:</label></td>
          <td> <?php echo $row['description']  ?> </td>
        </tr>
      </table>
    </div>

    <div class="container2">
        <div class="center">
          <button class="big-button" onclick="viewFile()">View File</button>
        </div>
    </div>




    <div> 
      <table class="input-table">
        <tr>
          <td><label>Leave a comment:</label></td>
          <td><textarea  style="resize: none;" id="caption" name="caption" rows="7" cols="115"></textarea></td>
        </tr>
      </table>
    </div>

    <div class="container3">
      <div class="center1">
        <button class="green-button" onclick="cancelAction()">Cancel</button>
        <button class="red-button" onclick="confirmReject()">Reject</button>
      </div>
    </div>