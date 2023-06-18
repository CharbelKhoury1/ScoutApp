<?php

session_start();

include ("../common.inc.php");
include ("../utility.php");
$con=connection();

function sanitizeInput($input) {
    // Remove leading/trailing white space
    $input = trim($input);
    // Remove backslashes
    $input = stripslashes($input);
    // Escape special characters
    $input = htmlspecialchars($input);
    
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-btn'])) {

    // Get the code and password from the form submission and sanitize them
    $code = sanitizeInput($_POST["scoutcode"]);
    $password = sanitizeInput($_POST["password"]);

    // Sanitize the input for the query
    $code = mysqli_real_escape_string($con, $code);
    $password = mysqli_real_escape_string($con, $password);

    $query = "SELECT * FROM usercredentials AS uc WHERE uc.scoutcode='$code' AND uc.password='$password'";
    $res = mysqli_query($con, $query);

    if (mysqli_num_rows($res) <= 0) {
        echo '<script>alert("Enter a valid scout code or password");</script>';
    } else {
        // Prepare the SQL query
        $sql = "SELECT user.user_id, user.email, user.fname, user.lname FROM usercredentials INNER JOIN user ON usercredentials.userId = user.user_id WHERE usercredentials.scoutcode = '$code' AND usercredentials.password = '$password'";

        // Execute the query
        $result = mysqli_query($con, $sql);

        // Check if the query was successful
        if ($result) {
            // Check if the credentials are found or not
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['code'] = $code;
                $_SESSION['password'] = $password;
                while ($row = mysqli_fetch_assoc($result)) {
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['user_id']=$row['user_id'];
                    $_SESSION['name']=$row['fname']."  ".$row['lname'];
                }
                header('Location: ../Home/Home.php'); // Redirect to the Home page
                exit;
            } else {
                // Redirect to the sign-up page with the code and password as query parameters
                $redirectUrl = '../SignUp/SignUp1.php?code=' . urlencode($code) . '&password=' . urlencode($password);
                header('Location: ' . $redirectUrl);
                exit;
            }
        } else {
            // Handle the query error
            echo "Error: " . mysqli_error($con);
        }
    }

    // Close the database connection
    mysqli_close($con);
}

?>
