<?php
require_once '../config.php';
require_once 'functions.php';
$dbConnection = getDbConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infovis Project</title>
    <link rel="stylesheet" href="style.css">
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.4.0/justgage.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <link href="https://fonts.googleapis.com/css?family=Oswald:600,700" rel="stylesheet">
    </head>

    <body>
        <div id="section">
            <div id="text">
                <h2>Information Visualisation<br><br><span>Project: Power Consumption</span></h2><br>
            </div>
            <div id="line_r" class="line"></div>
            <div id="line_l" class="line"></div>
            <div class="slide-in-text-left">
                <h1>Hi Konsti!</h1><br>
            </div>
        </div>

        <!-- FIRST 4 VALUES ON TOP -->
        <?php require 'rawstats.php'; ?>

        <!-- GAUGE +7 VALUES -->

        <div class="rawstats">
            <div class="left">
                <p> Live view current usage </p>
                <div id="energy-current-gauge" class="gauge-container fade-in"></div>
            </div>
            <div class="right">
                <p> Last 7 days </p>
                <div class="sevendays">
                    <?php
                    include '7_days.php'; ?>
                </div>
            </div>
        </div>

        <!-- CHART Energy Consumption 7 Days -->
        <div class="sevenDayChart">
            <?php require '7DayChart.php'; ?>
        </div>
        <div class="dailyChart">
            <?php require 'dailyChart.php' ?>
        </div>
        <div class="dailyCurrentChart">
            <?php require 'dailyCurrentChart.php' ?>
        </div>
        <script src="script.js"></script>
    </body>

</html>
