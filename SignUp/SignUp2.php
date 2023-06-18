  <?php
    // Assuming you are using PHP to retrieve data from the database
        // Replace 'your_database_name' with the actual name of your database
        include ("../common.inc.php");
        include ("../utility.php");
        $con=connection();

  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="icon" type="image/x-icon" href="../Pictures/ScoutsLogo.gif">
    <link rel="stylesheet" href="SignUp.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" 
  rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <h1>Scout Info</h1>
      <form method="post" action="InsertUser.php">

        <label for="scoutrank">Scout rank (الرتبة الكشفية):</label>
        <select id="scoutrank" name="scoutrankpresent">
          <option value="General Commander">General Commander</option>
          <option value="General Leadership Member">General Leadership Member</option>
          <option value="General Commisionner">General Commisionner</option>
          <option value="Commissioner">Commissioner</option>
          <option value="Leader">Leader</option>
          <option value="Rover">Rover</option>
          <option value="Ranger">Ranger</option>
          <option value="Scout">Scout</option>
          <option value="Girl Guide">Girl Guide</option>
          <option value="Cub">Cub</option>
          <option value="Browny">Browny</option>
          <option value="Beaver">Beaver</option>
          <option value="Daisy">Daisy</option>
          <option value="Financial Custodian">Financial Custodian</option>
          <option value="Secretary">Secretary</option>
        </select>

            <label for="nameofregiment">Name of regiment (اسم الفوج التابع له):</label>
      <select id="nameofregiment" name="nameofregiment-present">
        <option disabled selected value="">Select Regiment</option>
        <?php
        // Assuming you have a 'regiment' table with 'name' column
        $query = "SELECT DISTINCT name FROM regiment";
        $result = mysqli_query($con, $query);
        if (!$result) {
          die('Query failed');
        }
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
        }
        ?>
      </select>

      <label for="unit">Name of Unit (اسم الفرقة التابع لها ):</label>
      <select id="unit" name="unit-present"></select>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
              $(document).ready(function() {
        $('#nameofregiment').change(function() {
          var selectedRegiment = $(this).val();
          var unitDropdown = $('#unit');
          
          // Clear previous options
          unitDropdown.empty();

          $.ajax({
            url: 'retrieve_units.php', // Replace with the actual PHP file retrieving units
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

      </script>

      
      <label for="unit">When did you hold this status:</label>
      <input type="date" name="startdate-present" id="startdate-present">

      <table id="myTable">
  <caption>Fill the fields from newest to oldest<br>(PS: Don't include your present status)</caption>
  <thead>
    <tr>
      <th>Regiment</th>
      <th>Unit</th>
      <th>Rank</th>
      <th>Start Date</th>
      <th>End Date</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <select id="regiment-0" name="regiment[0]">
          <option disabled selected value="">Select Regiment</option>
          <?php
          // Assuming you have a 'regiment' table with 'name' column
          $query = "SELECT DISTINCT name FROM regiment";
          $result = mysqli_query($con, $query);
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
        <select id="unit-0" name="unit[0]"></select>
      </td>
      <td>
        <select id="rank-0" name="rank[0]">
          <?php
          // Assuming you have a 'rank' table with 'name' column
          $query = "SELECT name FROM rank";
          $result = mysqli_query($con, $query);
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
        <input type="date" name="start-date[0]">
      </td>
      <td>
        <input type="date" name="end-date[0]">
      </td>
    </tr>
  </tbody>
</table>
<button id="addRowBtn">+</button>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Fetch units for the first row based on the selected regiment
  
      $('#regiment-0').change(function() {
    var selectedRegiment = $(this).val();
    var unitDropdown = $(this).closest('tr').find('#unit-0');
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

      var rowCount = $('#myTable tbody tr').length; // Get the current row count
      var uniqueId = 'row-' + rowCount; // Create a unique ID for the new row

      var newRow = $('<tr>');
      var cols = '';

      cols += '<td><select id="regiment-' + uniqueId + '" name="regiment[' + rowCount + ']">';
      cols += '<option disabled selected value="">Select Regiment</option>'; // Add an empty option for initial selection
      cols += '</select></td>';
      cols += '<td><select id="unit-' + uniqueId + '" name="unit[' + rowCount + ']"></select></td>';
      cols += '<td><select id="rank-' + uniqueId + '" name="rank[' + rowCount + ']"></select></td>';
      cols += '<td><input type="date" name="start-date[' + rowCount + ']"></td>';
      cols += '<td><input type="date" name="end-date[' + rowCount + ']"></td>';
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

      // Fetch ranks using AJAX request
      $.ajax({
        url: 'retrieve_ranks.php',
        dataType: 'html',
        success: function(response) {
          $('#rank-' + uniqueId).html(response);
        },
        error: function() {
          $('#rank-' + uniqueId).html('<option value="">Error retrieving ranks</option>');
        }
      });
    });

    $(document).on('click', '.removeRowBtn', function() {
      $(this).closest('tr').remove();

      // Trigger a change event on the remaining regiment select elements to update the units
      $('[id^="regiment-"]').change();
    });
  });
</script>


  <table id="myTable1">
    <caption>Scout class (الدرجة الكشفية) with date (from newest to oldest):</caption>
    <thead>
      <tr>
        <th>Scout Class</th>
        <th>Start Date</th>
        <th>End Date</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      <tr id="row-0">
        <td>
          <select name="scoutclass[0]">
            <option disabled selected value="">اختر الدرجة الكشفية</option>
            <?php
          mysqli_set_charset($con, "utf8"); // Set character encoding

          // Assuming you have a 'degree' table with 'name' column
          $query1 = "SELECT DISTINCT name FROM degree";
          $result = mysqli_query($con, $query1);
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
          <input type="date" name="start-Date[0]">
        </td>
        <td>
          <input type="date" name="end-Date[0]">
        </td>
        <td>
          <button class="removeRowBtn1" disabled>-</button>
        </td>
      </tr>
    </tbody>
  </table>
  <button id="addRowBtn1">+</button>

  <script>
    $(document).ready(function() {
      var rowCount = 1; // Initialize row count

      $('#addRowBtn1').click(function(e) {
        e.preventDefault(); // Prevent form submission

        var newRow = $('#row-0').clone(); // Clone the first row
        newRow.attr('id', 'row-' + rowCount); // Update the ID of the new row
        newRow.find('[name^="scoutclass"]').attr('name', 'scoutclass[' + rowCount + ']'); // Update the name attribute of the select element
        newRow.find('[name^="start-Date"]').attr('name', 'start-Date[' + rowCount + ']'); // Update the name attribute of the start date input
        newRow.find('[name^="end-Date"]').attr('name', 'end-Date[' + rowCount + ']'); // Update the name attribute of the end date input

        newRow.find('.removeRowBtn1').click(function() {
          $(this).closest('tr').remove();
        });

        newRow.find('.removeRowBtn1').prop('disabled', false); // Enable the remove button for the new row
        $('#tableBody').append(newRow);

        rowCount++; // Increment row count

        // Enable the remove button for the previously added row
        $('#row-' + (rowCount - 2)).find('.removeRowBtn1').prop('disabled', false);
      });
    });
  </script>
    



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


