<?php
session_start();
require_once("image-master/vendor/autoload.php"); // Include the autoload file for Intervention Image library
require_once("../models/profileModel.php");

use Intervention\Image\ImageManagerStatic as Image;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    } else {
        header("Location: ../Home/Home.php");
        exit();
    }

    if ($_FILES['profilePhoto']['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $_FILES['profilePhoto']['tmp_name'];
        $fileName = $_FILES['profilePhoto']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid() . '.' . $fileExtension;
        $uploadDirectory = '../profile-photos/';

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory);
        }

        $destinationPath = $uploadDirectory . $newFileName;

        // Open and process the uploaded image
        $image = Image::make($tempFilePath);

        // Perform any image processing or manipulation here (e.g., resize, crop, apply filters)

        // Save the processed image to the destination path
        $image->save($destinationPath);

        // Get the image content
        $imageContent = file_get_contents($destinationPath);

        // Update the user_images table with the new image path and content
        $updateResult = updateProfilePhoto($userId, $destinationPath, $imageContent);

        if ($updateResult) {
            // Redirect back to the profile page
            echo "yes";
        } else {
            // Log the error
            error_log("Failed to update profile photo in the database.");

            // Redirect back to the profile page with an error message
            echo "no";
        }
    } else {
        // Log the upload error
        $errorCode = $_FILES['profilePhoto']['error'];
        $errorMessage = getUploadErrorMessage($errorCode);
        $logMessage = "Upload Error: [Code: $errorCode] $errorMessage";
        error_log($logMessage);

        // If the upload fails or no file was selected, redirect back to the profile page
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Photo Upload</title>
</head>
<body>
    <h1>Profile Photo Upload</h1>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="profilePhoto" accept="image/*">
        <br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
