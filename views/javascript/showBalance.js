function populateUnits() {
    var regimentSelect = document.getElementById("regimentSelect");
    var unitSelect = document.getElementById("unitSelect");
    var selectedOption = regimentSelect.options[regimentSelect.selectedIndex];
    var selectedRegimentId = selectedOption.getAttribute("data-regiment-id");

    // Enable the unit dropdown
    unitSelect.disabled = false;

    // Clear previous options
    unitSelect.innerHTML = '<option value="">Select Unit</option>';

    if (selectedRegimentId) {
        // Make an AJAX request to get the units for the selected regiment
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../controllers/getUnits.php?regiment_id=" + selectedRegimentId, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var units = JSON.parse(xhr.responseText);

                // Populate the unit dropdown with the retrieved units
                units.forEach(function (unit) {
                    var option = document.createElement("option");
                    option.value = unit.unit_id; // Set the value to the unit ID
                    option.text = unit.name;
                    unitSelect.appendChild(option);
                });
            }
        };
        xhr.send();
    } else {
        // If no regiment is selected, disable the unit dropdown
        unitSelect.disabled = true;
    }
}

function fetchBalance() {
    var unitSelect = document.getElementById("unitSelect");
    var selectedUnitId = unitSelect.value;

    if (selectedUnitId) {
        fetch('../controllers/showBalanceController.php?unitId=' + selectedUnitId)
            .then(response => response.json())
            .then(data => {
                var chartContainerLBP = document.getElementById('chartContainerLBP');
                var chartContainerUSD = document.getElementById('chartContainerUSD');

                chartContainerLBP.innerHTML = '';
                chartContainerUSD.innerHTML = '';

                if (data.lbp_balance) {
                    var balanceTextLBP = document.createElement('div');
                    balanceTextLBP.innerHTML = `<h3 class="balance-text">Current Balance: ${data.lbp_balance} LBP</h3>`;
                    chartContainerLBP.appendChild(balanceTextLBP);

                    var chartLBP = document.createElement('canvas');
                    chartLBP.id = 'chartLBP';
                    chartContainerLBP.appendChild(chartLBP);
                    new Chart(chartLBP, {
                        type: 'doughnut',
                        data: {
                            labels: ['LBP Income', 'LBP Expense'],
                            datasets: [{
                                data: [data.lbp_income, data.lbp_expense],
                                backgroundColor: ['#007bff', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'LBP Income and Expenses'
                                },
                                legend: {
                                    display: true,
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                    chartContainerLBP.style.display = 'block';
                } else {
                    var noBalanceMessageLBP = document.createElement('div');
                    noBalanceMessageLBP.className = 'no-balance-message';
                    noBalanceMessageLBP.textContent = 'No balance available';
                    chartContainerLBP.appendChild(noBalanceMessageLBP);
                    chartContainerLBP.style.display = 'block';
                }

                if (data.usd_balance) {
                    var balanceTextUSD = document.createElement('div');
                    balanceTextUSD.innerHTML = `<h3 class="balance-text">Current Balance: ${data.usd_balance} USD</h3>`;
                    chartContainerUSD.appendChild(balanceTextUSD);

                    var chartUSD = document.createElement('canvas');
                    chartUSD.id = 'chartUSD';
                    chartContainerUSD.appendChild(chartUSD);
                    new Chart(chartUSD, {
                        type: 'doughnut',
                        data: {
                            labels: ['USD Income', 'USD Expense'],
                            datasets: [{
                                data: [data.usd_income, data.usd_expense],
                                backgroundColor: ['#007bff', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'USD Income and Expenses'
                                },
                                legend: {
                                    display: true,
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                    chartContainerUSD.style.display = 'block';
                } else {
                    var noBalanceMessageUSD = document.createElement('div');
                    noBalanceMessageUSD.className = 'no-balance-message';
                    noBalanceMessageUSD.textContent = 'No balance available';
                    chartContainerUSD.appendChild(noBalanceMessageUSD);
                    chartContainerUSD.style.display = 'block';
                }
            })
            .catch(error => console.error(error));
    } else {
        var chartContainerLBP = document.getElementById('chartContainerLBP');
        var chartContainerUSD = document.getElementById('chartContainerUSD');

        chartContainerLBP.innerHTML = '';
        chartContainerUSD.innerHTML = '';
        chartContainerLBP.style.display = 'none';
        chartContainerUSD.style.display = 'none';
    }
}

document.getElementById("unitSelect").addEventListener("change", fetchBalance);