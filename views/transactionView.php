<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../views/css/transaction.css">
    <title>Transaction View</title>
</head>
<body>
    <div class="container">
        <div class="box" onmouseover="showOptions('incomeOptions')" onmouseout="hideOptions('incomeOptions')">
            <a href="">
                <img src="images/incomes.jpg">
            </a>
            <div class="caption">Income</div>
            <div class="options" id="incomeOptions">
                <div class="option">
                    <a href="">USD</a>
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
                    <a href="">USD</a>
                </div>
                <div class="option">
                    <a href="incomesView.php">LBP</a>
                </div>
            </div>
        </div>
        <div class="box">
            <a href="">
                <img src="images/total.png">
            </a>
            <div class="captionTotal">Balance</div>
        </div>
        <div class="box">
            <a href="">
                <img src="images/total.png">
            </a>
            <div class="captionTotal">Trial Balance</div>
        </div>
    </div>

    <script>
        function showOptions(id) {
            document.getElementById(id).style.display = 'block';
        }

        function hideOptions(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
</body>
</html>















