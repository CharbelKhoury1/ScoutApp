<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../views/css/profile.css">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">
    <script>
        function handleFileSelect(evt) {
            var file = evt.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-photo').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        
        function openFileSelect() {
            document.getElementById('file-upload').click();
        }
    </script>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h2>User Profile</h2>
            <div class="card-options">
                <a href="../controllers/editController.php" class="button">Edit</a>
                <a href="../controllers/logout.php" class="button">Logout</a>
            </div>
        </div>
        <div class="profile-details">
            <div class="card-row">
                <div class="profile-photo" onclick="openFileSelect()">
                    <?php if (!empty($userProfilePhoto)) : ?>
                        <img id="profile-photo" src="<?php echo $userProfilePhoto; ?>" alt="Profile Photo" style="height: 150px; width: 150px;">
                    <?php else : ?>
                        <img id="profile-photo" src="..\views\images\profile.png"  style="height: 150px; width: 150px;">
                    <?php endif; ?>
                    <div class="change-profile-note">Click on the photo to <br>change it</div>
                </div>
                <div class="details">
                    <h3>Regiment (الفوج): <?php echo isset($regimentName) ? $regimentName : ''; ?></h3>
                    <h3>Unit (الفرقة): <?php echo isset($unitName) ? $unitName : ''; ?></h3>
                    <h3><?php echo isset($title) ? $title : ''; ?></h3>
                    <h3><?php echo isset($rankName) ? $rankName : ''; ?></h3>
                </div>
            </div>
            <div class="card-row">
                <input id="file-upload" type="file" name="profilePhoto" accept="image/*" onchange="handleFileSelect(event);">
            </div>
            <div class="card-row">
                <table>
                    <tr>
                        <th><i class="fa fa-user" aria-hidden="true"></i> First Name</th>
                        <td><?php echo isset($firstName) ? $firstName : ''; ?></td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-user-circle" aria-hidden="true"></i> Last Name</th>
                        <td><?php echo isset($lastName) ? $lastName : ''; ?></td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-envelope" aria-hidden="true"></i> Email</th>
                        <td><a href="mailto:<?php echo isset($email) ? $email : ''; ?>"><?php echo isset($email) ? $email : ''; ?></a></td>
                    </tr>
                    <tr>
                        <th><i class="fa fa-mobile" aria-hidden="true"></i> Phone</th>
                        <td><?php echo isset($phone) ? $phone : ''; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>









