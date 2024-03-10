<?php
require_once 'config.php'?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infovis Project
    </title>
    <!-- Link to CSS files, JS, and other assets if needed -->
    <meta name="robots" content="noindex, nofollow">
</head>

<body>
    <h1>Welcome to infovisproject</h1>
    <?php

// Sensor URLs
$sensor_urls = [
    'energy_total' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_total",
    'energy_current' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_current",
    // Add more sensors here
];

// Function to fetch sensor data
function fetchSensorData($sensorUrl) {
    $ch = curl_init($sensorUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . HOME_ASSISTANT_TOKEN,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        $sensor_data = json_decode($response, true);
        return $sensor_data;
    }

    curl_close($ch);
}

// Iterate over sensor URLs and display data
foreach ($sensor_urls as $sensor_name => $sensor_url) {
    $sensor_data = fetchSensorData($sensor_url);
    if ($sensor_data) {
        echo "Sensor Value for $sensor_name: " . $sensor_data['state'] . "kw/h" . "\n";
    }
}
?>



</body>

</html>
