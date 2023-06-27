let currentData = {}; // Store the current data globally
let tableDisplayed = false; 

// Function to handle form submission
function handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const currencyCode = formData.get('currency-code');
    const typeCode = formData.get('type-code');
    const unitSelect = document.getElementById('unitSelect');

    localStorage.setItem('selectedCurrencyCode', currencyCode);
    localStorage.setItem('selectedTypeCode', typeCode);


    // Validate if unit is selected and currency is chosenl
    const typeError = document.getElementById('type-error');
    const currencyError = document.getElementById('currency-error');

    if (unitSelect.value === '') {
        unitSelect.classList.add('error');
            return;
    } else {
        unitSelect.classList.remove('error');
    }

    if (currencyCode === '') {
        currencyError.textContent = 'Please select a currency.';
        return;
    } else {
        currencyError.textContent = '';
    }

     // Make AJAX request to the controller endpoint
    fetch('../controllers/balanceTrialController.php', {
        method: 'POST',
        body: new URLSearchParams({
            currency_code: currencyCode,
            type_code: typeCode,
            unit_id: unitSelect.value
        })
    })
        .then(response => response.json())
        .then(data => {
            console.log('Data:', data);
            currentData = data;
            displayTransactionRecords();
        })
            .catch(error => {
                console.error('Error:', error);
            });
    retrieveTransactionRecords(currencyCode, typeCode);
}
// Retrieve transaction records from the server
function retrieveTransactionRecords(currencyCode, typeCode) {
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

// Function to display transaction records in the table
function displayTransactionRecords() {
    const tableContainer = document.getElementById('transaction-table');
    tableContainer.innerHTML = '';

    if (!currentData || currentData.transactionRecords.length === 0) {
            tableContainer.innerHTML = '<p>No records found.</p>';
            tableDisplayed = false;
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
            const th = document.createElement('th');
            th.textContent = key;
            headerRow.appendChild(th);
        }
    }

    const attachmentHeader = document.createElement('th');
    attachmentHeader.textContent = 'Attachment';
    headerRow.appendChild(attachmentHeader);

    tableHeader.appendChild(headerRow);

    // Create table rows for each record
    currentData.transactionRecords.forEach(record => {
        const row = document.createElement('tr');
        row.dataset.transactionId = record.transaction_id; 
        for (const key in record) {
            if (key !== 'transaction_id' && key !== 'attachment') {
            const td = document.createElement('td');
            td.textContent = record[key];
            row.appendChild(td);
            }
        }
        const attachmentCell = document.createElement('td');
        const attachmentContainer = document.createElement('div');
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
            attachmentCell.appendChild(document.createElement('br'));
            attachmentCell.appendChild(downloadButton);
        } else {
            attachmentCell.textContent = 'Not available';
        }
        attachmentCell.appendChild(attachmentContainer);
        row.appendChild(attachmentCell);
        tableBody.appendChild(row);
    });

        table.appendChild(tableHeader);
        table.appendChild(tableBody);
        tableContainer.innerHTML = ''; // Clear the table container
        tableContainer.appendChild(currencyTypeElement); // Append the currency and type element
        tableContainer.appendChild(table); // Append the new table

        tableDisplayed = true;

        // Reset the form
        const balanceForm = document.getElementById('balance-form');
        balanceForm.reset();
}

// Function to enable/disable the type and currency select elements based on unit selection
function handleUnitSelection() {
    const unitSelect = document.getElementById('unitSelect');
    const typeCodeSelect = document.getElementById('type-code');
    const currencyCodeSelect = document.getElementById('currency-code');

    if (unitSelect.value !== '') {
        typeCodeSelect.disabled = false;
        currencyCodeSelect.disabled = false;
    } else {
        typeCodeSelect.disabled = true;
        currencyCodeSelect.disabled = true;
    }
    displayTransactionRecords();
}
function handleActionButtonClick(event) {
    const button = event.target;
    const transactionId = button.dataset.transactionId;
    const action = button.dataset.action;
  
    
        if (action === 'view') {
            window.location.href = `../controllers/viewController.php?transaction_id=${transactionId}`;
        } else if (action === 'download') {
            window.location.href = `../controllers/downloadController.php?transaction_id=${transactionId}`;
     }
  }

// Add event listener to the form submit event
const balanceForm = document.getElementById('balance-form');
balanceForm.addEventListener('submit', handleFormSubmit);

// Add event listener to the unit select change event
const unitSelect = document.getElementById('unitSelect');
unitSelect.addEventListener('change', handleUnitSelection);

window.addEventListener('DOMContentLoaded', () => {
    // Check if there are previously selected values in local storage
    const selectedCurrencyCode = localStorage.getItem('selectedCurrencyCode');
    const selectedTypeCode = localStorage.getItem('selectedTypeCode');
  
    if (selectedCurrencyCode && selectedTypeCode) {
      // Pre-select the options in the form
      document.getElementById('currency-code').value = selectedCurrencyCode;
      document.getElementById('type-code').value = selectedTypeCode;
  
      retrieveTransactionRecords(selectedCurrencyCode, selectedTypeCode);
    } else {
      tableDisplayed = false; // If no selected values, set the flag to false
    }
  });
  
  // Hide the table if returning to the page or refreshing it
  window.addEventListener('beforeunload', () => {
    if (tableDisplayed) {
      const tableContainer = document.getElementById('transaction-table');
      tableContainer.innerHTML = '';
      tableDisplayed = false;
    }
  });
  
  window.addEventListener('load', () => {
    // Remove the stored values from local storage when the page is loaded
    localStorage.removeItem('selectedCurrencyCode');
    localStorage.removeItem('selectedTypeCode');
  });