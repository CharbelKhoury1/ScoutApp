<?php
include("../sideBar/sideBar.php");
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
} else {
  header("Location: ../Home/Home.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <title>Transaction Details</title>
  <link rel="stylesheet" href="../views/css/balanceTrial.css">
  <style>
    .alert-box {
      background-color: lightgreen;
      padding: 10px;
      margin: 0 auto;
      margin-top: 10vh;
      transform: translateY(-50%);
      max-width: 400px;
      border-radius: 5px;
  }

  </style>  
</head>
<body>
  <div class="container">
    <h1>Transaction Details</h1>
    <form id="balance-form">
      <label for="type-code">Select Type:<br> (اختر النوع)</label>
      <select id="type-code" name="type-code">
        <option value="0">Income (مداخيل)</option>
        <option value="1">Expense (مصاريف)</option>
      </select>
      <br>
      <label for="currency-code">Select Currency: (اختر العملة)</label>
      <select id="currency-code" name="currency-code">
        <option value="0">LBP (ل.ل.)</option>
        <option value="1">USD ($)</option>
      </select>
      <button type="submit">Submit</button>
    </form>
    <div id="transaction-table"></div>
    <p id="response-message"></p>

    <script>
      let currentData = { transactionRecords: [] }; // Store the current data globally

      // Function to handle form submission
      function handleFormSubmit(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        const currencyCode = formData.get('currency-code');
        const typeCode = formData.get('type-code');

        // Make AJAX request to the controller endpoint
        fetch('../controllers/balanceTrialController.php', {
          method: 'POST',
          body: new URLSearchParams({
            currency_code: currencyCode,
            type_code: typeCode
          })
        })
          .then(response => response.json())
          .then(data => {
            // Update the current data with the new response
            currentData = data;

            // Display the transaction records in the table
            displayTransactionRecords();
          })
          .catch(error => {
            console.error('Error:', error);
          });
      }

      // Function to display transaction records in the table
      function displayTransactionRecords() {
        const tableContainer = document.getElementById('transaction-table');
        tableContainer.innerHTML = '';

        if (!currentData || currentData.transactionRecords.length === 0) {
          tableContainer.innerHTML = '<p>No records found.</p>';
          return;
        }

        const currencyCode = document.getElementById('currency-code').value;
        const typeCode = document.getElementById('type-code').value;

        // Display the currency and type above the table
        const currencyText = currencyCode === '0' ? 'LBP (ل.ل.)' : 'USD ($)';
        const typeText = typeCode === '0' ? 'Income (مداخيل)' : 'Expense (مصاريف)';
        const currencyTypeText = `${typeText} - ${currencyText}`;
        const currencyTypeElement = document.createElement('p');
        currencyTypeElement.textContent = currencyTypeText;
        currencyTypeElement.style.fontWeight = 'bold';
        currencyTypeElement.style.textAlign = 'center';

        const table = document.createElement('table');
        const tableHeader = document.createElement('thead');
        const tableBody = document.createElement('tbody');

        // Create table header row
        const headerRow = document.createElement('tr');
        for (const key in currentData.transactionRecords[0]) {
          if (key !== 'transaction_id') { // Exclude the 'transaction_id' column
            const th = document.createElement('th');
            th.textContent = key;
            headerRow.appendChild(th);
          }
        }
        const actionsHeader = document.createElement('th');
        actionsHeader.textContent = 'Actions';
        headerRow.appendChild(actionsHeader);
        tableHeader.appendChild(headerRow);

        // Create table rows for each record
        currentData.transactionRecords.forEach(record => {
          const row = document.createElement('tr');
          row.dataset.transactionId = record.transaction_id; // Store transaction ID in data attribute

          for (const key in record) {
            if (key !== 'transaction_id') { // Exclude the 'transaction_id' column
              const td = document.createElement('td');
              td.textContent = record[key];
              row.appendChild(td);
            }
          }

          // Create delete and update buttons
          const deleteButton = document.createElement('button');
          deleteButton.textContent = 'Delete';
          deleteButton.dataset.transactionId = record.transaction_id; // Store transaction ID in data attribute
          deleteButton.dataset.action = 'delete';
          deleteButton.addEventListener('click', handleActionButtonClick);

          const updateButton = document.createElement('button');
          updateButton.textContent = 'Update';
          updateButton.dataset.transactionId = record.transaction_id; // Store transaction ID in data attribute
          updateButton.dataset.action = 'update';
          updateButton.addEventListener('click', handleActionButtonClick);

          const actionsCell = document.createElement('td');
          actionsCell.appendChild(deleteButton);
          actionsCell.appendChild(updateButton);

          row.appendChild(actionsCell);
          tableBody.appendChild(row);
        });

        table.appendChild(tableHeader);
        table.appendChild(tableBody);
        tableContainer.innerHTML = ''; // Clear the table container
        tableContainer.appendChild(currencyTypeElement); // Append the currency and type element
        tableContainer.appendChild(table); // Append the new table

        // Reset the form
        const balanceForm = document.getElementById('balance-form');
        balanceForm.reset();
      }

      function handleActionButtonClick(event) {
        const action = event.target.dataset.action;
        const transactionId = event.target.dataset.transactionId;

        const currencyCode = document.getElementById('currency-code').value;
        const typeCode = document.getElementById('type-code').value;

        if (action === 'delete') {
          const confirmDelete = confirm('Are you sure you want to delete this transaction?');
          if (!confirmDelete) {
            return;
          }
          // Redirect to the delete page with the necessary parameters
          window.location.href = '../controllers/deleteTransactionController.php?transaction_id=' + transactionId;
        } else if (action === 'update') {
          // Redirect to the update page with the transaction ID as a query parameter
          window.location.href = '../controllers/updateTransactionController.php?transaction_id=' + transactionId;
        }
      }

      // Add event listener to the form submit event
      const balanceForm = document.getElementById('balance-form');
      balanceForm.addEventListener('submit', handleFormSubmit);

      // Display any stored transaction data from sessionStorage
      const storedTransaction = sessionStorage.getItem('currentTransaction');
      if (storedTransaction) {
        currentData = JSON.parse(storedTransaction);
        displayTransactionRecords();
        sessionStorage.removeItem('currentTransaction'); // Clear the stored data
      }
    </script>
  </div>
  <?php if (!empty($msg)) { ?>
  <div id="alert-box" class="alert-box"><?php echo $msg; ?></div>
  <?php
  echo '<script>
    setTimeout(function() {
      var alertBox = document.getElementById("alert-box");
      alertBox.remove();
    }, 3000);
  </script>';
  ?>
<?php } ?>
</body>
</html>















