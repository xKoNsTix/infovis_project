<?php
require_once 'config.php'; // Assuming this contains database or other configuration

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infovis Project</title>
    <link rel="stylesheet" href="style.css">
    <meta name="robots" content="noindex, nofollow">
    <!-- Include Raphael and JustGage -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.4.0/justgage.min.js"></script>

</head>
<body>
    <div class="container">
        <h1>Information Visualisation Project</h1>
        <!-- Empty divs for sensor data, to be filled by JavaScript -->
        <div id="energy-total" class="sensor-value"></div>
        <div id="energy-current" class="sensor-value"></div>
        <!-- Add more divs for other sensors as needed -->
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    function fetchAndUpdateSensorData() {
        fetch('fetch_sensors.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('energy-total').innerHTML = "Heute im Office verbraucht: " + data.energy_total + " KW";
                document.getElementById('energy-current').innerHTML = "Aktueller Stromverbrauch im Office: " + data.energy_current + " Watt pro Stunde";
            })
            .catch(error => console.error('Error fetching sensor data:', error));
    }

    setInterval(fetchAndUpdateSensorData, 5000);
    fetchAndUpdateSensorData();
});
</script>
<div id="energy-current-gauge" class="gauge-container fade-in"></div>


<script src="script.js"></script>
</body>

</html>
