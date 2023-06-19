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
    <link rel="stylesheet" href="../views/css/showTransaction.css">
    <link rel="icon" href="../Pictures/ScoutsLogo.gif" type="image/png">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <title>Balance View</title>
</head>
<body>
<h1>Transaction Details</h1>
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
<div class="container">
    <form id="balance-form">
        <label for="type-code" class="label1">Select Type:<br> (اختر النوع)</label>
        <select id="type-code" name="type-code" disabled class="select-element">
            <option value="0">Income (مداخيل)</option>
            <option value="1">Expense (مصاريف)</option>
        </select>
        <span class="error-message" id="type-error"></span>

        <label for="currency-code" class="label1">Select Currency: (اختر العملة)</label>
        <select id="currency-code" name="currency-code" disabled class="select-element">
            <option value="0">LBP (ل.ل.)</option>
            <option value="1">USD ($)</option>
        </select>
        <span class="error-message" id="currency-error"></span>

        <button type="submit">Submit</button>
    </form>
    <div id="transaction-table"></div>
    <script src="../views/javascript/showTransaction.js"></script>
</div>
<script src="../views/javascript/showBalance.js"></script>
</body>
</html>



