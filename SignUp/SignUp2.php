  <?php
    // Assuming you are using PHP to retrieve data from the database
        // Replace 'your_database_name' with the actual name of your database
        $conn = mysqli_connect('localhost', 'root', '', 'scoutproject');
        if (!$conn) {
          die('Could not connect to the database');
        }

  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="ScoutsLogo.gif">
    <link rel="stylesheet" href="SignUp.css">
  </head>
  <body>
    <div class="container">
      <h1>Scout Info</h1>
      <form method="post" action="InsertUser.php">

        <label for="scoutrank">Scout rank (الرتبة الكشفية) with date (from newest to oldest):</label>
        <select id="scoutrank" name="scoutrank">
          <option value="generalcommander">General Commander</option>
          <option value="generalleadershipmember">General Leadership Member</option>
          <option value="generalcommisionner">General Commisionner</option>
          <option value="commissioner">Commissioner</option>
          <option value="leader">Leader</option>
          <option value="rover">Rover</option>
          <option value="ranger">Ranger</option>
          <option value="scout">Scout</option>
          <option value="girlguide">Girl Guide</option>
          <option value="cub">Cub</option>
          <option value="browny">Browny</option>
          <option value="beaver">Beaver</option>
          <option value="daisy">Daisy</option>
          <option value="Financial Custodian">Financial Custodian</option> <!-- I added this option la amin sandou2-->
        </select>

            <label for="nameofregiment">Name of regiment (اسم الفوج التابع له):</label>
      <select id="nameofregiment" name="nameofregiment">
        <?php
        // Assuming you have a 'regiment' table with 'name' column
        $query = "SELECT DISTINCT name FROM regiment";
        $result = mysqli_query($conn, $query);
        if (!$result) {
          die('Query failed');
        }
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
        }
        ?>
      </select>

            <table id="myTable">
        <thead>
          <tr>
            <th>Regiment</th>
            <th>Unit</th>
            <th>Start Date</th>
            <th>End Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <select id="regiment" name="regiment">
                <?php
                // Assuming you have a 'regiment' table with 'name' column
                $query = "SELECT DISTINCT name FROM regiment";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                  die('Query failed');
                }

                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                }
                ?>
              </select>
            </td>
            <td>
              <select id="unit" name="unit"></select>
            </td>
            <td>
              <input type="date" id="start-date" name="start-date">
            </td>
            <td>
              <input type="date" id="end-date" name="end-date">
            </td>
          </tr>
        </tbody>
      </table>
      <button id="addRowBtn">+</button>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
        $(document).ready(function() {
          $('#regiment').change(function() {
            var selectedRegiment = $(this).val();
            var unitDropdown = $(this).closest('tr').find('#unit');
            unitDropdown.empty(); // Clear previous options

            $.ajax({
              url: 'retrieve_units.php',
              method: 'POST',
              data: { regiment: selectedRegiment },
              dataType: 'json',
              success: function(response) {
                $.each(response.units, function(index, unit) {
                  unitDropdown.append($('<option>', {
                    value: unit,
                    text: unit
                  }));
                });
              },
              error: function() {
                console.log('Error occurred during units retrieval');
              }
            });
          });

          $('#addRowBtn').click(function(e) {
            e.preventDefault(); // Prevent form submission

            var newRow = $('<tr>');
            var cols = '';

            var rowCount = $('#myTable tbody tr').length; // Get the current row count
            var uniqueId = 'row-' + rowCount; // Create a unique ID for the new row

            cols += '<td><select id="regiment-' + uniqueId + '" name="regiment">';
            cols += '<option value="">Select Regiment</option>'; // Add an empty option for initial selection
            cols += '</select></td>';
            cols += '<td><select id="unit-' + uniqueId + '" name="unit"></select></td>';
            cols += '<td><input type="date" name="start-date"></td>';
            cols += '<td><input type="date" name="end-date"></td>';
            cols += '<td><button class="removeRowBtn">-</button></td>';

            newRow.append(cols);
            $('#myTable tbody').append(newRow);

            // Fetch regiments using AJAX request
            $.ajax({
              url: 'retrieve_regiments.php',
              dataType: 'html',
              success: function(response) {
                $('#regiment-' + uniqueId).html(response);
              },
              error: function() {
                $('#regiment-' + uniqueId).html('<option value="">Error retrieving regiments</option>');
              }
            });



            newRow.find('#regiment-' + uniqueId).change(function() {
              var selectedRegiment = $(this).val();
              var unitDropdown = $(this).closest('tr').find('#unit-' + uniqueId);
              unitDropdown.empty(); // Clear previous options

              $.ajax({
                url: 'retrieve_units.php',
                method: 'POST',
                data: { regiment: selectedRegiment },
                dataType: 'json',
                success: function(response) {
                  $.each(response.units, function(index, unit) {
                    unitDropdown.append($('<option>', {
                      value: unit,
                      text: unit
                    }));
                  });
                },
                error: function() {
                  console.log('Error occurred during units retrieval');
                }
              });
            });
          });

          $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();

            // Trigger a change event on the remaining regiment select elements to update the units
            $('#regiment').change();
          });
        });
      </script>



        <label for="scoutclass">Scout class (الدرجة الكشفية) with date (from newest to oldest):</label>
        <textarea id="scoutclass" name="scoutclass" rows="10"></textarea>
    
        <label for="affiliationdate">Affiliation Date: (تاريخ الانتساب)</label>
        <input type="date" id="affiliationdate" name="affiliationdate" required>

        <label for="promisedate">Oath Date (تاريخ الوعد):</label>
        <input type="date" id="promisedate" name="oathdate">

        <label for="scouttitle">Scout Title (اللقب الكشفي):</label>
        <input type="text" id="scouttitle" name="scouttitle">

        <label for="dateofthetitle">Date of the title:</label>
        <input type="date" id="dateofthetitle" name="dateofthetitle">

        <label for="placeofthetitle">Place of the title:</label>
        <input type="text" id="placeofthetitle" name="placeofthetitle">
        
        <label for="trainingcourses">Training courses he participated in (what is the course / time (from date to date) / place):</label>    <!-- hle hyde barke mnaamol mtl section lahala bye2dar l moufawad aw hada martabe aalye enno yzid l courses bl database w se3eta byerjaa b na2e l chakhes shu l courses w hasab aya date kmn -->
        <textarea id="trainingcourses" name="trainingcourses" rows="10"></textarea>
        
        <input type="submit" name='SignUp2' value="Sign Up">  
      </form>
    
    </div>
  </body>
  </html>


