<?php
// Check if the user is logged in with Facebook
session_start();
if (!isset($_SESSION['access_token'])) {
    header("Location: postFb.php");
    exit();
}

// Display the post creation form
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>
    <h1>Create a New Post</h1>
    <form method="post" action="create-post.php">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br>

        <label for="content">Content:</label>
        <textarea name="content" id="content" required></textarea><br>

        <input type="submit" value="Create Post">
    </form>
</body>
</html>
