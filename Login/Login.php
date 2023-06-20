<?php
include "LoginCredentials.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="Login.css">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">

</head>
<body>
    <div class="images">
        <img src="../Pictures/WhatsApp_Image_2023-05-10_at_4.32.21_PM__1_-removebg-preview.png" alt="">
        <img src="../Pictures/ScoutsLogo.gif" alt="">
        <img src="../Pictures/WhatsApp_Image_2023-05-10_at_4.32.22_PM-removebg-preview (1).png" alt="">
        <img src="../Pictures/WhatsApp_Image_2023-05-10_at_4.32.23_PM-removebg-preview (1).png" alt="">
    </div>
    <div class="container">
        <h1 class="header">Welcome</h1>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <label for="scoutcode">Scout Code:</label>
            <input type="text" id="scoutcode" name="scoutcode" placeholder="Enter your Scout Code" value="<?php echo isset($_COOKIE['scoutcode']) ? $_COOKIE['scoutcode'] : ''; ?>" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" required>
           
            
            <div class="remember-me-container">
                <table>
                    <tr>
                        <td> <input class="remember-me-checkbox" type="checkbox" id="remember-me" name="remember-me" <?php if (isset($scoutcode) && isset($password)) { echo 'checked'; } ?>> </td>
                        <td><label class="remember-me-label" for="remember-me">Remember Me</label></td>
                    </tr>
                </table>
            </div>
            <input type="submit" id="submit-btn" name="submit-btn" value="Continue">
        
          </form>
        <p class="register"><a href="../views/resetPassView.php" > Forgot Password?</a></p>
    </div>
</body>
</html>
