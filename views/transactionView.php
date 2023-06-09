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
    <script src="../views/javascript/transaction.js"></script>
</body>
</html>
























