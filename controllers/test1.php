<html>
<head>
    <title>Incomes in LBP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">
    <style>
        .file-input-container {
            display: inline-block;
            position: relative;
            cursor: pointer;
        }

        .file-input {
            display: none;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f2f2f2;
            color: #888;
            font-size: 20px;
        }

        .file-name {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Incomes in LBP</h1>

    <label for="file-upload" class="file-upload-label">
        <div class="file-input-container">
            <input id="file-upload" class="file-input" type="file" accept="application/pdf" name="attachment[]" onchange="displaySelectedFileName(this)">
            <i class="fas fa-cloud-upload-alt"></i>
        </div>
    </label>
    <div id="file-name" class="file-name"></div>

    <script>
        function displaySelectedFileName(input) {
            var fileName = input.files[0].name;
            var fileNameElement = document.getElementById("file-name");
            fileNameElement.textContent = fileName;
        }
    </script>
</body>
</html>










