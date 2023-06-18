<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../views/css/editProfile.css">

    <style>
        .alert-box {
            position: fixed;
            top: 5%;
            right: 20px;
            transform: translateY(-50%);
            padding: 10px;
            background-color: lightgreen; /* Lighter shade of green */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: none;
        }
        
        .alert {
            border: 1px solid red;
        }
    </style>

    <script>
        // JavaScript to show and hide the alert box
        document.addEventListener('DOMContentLoaded', function () {
            var alertBox = document.querySelector('.alert-box');
            if (alertBox) {
                alertBox.style.display = 'block';
                setTimeout(function () {
                    alertBox.style.display = 'none';
                }, 5000); // Hide the alert box after 5 seconds (5000 milliseconds)
            }

            // Validate phone number format
            function validatePhoneNumber(phoneNumber) {
                // Regular expression to match phone number format
                var phoneNumberPattern = /^\d+$/;
                return phoneNumberPattern.test(phoneNumber);
            }

            // Handle form submission
            var form = document.querySelector('form');
            var phoneNumberInput = document.querySelector('#mobile');

            form.addEventListener('submit', function (event) {
                var phoneNumber = phoneNumberInput.value;
                if (!validatePhoneNumber(phoneNumber)) {
                    event.preventDefault();
                    phoneNumberInput.classList.add('alert');
                    alert('Please enter a valid phone number (numeric digits only).');
                } else {
                    phoneNumberInput.classList.remove('alert');
                }
            });
        });
    </script>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h2>Edit User Details</h2>
            <div>
                <form method="POST" action="../controllers/updateProfileController.php">
                    <button type="submit" class="button" name="save">Save</button>
                    <a href="../controllers/profileController.php" class="button cancel">Cancel</a>
                </div>
            </div>
            <table>
                <tr>
                    <td>
                        <label for="landline">Landline</label>
                        <input type="text" id="landline" name="landline" value="<?php echo isset($landline) ? $landline : ''; ?>" required>
                    </td>
                    <td>
                        <label for="mobile">Mobile</label>
                        <input type="text" id="mobile" name="mobile" value="<?php echo isset($mobile) ? $mobile : ''; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="fatherJob">Father's Job</label>
                        <input type="text" id="fatherJob" name="fatherJob" value="<?php echo isset($fatherJob) ? $fatherJob : ''; ?>" required>
                    </td>
                    <td>
                        <label for="motherJob">Mother's Job</label>
                        <input type="text" id="motherJob" name="motherJob" value="<?php echo isset($motherJob) ? $motherJob : ''; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="fatherMobile">Father's Mobile</label>
                        <input type="text" id="fatherMobile" name="fatherMobile" value="<?php echo isset($fatherMobile) ? $fatherMobile : ''; ?>" required>
                    </td>
                    <td>
                        <label for="motherMobile">Mother's Mobile</label>
                        <input type="text" id="motherMobile" name="motherMobile" value="<?php echo isset($motherMobile) ? $motherMobile : ''; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="education">Education</label>
                        <input type="text" id="education" name="education" value="<?php echo isset($education) ? $education : ''; ?>" required>
                    </td>
                    <td>
                        <label for="job">Job</label>
                        <input type="text" id="job" name="job" value="<?php echo isset($job) ? $job : ''; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="medicalCondition">Medical Condition</label>
                        <input type="text" id="medicalCondition" name="medicalCondition" value="<?php echo isset($medicalCondition) ? $medicalCondition : ''; ?>" required>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
    if (!empty($msg)) {
        echo '<div class="alert-box">' . $msg . '</div>';
    }
    ?>
</body>
</html>










