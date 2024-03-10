<?php
require_once 'config.php';
require_once 'fetch_sensors.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infovis Project</title>
    <link rel="stylesheet" href="style.css">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
    <div class="container">
        <h1>Welcome to infovisproject</h1>
        <?php

                // Display sensor data
        if ($energy_total_data) {
            echo "<div class='sensor-value'>Heute im Office verbraucht: " . $energy_total_data['state'] . " KW</div>";
        }
        if ($energy_current_data) {
            echo "<div class='sensor-value'>Aktueller Stromverbrauch im Office: " . $energy_current_data['state'] . " Watt pro Stunde</div>";
        }
        // Repeat for other sensors
        ?>
    </div>
</body>
</html>
