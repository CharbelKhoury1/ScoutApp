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

