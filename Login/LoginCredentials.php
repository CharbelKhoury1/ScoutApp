<?php

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

    // Prepare the SQL query
    $sql = "SELECT user.user_id FROM usercredentials JOIN user ON usercredentials.userId = user.user_id WHERE usercredentials.scoutcode = '$code' AND usercredentials.password = '$password'";

    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        // Check if the credentials are found or not
        if (mysqli_num_rows($result) > 0) {
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
        echo "Query error: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
}

?>