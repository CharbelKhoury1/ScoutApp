function calculateTotal() {
    let usdInputs = document.getElementsByName("usd[]");
    let totalUSD = 0;
    for (let i = 0; i < usdInputs.length; i++) {
      let usd = parseFloat(usdInputs[i].value) || 0;
      totalUSD += usd;
    }
    document.getElementById("total-usd").textContent = totalUSD.toFixed(2);
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
  
    const usdCell = document.createElement("td");
    const usdInput = document.createElement("input");
    usdInput.type = "number";
    usdInput.name = "usd[]";
    usdInput.min = "0"; // Restrict input to positive numbers
    usdInput.style.border = "none";
    usdInput.addEventListener("input", calculateTotal); // Calculate total on input change
    usdCell.appendChild(usdInput);
    newRow.appendChild(usdCell);
  
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
    var usdInputs = document.querySelectorAll('input[name="usd[]"]');

    // Check if any required field is empty
    for (var i = 0; i < descriptionInputs.length; i++) {
      if (descriptionInputs[i].value.trim() === '' || usdInputs[i].value.trim() === '') {
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
  