<!-- transactionView.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../views/css/transaction.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <title>Transaction View</title>
    <style>
    .container1 {
        margin-top: 90px;
        display: flex;
        justify-content: center;
    }

    .chart-container {
        width: 30%; /* Adjust the width as needed */
        height: 300px;
        margin: 0 -10px; /* Adjust the margin as needed */
    }

    .balance-text {
    margin-left: 25%;
    }

</style>


</head>
<body>
    <?php require(__DIR__ . "/sideBar.php"); ?>

    <div class="container">
        <div class="box" onmouseover="showOptions('incomeOptions')" onmouseout="hideOptions('incomeOptions')">
            <a href="">
                <img src="images/incomes.jpg">
            </a>
            <div class="caption">Income</div>
            <div class="options" id="incomeOptions">
                <div class="option">
                    <a href="incomesUSDView.php">USD</a>
                </div>
                <div class="option">
                    <a href="incomesView.php">LBP</a>
                </div>
            </div>
        </div>
        <div class="box" onmouseover="showOptions('expensesOptions')" onmouseout="hideOptions('expensesOptions')">
            <a href="">
                <img src="images/expenses.jpg">
            </a>
            <div class="caption">Expenses</div>
            <div class="options" id="expensesOptions">
                <div class="option">
                    <a href="expensesUSDView.php">USD</a>
                </div>
                <div class="option">
                    <a href="expensesView.php">LBP</a>
                </div>
            </div>
        </div>
        <div class="box" onclick="fetchBalance()">
            <img src="images/total.png">
            <div class="captionTotal">Balance</div>
        </div>
        <div class="box">
            <img src="images/total.png">
            <div class="captionTotal">Trial Balance</div>
        </div>
    </div>

    <div class="container1">
        <div class="chart-container" id="chartContainerLBP">
            <canvas id="chartLBP"></canvas>
        </div>
        <div class="chart-container" id="chartContainerUSD">
            <canvas id="chartUSD"></canvas>
        </div>
    </div>

    <script>
        function showOptions(id) {
            document.getElementById(id).style.display = 'block';
        }

        function hideOptions(id) {
            document.getElementById(id).style.display = 'none';
        }

        function fetchBalance() {
            fetch('../controllers/balanceController.php')
                .then(response => response.json())
                .then(data => {
                    const balanceTextLBP = document.createElement('div');
                    balanceTextLBP.innerHTML = `<h3 class="balance-text">Current Balance: ${data.lbp_balance} LBP</h3>`;
                    document.getElementById('chartContainerLBP').insertBefore(balanceTextLBP, document.getElementById('chartLBP'));

                    const balanceTextUSD = document.createElement('div');
                    balanceTextUSD.innerHTML = `<h3 class="balance-text">Current Balance: ${data.usd_balance} USD</h3>`;
                    document.getElementById('chartContainerUSD').insertBefore(balanceTextUSD, document.getElementById('chartUSD'));

                    const chartDataLBP = {
                        labels: ['LBP Income', 'LBP Expense'],
                        datasets: [{
                            data: [data.lbp_income, data.lbp_expense],
                            backgroundColor: ['#007bff', '#dc3545'],
                        }]
                    };

                    const chartContainerLBP = document.getElementById('chartContainerLBP');
                    chartContainerLBP.style.display = 'block'; // Display the LBP chart container

                    const chartLBP = document.getElementById('chartLBP').getContext('2d');
                    new Chart(chartLBP, {
                        type: 'doughnut',
                        data: chartDataLBP,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                position: 'bottom'
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'LBP Income and Expenses'
                                }
                            }
                        }
                    });

                    const chartDataUSD = {
                        labels: ['USD Income', 'USD Expense'],
                        datasets: [{
                            data: [data.usd_income, data.usd_expense],
                            backgroundColor: ['#007bff', '#dc3545'],
                        }]
                    };

                    const chartContainerUSD = document.getElementById('chartContainerUSD');
                    chartContainerUSD.style.display = 'block'; // Display the USD chart container

                    const chartUSD = document.getElementById('chartUSD').getContext('2d');
                    new Chart(chartUSD, {
                        type: 'doughnut',
                        data: chartDataUSD,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                position: 'bottom'
                            },
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'USD Income and Expenses'
                                }
                            }
                        }
                    });

                   
                });
        }
    </script>
</body>
</html>
























