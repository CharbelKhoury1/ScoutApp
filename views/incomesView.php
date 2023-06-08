<!DOCTYPE html>
<html>
<head>
  <title>Incomes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="css/income.css">
</head>
<body>
  <h1>INCOMES</h1>
  <form action="../controllers/incomesController.php" method="POST">
    <table>
      <thead>
        <tr>
          <th class="empty-cell"></th>
          <th>Description</th>
          <th>LBP</th>
          <th><i class="fas fa-plus" onclick="addRow()"></i></th>
        </tr>
      </thead>
      <tbody id="table-body">
        <tr>
          <td>1</td>
          <td><input type="text" name="description[]" class="description-column"></td>
          <td><input type="number" name="lbp[]" min="0" oninput="calculateTotal()"></td>
          <td>
            <i class="fa fa-times remove-icon"></i>
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td><input type="text" name="description[]" class="description-column"></td>
          <td><input type="number" name="lbp[]" min="0" oninput="calculateTotal()"></td>
          <td>
            <i class="fas fa-times remove-icon" onclick="removeRow(this)"></i>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2">Total</td>
          <td id="total-lbp">-</td>
          <td style="padding: 0;">
            <button type="submit" class="submit-button">Submit</button>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
  <script src="javascript/income.js"></script>
</body>
</html>





