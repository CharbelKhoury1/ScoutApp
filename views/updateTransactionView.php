<?php 
include("../sideBar/sideBar.php");
include("backArrow.php");
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <title>Transaction Update</title>
  <link rel="stylesheet" href="../views/css/updateTransaction.css">
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h2>Update Transaction Details</h2>
        </div>
        <form method="POST" action="../controllers/updateController.php">
            <table>
                <tr>
                    <td>
                        <label for="amount">Amount</label>
                        <input type="text" id="amount" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required><?php echo isset($description) ? $description : ''; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" <?php if (!empty($date)) { ?>value="<?php echo $date; ?>"<?php } ?> required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" id="transactionId" name="transactionId" value="<?php echo isset($transactionId) ? $transactionId: ''; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" class="button" name="save">Save</button>
                        <a href="../views/BalanceTrialView.php" class="button cancel">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php if (!empty($msg)) { ?>
        <div class="alert-box"><?php echo $msg; echo " You will be redirected to the login page in a few seconds"?></div>
        <meta http-equiv="refresh" content="3;url=../views/BalanceTrialView.php">
    <?php } ?>
</body>
