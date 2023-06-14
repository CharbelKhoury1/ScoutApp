<?php require("sideBar.php");?>
<?php
session_start();
if (isset($_SESSION["success_message"])) {
    $successMessage = $_SESSION["success_message"];
    unset($_SESSION["success_message"]); 
}
if (isset($_SESSION["error_message"])) {
    $errorMessage = $_SESSION["error_message"];
    unset($_SESSION["error_message"]); 
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Incomes in USD</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="css/income.css">
</head>
<body>
  <h1>INCOMES IN USD</h1>
  <form action="../controllers/incomesController.php" method="POST" onsubmit="return validateForm()">
    <table>
      <thead>
        <tr>
          <th class="empty-cell"></th>
          <th>Description</th>
          <th>USD</th>
          <th><i class="fas fa-plus" onclick="addRow()"></i></th>
        </tr>
      </thead>
      <tbody id="table-body">
        <tr>
          <td>1</td>
          <td><input type="text" name="description[]" class="description-column"></td>
          <td><input type="number" name="usd[]" min="0" oninput="calculateTotal()"></td>
          <td>
            <i class="fa fa-times remove-icon"></i>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td><input type="text" name="description[]" class="description-column"></td>
          <td><input type="number" name="usd[]" min="0" oninput="calculateTotal()"></td>
          <td>
            <i class="fas fa-times remove-icon" onclick="removeRow(this)"></i>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2">Total</td>
          <td id="total-usd">-</td>
          <td style="padding: 0;">
            <button type="submit" class="submit-button" name="submitusd">Submit</button>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
  <?php if (isset($successMessage)) : ?>
        <div id="alert-success-container" class="alert-success-container">
            <div class="alert-success">
                <p><?php echo $successMessage; ?></p>
                <span class="close-icon" onclick="closeAlert()">&times;</span>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (isset($errorMessage)) : ?>
        <div class="alert-box">
            <div class="alert-content">
                <p><?php echo $errorMessage; ?></p>
            </div>
        </div>
    <?php endif; ?>
    
    <script src="javascript/income.js"></script>
</body>
</html>

