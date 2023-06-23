function calculateTotal() {
  let lbpInputs = document.getElementsByName("lbp[]");
  let totalLBP = 0;
  for (let i = 0; i < lbpInputs.length; i++) {
    let lbp = parseFloat(lbpInputs[i].value) || 0;
    totalLBP += lbp;
  }
  document.getElementById("total-lbp").textContent = totalLBP.toFixed(2);
}

let index = document.getElementById('table-body').rows.length;

// Function to add a new row
function addRow() {
  const tableBody = document.getElementById("table-body");
  const newRow = document.createElement("tr");

  const indexCell = document.createElement("td");
  index++;
  indexCell.textContent = index;
  newRow.appendChild(indexCell);

  const descriptionCell = document.createElement("td");
  descriptionCell.className = "description-column";
  const descriptionInput = document.createElement("input");
  descriptionInput.type = "text";
  descriptionInput.name = "description[]";
  descriptionInput.style.border = "none";
  descriptionCell.appendChild(descriptionInput);
  newRow.appendChild(descriptionCell);

  const lbpCell = document.createElement("td");
  const lbpInput = document.createElement("input");
  lbpInput.type = "number";
  lbpInput.name = "lbp[]";
  lbpInput.min = "0"; // Restrict input to positive numbers
  lbpInput.style.border = "none";
  lbpInput.addEventListener("input", calculateTotal); // Calculate total on input change
  lbpCell.appendChild(lbpInput);
  newRow.appendChild(lbpCell);

  const attachmentCell = document.createElement("td");
  attachmentCell.className = "attachment-column";
  const attachmentLabel = document.createElement("label");
  attachmentLabel.htmlFor = "file-upload";
  attachmentLabel.className = "file-upload-label";
  const attachmentInput = document.createElement("input");
  attachmentInput.id = "file-upload";
  attachmentInput.className = "file-input";
  attachmentInput.type = "file";
  attachmentInput.accept = "application/pdf";
  attachmentInput.name = "attachment[]";
  const attachmentIcon = document.createElement("i");
  attachmentIcon.className = "fas fa-cloud-upload-alt";
  attachmentLabel.appendChild(attachmentInput);
  attachmentLabel.appendChild(attachmentIcon);
  attachmentLabel.appendChild(document.createTextNode(" Choose File"));
  attachmentCell.appendChild(attachmentLabel);
  newRow.appendChild(attachmentCell);

  const removeCell = document.createElement("td");
  const removeIcon = document.createElement("i");
  removeIcon.className = "fas fa-times remove-icon";
  removeIcon.addEventListener("click", function () {
    removeRow(this);
    calculateTotal(); // Update the total after removing a row
  });
  removeCell.appendChild(removeIcon);
  newRow.appendChild(removeCell);

  // Remove the additional column if it exists
  const additionalCell = newRow.querySelector('.additional-column');
  if (additionalCell) {
    newRow.removeChild(additionalCell);
  }

  tableBody.appendChild(newRow);
}

// Function to remove a row
function removeRow(row) {
  var tableBody = document.getElementById('table-body');
  var currentRow = row.parentNode.parentNode;
  tableBody.removeChild(currentRow);
  index--;
  updateIndex();
}

// Function to update the index values
function updateIndex() {
  var rows = document.getElementById('table-body').rows;
  for (var i = 0; i < rows.length; i++) {
    rows[i].cells[0].textContent = i + 1;
  }
}

function validateForm() {
  var descriptionInputs = document.querySelectorAll('input[name="description[]"]');
  var lbpInputs = document.querySelectorAll('input[name="lbp[]"]');

  // Check if any required field is empty
  for (var i = 0; i < descriptionInputs.length; i++) {
    if (descriptionInputs[i].value.trim() === '' || lbpInputs[i].value.trim() === '') {
      var alertDiv = document.createElement('div');
      alertDiv.className = 'alert';
      alertDiv.textContent = 'Please fill in all required fields.';
      document.body.appendChild(alertDiv);

      setTimeout(function() {
        alertDiv.style.display = 'none';
      }, 3000);

      return false; // Prevent form submission
    }
  }

  return true; // Allow form submission
} 

function closeAlert() {
  var container = document.getElementById("alert-success-container");
  container.style.display = "none";
}

