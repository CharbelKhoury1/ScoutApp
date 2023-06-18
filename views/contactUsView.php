<?php require("sideBar.php");?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="../views/css/contactUs.css">
	<title>Contact Us</title>
</head>
<body>
	<div class="card">
		<h1>Contact Us</h1>
		<h4 style="color: red">All fields marked with an asterisk(*) are mandatory</h4>
		<form id="contactForm" method="POST" action="../controllers/contactUsController.php">
			<div class="input-row">
				<div class="input-group">
					<label for="firstname">First Name: <span style="color: red">*</span></label>
					<input type="text" name="firstname"  required>
				</div>
				<div class="input-group">
					<label for="lastname">Last Name:<span style="color: red">*</span></label>
					<input type="text" name="lastname"  required>
				</div>
			</div>
			<div class="input-row">
				<div class="input-group">
					<label for="email">Email:<span style="color: red">*</span></label>
					<input type="email" name="email" required>
				</div>
				<div class="input-group">
					<label for="phone">Phone Number:</label>
					<input type="tel" name="phone" >
				</div>
			</div>
			<div class="input-group">
				<label for="message">Message:<span style="color: red">*</span></label>
				<textarea name="message" required></textarea>
			</div>
			<div class="wrapper">
				<canvas id="canvas" width="200" height="50"></canvas>
				<button id="reload-button">
					<i class="fa-solid fa-arrow-rotate-right"></i>
				</button>
			</div>
			<input type="text" id="user-input" placeholder="Enter the text in the image" required />
			<button type="submit" id="submit-button">Send</button>
		</form>
	</div>
	<div class="centered-container">
		<?php if (isset($errorMsg)): ?>
			<div id="error-input"><?php echo $errorMsg; ?></div>
		<?php endif; ?>
		<?php if (!empty($successMsg)): ?>
			<div class="success-message"><?php echo $successMsg; ?></div>
		<?php endif; ?>
	</div>
	<script src="../views/javascript/contactUs.js"> </script>
</body>
</html>



