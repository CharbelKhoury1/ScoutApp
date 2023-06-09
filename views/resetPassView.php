<?php require("sideBar.php");?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="../views/css/resetPass.css">
	<title>Reset Password</title>
</head>
<body>
	<div class="card">
		<h1>Reset Password</h1>
		<form action="../controllers/resetPassController.php" method="post" onsubmit="return validateForm()">
			<label for="password" class="form-label">Username:</label>
			<input type="text" name="username" placeholder="Enter your username" required>
			<label for="password">Password:</label>
			<div>
				<input type="password" id="passwordInput" name="password" placeholder="Enter your password" required>
				<span class="eye-icon" id="togglePassword" onclick="togglePasswordVisibility('passwordInput')">
					<i class="fa fa-eye-slash" aria-hidden="true"></i>
				</span>
			</div>

			<label for="confirm password">Confirm Password:</label>	
			<div>
				<input type="password" id="confirmPasswordInput" name="confirmPassword" placeholder="Confirm your password"required>
				<span class="eye-icon2" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirmPasswordInput')">
					<i class="fa fa-eye-slash" aria-hidden="true"></i>
				</span>
			</div>	

			<button type="submit">Reset Password</button>
		</form>
	</div>
	<div class="centered-container">
		<div id="passwordError" style="display:none; color:red;"></div>

		<?php if (isset($errorMsg)): ?>
			<div id="errorMsg"><?php echo $errorMsg; ?></div>
		<?php endif; ?>
		<?php if (!empty($successMsg)): ?>
			<div class="success-message"><?php echo $successMsg; ?></div>
		<?php endif; ?>
	</div>	
	<script src="../views/javascript/resetPass.js"></script>
</body>
</html>

