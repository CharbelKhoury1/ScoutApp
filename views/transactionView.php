<?php include("../sideBar/sideBar.php");?>
<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    header("Location: ../Home/Home.php");
    exit();
}
require('../models/transactionModel.php');

#$userId = 6; 

$hasPermission = hasTransactionPermission($userId);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../views/css/transaction.css">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <title>Transaction View</title>
</head>
<body>

    <div class="container">
        <?php if (isset($hasPermission) && $hasPermission): ?>
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
        <?php endif; ?>

        <div class="box <?php if (!$hasPermission) echo 'small-box'; ?>" onclick="redirectToBalance()">
            <img src="images/total.png">
            <div class="captionTotal">Balance</div>
        </div>
        <div class="box <?php if (!$hasPermission) echo 'small-box'; ?>">
        <?php if (!$hasPermission): ?>
            <a href="showTransactionView.php">
                <img src="images/transactions.jpg" style="width: 75%; height: 70%;"  style="filter: grayscale(100%);">
            </a>
        <?php else: ?>
            <a href="BalanceTrialView.php">
                <img src="images/transactions.jpg">
            </a>
        <?php endif; ?>
        <div class="capt <?php if (!$hasPermission) echo 'small-caption'; ?>">Transactions</div>
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
    <script>
        var hasPermission = <?php echo json_encode($hasPermission); ?>;
        if (!hasPermission) {
            var incomeBox = document.querySelector('.box.onmouseover');
            var expensesBox = document.querySelector('.box.onmouseover');
            incomeBox.style.display = 'none';
            expensesBox.style.display = 'none';
        }
        function redirectToBalance() {
            if (!hasPermission) {
                window.location.href = "showBalanceView.php";
            } else {
                fetchBalance();
            }
        }
    </script>
</body>
</html>































