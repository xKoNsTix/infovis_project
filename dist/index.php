<?php
require_once '../config.php'; // Assuming this contains database or other configuration

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

</head>

<body>
    <link href="https://fonts.googleapis.com/css?family=Oswald:600,700" rel="stylesheet">
    </head>

    <body>
        <div id="section">
            <div id="text">
                <h2>Information Visualisation<br><span>Project: Power Consumption</span></h2>
            </div>
            <div id="line_r" class="line"></div>
            <div id="line_l" class="line"></div>
        </div>
        <div id="energy-total" class="sensor-value"></div>
        <div id="energy-current" class="sensor-value"></div>
        <div id="energy-current-gauge" class="gauge-container fade-in"></div>


        <script src="script.js"></script>
    </body>

</html>
