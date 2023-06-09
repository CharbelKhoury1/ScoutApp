<!-- transactionView.php -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../views/css/transaction.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400&display=swap" 
  rel="stylesheet">
    <title>Transaction View</title>
</head>
<body>
        
    <div class="sidebar">
            <div class="logo">
                <img src="../Icons/menu-svgrepo-com.svg" alt="sds">
                <img src="../Icons/arrow-right-svgrepo-com.svg" alt="sdsd">
                <img src="../Icons/close-md-svgrepo-com.svg" alt="dsd">
            </div>
            <div class="links">
            <button class="" onclick="window.location.href='../Home/Home.php'">
        <img src="../Icons/home-alt-svgrepo-com.svg">Home
        </button>
        <button class="" onclick="window.location.href='Requests.html'">
        <img src="../Icons/git-pull-request-svgrepo-com.svg">Requests
        </button>
        <button class="active" onclick="window.location.href='transactionView.php'">
        <img src="../Icons/finance-currency-dollar-svgrepo-com.svg">Finance
        </button>
        <button class="" onclick="window.location.href='../ScoutManagementSystem/ScoutCode.php'">
        <img src="../Icons//icons8-password.svg">Scouts Management
        </button>
        <button class="" onclick="window.location.href='../Home/Home.php'">
        <img src="../Icons/world-1-svgrepo-com.svg">Social Media
        </button>
        <button class="" onclick="window.location.href='../Home/Home.php'">
        <img src="../Icons/system-help-svgrepo-com.svg">About Us
        </button>
        <button  class="" onclick="window.location.href='../views/contactUsView.php'">
        <img src="../Icons/phone-svgrepo-com.svg">Contact Us
        </button>
            </div>
            </div>
            
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
        
    </div>

<<<<<<< HEAD
    <script>
        function showOptions(id) {
            document.getElementById(id).style.display = 'block';
        }

        function hideOptions(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>

    <script>
  // sidebar js
document.querySelector(".sidebar .logo").addEventListener("click",
function(){
  document.querySelector(".sidebar").classList.toggle("active");
})

</script>
=======
    <div class="container1">
        <div class="chart-container" id="chartContainerLBP">
            <canvas id="chartLBP"></canvas>
        </div>
        <div class="chart-container" id="chartContainerUSD">
            <canvas id="chartUSD"></canvas>
        </div>
    </div>
    <script src="../views/javascript/transaction.js"></script>
>>>>>>> 2aee9e323476ce67763a89e7ac6bd44d7279ec8f
</body>
</html>
























