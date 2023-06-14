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
      <button class="" ="window.location.href='Requests.html'">
        <img src="../Icons/git-pull-request-svgrepo-com.svg">Requests
      </button>
      <button class="" onclick="window.location.href='../views/transactionView.php'">
      <img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance
      </button>
      <button id="codeButton" class="active" onclick="setActiveButton('codeButton'); showSection('code-section')">
        <img src="../Icons//icons8-password.svg">Code/Pass Generator
      </button>
      <button id="searchButton" class="" onclick="setActiveButton('searchButton'); showSection('search-section')">
        <img src="../Icons/search-refraction-svgrepo-com.svg">Search Scout
      </button>
      <button id="createButton" class="" onclick="setActiveButton('createButton'); showSection('create-section')">
        <img src="../Icons/add-svgrepo-com.svg">Create Unit
      </button>

      
      <button class="" onclick="scrollToSection('Scout-gallery')">
      <img src="../Icons/world-1-svgrepo-com.svg">Social Media
      </button>
      <button class="" onclick="scrollToSection('testimonials')">
      <img src="../Icons/system-help-svgrepo-com.svg">About Us
      </button>
      <button  class="" onclick="window.location.href='../views/contactUsView.php'">
      <img src="../Icons/phone-svgrepo-com.svg">Contact Us
      </button>
       </div>
      </div>

  <h1>Scout Management System</h1>

  <!-- Section: Generate Unique Code and Password -->
  <section id="code-section" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
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
  <section id="search-section" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
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
        <tr>
          <td><label for="scoutclass">ScoutClass:</label></td>
          <td><input type="text" id="scoutclass" name="scoutclass"></td>
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
          <th>Scout Class</th>
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
                echo '<td>' . $row['degree_name'] . '</td>';
                echo '</tr>';
            }
        }
        ?>
      </tbody>
    </table>
  </section>


  <!-- Section: Create Scout Units -->
  <section id="create-section" <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) { echo 'style="display: block;"'; } else { echo 'style="display: none;"'; } ?>>
    <h2>Create Scout Units</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <table class="input-table">
        <tr>
          <td><label for="unit-name">Unit Name:</label></td>
          <td><input type="text" id="unit-name" name="unit-name" required></td>
        </tr>
        <tr>
          <td><label for="unit-regiment">Regiment:</label></td>
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
            <select name="unit-leader" id="unit-leader">
              <option value="charbel">Charbel</option>
            </select>
          </td>
        </tr>
      </table>
      <button type="submit" name="create">Create Unit</button>
    </form>
  </section>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#unit-regiment').on('change', function() {
        var selectedRegiment = $(this).val();
        var unitDropdown = $('#unit-leader');

        $.ajax({
          url: 'retrieve_leaders.php', // Replace with the actual PHP file retrieving leaders
          method: 'POST',
          data: { regiment: selectedRegiment },
          dataType: 'json',
          success: function(response) {
            unitDropdown.empty();
            $.each(response.leaders, function(index, leader) {
              unitDropdown.append($('<option>', {
                value: leader,
                text: leader
              }));
            });
          },
          error: function() {
            console.log('Error occurred during leaders retrieval');
          }
        });
      });
    });
  </script>

<script>
  // sidebar js
document.querySelector(".sidebar .logo").addEventListener("click",
function(){
  document.querySelector(".sidebar").classList.toggle("active");
})
</script>

<!-- awal script houwe kermel eza jina mn l home aw hayalla page tenye , ta yzabet l display hasab l button l kabasne -->
<script>
  // Get the fragment identifier from the URL
  const sectionId = window.location.hash.substr(1);

  // Show the corresponding section based on the fragment identifier
  if (sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
      section.style.display = "block";
      const sectionWord = sectionId.split("-")[0]; // Extract the "word" content
      setActiveButton(sectionWord + 'Button'); // Make the corresponding button active
    }
  }
</script>


<!-- tene script houwe kermel eza kenna b shi whde mn hawde l 3 , w bdna nrouh aa whde mennon , ta dghre taamol display lal part l me3niye -->
<script>
  // Function to show the specified section and hide the others
  function showSection(sectionId) {
    // Get all the sections
    const sections = document.getElementsByTagName('section');

    // Iterate through the sections
    for (let i = 0; i < sections.length; i++) {
      const section = sections[i];

      // Check if the section is the target section
      if (section.id === sectionId) {
        section.style.display = "block"; // Show the target section
      } else {
        section.style.display = "none"; // Hide the other sections
      }
    }

    // Update the URL with the section ID without adding a new history entry
 history.replaceState(null, null, `#${sectionId}`);

  // Set the active button and show the corresponding section on page load
  document.addEventListener("DOMContentLoaded", () => {
    if (sectionId) {
      const section = document.getElementById(sectionId);
      if (section) {
        section.style.display = "block";
        const button = document.getElementById(sectionId + "Button");
        if (button) {
          button.classList.add("active");
        }
      }
    }
  });

  }
</script>

<script>
   // Get all the buttons
const buttons = document.querySelectorAll('.links button');

// Add event listener to each button
buttons.forEach(button => {
  button.addEventListener('click', () => {
    // Check if the clicked button is already active
    if (!button.classList.contains('active')) {
      // Remove the active class from all buttons
      buttons.forEach(btn => btn.classList.remove('active'));

      // Add the active class to the clicked button
      button.classList.add('active');
    }
  });
});

</script>

<script>
  // Function to handle the active state of buttons
  function setActiveButton(buttonId) {
    // Get all the buttons
    const buttons = document.querySelectorAll('.links button');

    // Remove the "active" class from all buttons
    buttons.forEach((button) => {
      button.classList.remove('active');
    });

    // Add the "active" class to the clicked button
    document.getElementById(buttonId).classList.add('active');
  }
</script>

</body>
</html>
