
<?php

session_start();

include ("../common.inc.php");
include ("../utility.php");
$conn=connection();

$query = "SELECT * FROM requestsetting";
$res = mysqli_query($conn,$query);
$row = mysqli_fetch_array($res);
$value = $row[0];

echo "The current days difference is set to $value.";

?>
<!DOCTYPE html>
    <head>
        <link rel = "stylesheet" href = "ScoutCode.css"/>
        <script>
    
  function conf() {
    var result = confirm("Are you sure you want to proceed?");
    if (result) {
      window.location.href = "../ScoutManagementSystem/conf.php";
    } else {
      alert("Action cancelled!");
    }
  }
</script>
    </head>

    <body>
        <form action="conf.php" method="POST">
            <table class="input-table">
                <tr>
                    <div id="message"></div>
                    <td><label for="days">Change Days Difference:</label></td>
                    <td><input type="number" name="quantity" required></td>
                </tr>
            </table>
            <button type="submit" id="dayBtn" name="dayBtnN" onclick="conf()">Change</button>
        </form>
        
    </body>

