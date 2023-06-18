
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
<link rel = "stylesheet" href = "design.css"/>
</head>

<tbody>


    <div>
      <table class="input-table">
        <tr><td><label>Request ID:</label></td>
          <td> <?php echo $row['request_id']  ?> </td>
        </tr>
        <tr><td><label>Sender:</label></td>
          <td> <?php echo $row['sender']  ?> </td>
        </tr>
        <tr><td><label>Description:</label></td>
          <td> <?php echo $row['description']  ?> </td>
        </tr>
        <tr><td><label></label></td>
          <td><input type="submit" id="submitBtn" name="submit" value="Submit"></td>
        </tr>
        <tr>
          <td><label>Comment:</label></td>
          <td><textarea  style="resize: none;" id="caption" name="caption" rows="7" cols="115"></textarea></td>
        </tr>
      </table>
    </div>

    <a class="btn btn-success pull-right" type="submit" id="submitBtn" name="submit">Submit</a>
    <a class="btn btn-success pull-right" type="submit" id="submitBtn" name="submit">Submit</a>
    <a class="btn btn-success pull-right" type="submit" id="submitBtn" name="submit">Submit</a>