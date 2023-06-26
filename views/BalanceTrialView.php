<?php
include("../sideBar/sideBar.php");
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
} else {
  header("Location: ../Home/Home.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <title>Transaction Details</title>
  <link rel="stylesheet" href="../views/css/balanceTrial.css">  
</head>
<body>
  <div class="container">
    <h1>Transaction Details</h1>
    <form id="balance-form">
      <label for="type-code">Select Type:<br> (اختر النوع)</label>
      <select id="type-code" name="type-code">
        <option value="0">Income (مداخيل)</option>
        <option value="1">Expense (مصاريف)</option>
      </select>
      <br>
      <label for="currency-code">Select Currency: (اختر العملة)</label>
      <select id="currency-code" name="currency-code">
        <option value="0">LBP (ل.ل.)</option>
        <option value="1">USD ($)</option>
      </select>
      <button type="submit">Submit</button>
    </form>
    <div id="transaction-table"></div>
    <p id="response-message"></p>
    <script src="../views/javascript/balanceTrial.js"></script>
  </div>
  <?php if (!empty($msg)) { ?>
  <div id="alert-box" class="alert-box"><?php echo $msg; ?></div>
  <?php
  echo '<script>
    setTimeout(function() {
      var alertBox = document.getElementById("alert-box");
      alertBox.remove();
    }, 3000);
  </script>';
  ?>
<?php } ?>














