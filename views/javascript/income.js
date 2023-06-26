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

  index++;
  newRow.innerHTML = `
    <td>${index}</td>
    <td><input type="text" name="description[]" class="description-column"></td>
    <td><input type="number" name="lbp[]" min="0" oninput="calculateTotal()"></td>
    <td class="attachment-column">
        <label for="file-upload-${index}" class="file-upload-label">
            <input id="file-upload-${index}" class="file-input" type="file" accept="application/pdf" name="attachment[]">
            <i class="fas fa-cloud-upload-alt"></i> Choose File
        </label>
    </td>
    <td>
        <i class="fa fa-times remove-icon" onclick="removeRow(this)"></i>
    </td>
  `;

  tableBody.appendChild(newRow);
}

// Function to remove a row
function removeRow(row) {
  const tableBody = document.getElementById("table-body");
  const currentRow = row.parentNode.parentNode;
  tableBody.removeChild(currentRow);

  index--;
  updateIndex();
  calculateTotal();
}

// Function to update the index values
function updateIndex() {
  const rows = document.getElementById('table-body').rows;

  for (let i = 0; i < rows.length; i++) {
    rows[i].cells[0].textContent = i + 1;
  }
}

// Function to validate the form before submission
function validateForm() {
  let descriptionInputs = document.getElementsByName("description[]");
  let lbpInputs = document.getElementsByName("lbp[]");

  for (let i = 0; i < descriptionInputs.length; i++) {
    if (descriptionInputs[i].value.trim() === "") {
      alert("Please fill in all the description fields.");
      return false;
    }

    if (parseFloat(lbpInputs[i].value) <= 0 || isNaN(parseFloat(lbpInputs[i].value))) {
      alert("Please enter a valid LBP amount greater than 0.");
      return false;
    }
  }

  return true;
}

// Function to close the success message alert
function closeAlert() {
  let alertContainer = document.querySelector(".alert-success-container");
  alertContainer.style.display = "none";
}

function displaySelectedFileName(input) {
  var fileName = input.files[0].name;
  var fileNameElement = document.getElementById("file-name");
  fileNameElement.textContent = fileName;
}


