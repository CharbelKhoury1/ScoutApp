<?php include("../sideBar/sideBar.php");?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="../views/css/resetPass.css">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">
    <title>Email Verification</title>
</head>
<body>
    <div class="images">
        <img src="../Pictures/WhatsApp_Image_2023-05-10_at_4.32.21_PM__1_-removebg-preview.png" alt="">
        <img src="../Pictures/ScoutsLogo.gif" alt="">
        <img src="../Pictures/WhatsApp_Image_2023-05-10_at_4.32.22_PM-removebg-preview (1).png" alt="">
        <img src="../Pictures/WhatsApp_Image_2023-05-10_at_4.32.23_PM-removebg-preview (1).png" alt="">
    </div>
    <div class="card">
    <h1>Email Verification</h1>
    <form method="POST" action="../controllers/verifyUserController.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Enter your email" required>
        <br>
        <div class="button-container">
        <button type="submit"> Send Email </button>
        <button type="button" class="cancel-button" onclick="window.location.href='../Login/Login.php'">Cancel</button>
        </div>
    </form>
    </div>
    <div class="centered-container">
		<div id="passwordError" style="display:none; color:red;"></div>

		<?php if (isset($errorMsg)): ?>
			<div id="errorMsg"><?php echo $errorMsg; ?></div>
		<?php endif; ?>
		<?php if (!empty($successMsg)): ?>
			<div class="success-message"><?php echo $successMsg;?></div>
			<meta http-equiv="refresh" content="5;url=../Login/Login.php">   
		<?php endif; ?>
	</div>	
</body>
</html>