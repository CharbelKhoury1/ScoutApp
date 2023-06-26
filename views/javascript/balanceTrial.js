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
                'currency_code': currencyCode,
                'type_code': typeCode
          })
    })
      .then(response => response.json())
      .then(data => {
          currentData = data;
          displayTransactionRecords();
      })
        .catch(error => {
          console.error('Error:', error);
        });
}

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
    if (key !== 'transaction_id' && key !== 'attachment') {
      // Exclude the 'transaction_id' and 'attachment' columns
      const th = document.createElement('th');
      th.textContent = key;
      headerRow.appendChild(th);
    }
  }

  const attachmentHeader = document.createElement('th');
  attachmentHeader.textContent = 'Attachment';
  headerRow.appendChild(attachmentHeader);

  const actionsHeader = document.createElement('th');
  actionsHeader.textContent = 'Actions';
  headerRow.appendChild(actionsHeader);

  tableHeader.appendChild(headerRow);

  // Create table rows for each record
  currentData.transactionRecords.forEach(record => {
    const row = document.createElement('tr');
    row.dataset.transactionId = record.transaction_id; // Store transaction ID in data attribute

    for (const key in record) {
      if (key !== 'transaction_id' && key !== 'attachment') {
        // Exclude the 'transaction_id' and 'attachment' columns
        const td = document.createElement('td');
        td.textContent = record[key];
        row.appendChild(td);
      }
    }

    const attachmentCell = document.createElement('td');
    if (record.attachment) {
      const viewButton = document.createElement('button');
      viewButton.textContent = 'View';
      viewButton.dataset.transactionId = record.transaction_id; // Store transaction ID in data attribute
      viewButton.dataset.action = 'view';
      viewButton.addEventListener('click', handleActionButtonClick);

      const downloadButton = document.createElement('button');
      downloadButton.textContent = 'Download';
      downloadButton.dataset.transactionId = record.transaction_id; // Store transaction ID in data attribute
      downloadButton.dataset.action = 'download';
      downloadButton.addEventListener('click', handleActionButtonClick);

      attachmentCell.appendChild(viewButton);
      attachmentCell.appendChild(downloadButton);
    } else {
      attachmentCell.textContent = 'Not available';
    }

    const actionsCell = document.createElement('td');
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

    actionsCell.appendChild(deleteButton);
    actionsCell.appendChild(updateButton);

    row.appendChild(attachmentCell);
    row.appendChild(actionsCell);
    tableBody.appendChild(row);
  });

  table.appendChild(tableHeader);
  table.appendChild(tableBody);
  tableContainer.innerHTML = ''; // Clear the table container
  tableContainer.appendChild(currencyTypeElement); // Append the currency and type element
  tableContainer.appendChild(table); // Append the new table to the container
}


// Function to handle delete and update button clicks
function handleActionButtonClick(event) {
  const button = event.target;
  const transactionId = button.dataset.transactionId;
  const action = button.dataset.action;

  if (action === 'delete') {
      const confirmDelete = confirm('Are you sure you want to delete this transaction?');
      if (!confirmDelete) {
            return;
      }
                
        window.location.href = '../controllers/deleteTransactionController.php?transaction_id=' + transactionId;
      } else if (action === 'update') {
         window.location.href = `../controllers/updateTransactionController.php?transaction_id=${transactionId}`;
      } else if (action === 'view') {
          window.location.href = `../controllers/viewController.php?transaction_id=${transactionId}`;
      } else if (action === 'download') {
          window.location.href = `../controllers/downloadController.php?transaction_id=${transactionId}`;
   }
}

 // Attach form submission event listener
const balanceForm = document.getElementById('balance-form');
balanceForm.addEventListener('submit', handleFormSubmit);


