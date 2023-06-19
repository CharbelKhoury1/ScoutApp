<?php
include("../models/UnitsRegiments.php");
$regiments = getAllRegimentNames();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../views/css/regimentUnit.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <title>Balance View</title>
</head>
<body>
<div class="select-container">
    <label class="select-label">Select Regiment: <br> (اختر الفوج)</label>
    <select id="regimentSelect" onchange="populateUnits()" class="select-element">
        <option value="">Select Regiment</option>
        <?php foreach ($regiments as $regiment) {
            $regimentName = $regiment['name'];
            $regimentId = $regiment['regiment_id'];
            echo "<option data-regiment-id=\"$regimentId\">$regimentName</option>";
        } ?>
    </select>

    <label class="select-label">Select Unit: <br> (اختر الفرقة)</label>
    <select id="unitSelect" disabled class="select-element">
        <option value="">Select Unit</option>
    </select>
</div>
<div class="chart-container-wrapper">
    <div id="chartContainerLBP" style="display: none;">
        <canvas id="chartLBP"></canvas>
    </div>
    <div id="chartContainerUSD" style="display: none;">
        <canvas id="chartUSD"></canvas>
    </div>
</div>
<script src="../views/javascript/showBalance.js"></script>
</script>
</body>
</html>

