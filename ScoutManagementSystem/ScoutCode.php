<?php
include 'Generate.php';
include 'SearchScout.php';
include 'CreateUnit.php';

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'scoutproject');
if (!$con) {
    die('Failed to connect to the database: ' . mysqli_connect_error());
}

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
  <style>
    /* Add custom styles here */
  </style>
</head>
<body>
  <h1>Scout Management System</h1>

  <!-- Section: Generate Unique Code and Password -->
  <section>
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
          <td><input type="email" id="email" name="email" required></td>
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
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
            // Handle the Generate button click event
            // Generate code and password, send email, and display the result
            // Make sure to define $mail, $code, and $password variables  
            // Check if the email was sent successfully
            if (isset($mail) && $mail->send() && isset($code) && isset($password)) {
                $result = 'Email sent successfully!';
                echo '<tr>
                      <td>'.$code.'</td>
                      <td>'.$password.'</td>
                      <td>'.$result.'</td>
                      </tr>';

                      $email = $_POST['email'];
                      $query = "SELECT user_id FROM user WHERE email = '$email'";
                      $res = mysqli_query($con, $query);
                      
                      if ($res) {
                          $res1 = mysqli_fetch_assoc($res);
                          if ($res1) {
                              $user_id = $res1['user_id'];
                              // Process the user ID as needed
                          } 
                          // mysqli_free_result($res);
                      } else {
                          // Query execution failed
                          echo "Error: " . mysqli_error($con);
                      }
                       // Prepare and execute the INSERT statement
                       $stmt = mysqli_prepare($con, "INSERT INTO usercredentials (scoutcode, password, userId) VALUES (?, ?, ?)");
                       mysqli_stmt_bind_param($stmt, 'sss', $code, $password, $user_id);
                       $result = mysqli_stmt_execute($stmt);
                       
                       if ($result) {
                           echo "Record was inserted successfully into your database.";
                       } else {
                           echo "Error: " . mysqli_error($con);
                       }
                       
                       mysqli_stmt_close($stmt);
                       mysqli_close($con);
                       

            } else {
                $result = 'Failed to send the email!';
                echo '<tr>
                      <td></td>
                      <td></td>
                      <td>'.$result.'</td>
                      </tr>';
            }
        }
        ?>

      </tbody>
    </table>
  </section>

  <!-- Section: Search Scout Members -->
  <section>
    <h2>Search Scout Members</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <table class="input-table">
        <tr>
          <td><label for="user">First Name:</label></td>
          <td><input type="text" id="user" name="fname"></td>
        </tr>
        <tr>
          <td><label for="user">Last Name:</label></td>
          <td><input type="text" id="last-name" name="lname"></td>
        </tr>
        <tr>
          <td><label for="rank">Rank:</label></td>
          <td><input type="text" id="rank" name="rank"></td>
        </tr>
        <tr>
          <td><label for="regiment">Regiment:</label></td>
          <td><input type="text" name="regiment" id="regiment"></td>
        </tr>
        <tr>
          <td><label for="unit">Unit:</label></td>
          <td><input type="text" id="unit" name="unit"></td>
        </tr>
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
                echo '</tr>';
            }
        }
        ?>
      </tbody>
    </table>
  </section>

  <!-- Section: Create Scout Units -->
  <section>
    <h2>Create Scout Units</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <table class="input-table">
        <tr>
          <td><label for="unit-name">Unit Name:</label></td>
          <td><input type="text" id="unit-name" name="unit-name" required></td>
        </tr>
        <tr>
  <td>
    <label for="unit-regiment">Regiment:</label></td>
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
    <select name="unit-leader" id="unit-leader" >
      <option value="charbel">Charbel</option>
      <?php
      if (isset($_POST['unit-regiment'])) {
        $selectedRegiment = $_POST['unit-regiment'];

        // Assuming you have already established a database connection using mysqli_connect

        $query = "SELECT fname,lname FROM user,regiment WHERE  = 'user.user_id=regiment.userId && regiment.name='".$selectedRegiment."'";
        $result = mysqli_query($con, $query);

        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
            $leader = $row['fname'].$row['lname'];
            echo "<option value='$leader'>$leader</option>";
          }
          mysqli_free_result($result);
        } else {
          echo "Error: " . mysqli_error($con);
        }

        mysqli_close($con);
      }
      ?>
    </select>
  </td>
</tr>

        <tr>
          <td><label for="unit-members">Number of Members:</label></td>
          <td><input type="number" id="unit-members" name="unit-members" required></td>
        </tr>
      </table>
      <button type="submit" name="create">Create Unit</button>
    </form>
  </section>
</body>
</html>
