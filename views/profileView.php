<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../views/css/profile.css">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">

</head>
<body>
    <div class="card">
        <div class="card-header">
            <h2>User Details</h2>
            <div class="card-options">
                <a href="../controllers/editController.php" class="button">Edit</a>
                <a href="#" class="button">Logout</a>
            </div>
        </div>
        <table>
        <h3><?php echo isset($title) ? $title : ''; ?></h3>
            <tr>
                <th><i class="fa fa-user" aria-hidden="true"></i> First Name</th>
                <td><?php echo isset($firstName) ? $firstName : ''; ?></td>
            </tr>
            <tr>
                <th><i class="fa fa-user-circle" aria-hidden="true"></i>Last Name</th>
                <td><?php echo isset($lastName) ? $lastName : ''; ?></td>
            </tr>
            <tr>
                <th><i class="fa fa-envelope" aria-hidden="true"></i> Email</th>
                <td><a href="mailto:<?php echo isset($email) ? $email : ''; ?>"><?php echo isset($email) ? $email : ''; ?></a></td>
            </tr>
            <tr>
                <th><i class="fa fa-mobile" aria-hidden="true"></i> Phone</th>
                <td><?php echo isset($phone) ? $phone : ''; ?></a></td>
            </tr>
        </table>
    </div>
</body>
</html>j




