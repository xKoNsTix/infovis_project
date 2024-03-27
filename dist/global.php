<?php
require_once '../config.php';

// Renaming sensor URLs array to avoid conflicts
$global_sensor_urls = [
    'energy_total' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_total",
    'energy_current' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_current",
    'temperature_15' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.temperature_15",
    'light_2' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.light_2",
    // Add more sensors here
];
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to fetch sensor data, kept as is since it's a reusable function
function fetchGlobalSensorData($sensorUrl)
{
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

// Declaring global variables to store the fetched sensor data
global $global_energy_total_data, $global_energy_current_data, $global_temperature_15_data, $global_light_2_data;

$global_energy_total_data = fetchGlobalSensorData($global_sensor_urls['energy_total']);
$global_energy_current_data = fetchGlobalSensorData($global_sensor_urls['energy_current']);
$global_temperature_15_data = fetchGlobalSensorData($global_sensor_urls['temperature_15']);
$global_light_2_data = fetchGlobalSensorData($global_sensor_urls['light_2']);

// Convert the 'state' values to strings, applying formatting as necessary
$global_energy_total_data = is_array($global_energy_total_data) ? str_replace('.', ',', (string)$global_energy_total_data['state']) : 'N/A';
$global_energy_current_data = is_array($global_energy_current_data) ? str_replace('.', ',', (string)$global_energy_current_data['state']) : 'N/A';
$global_temperature_15_data = is_array($global_temperature_15_data) ? str_replace('.', ',', (string)$global_temperature_15_data['state']) : 'N/A';
$global_light_2_data = is_array($global_light_2_data) ? str_replace('.', ',', (string)$global_light_2_data['state']) : 'N/A';

// No output as per your request. You can use these global variables directly in your PHP code.
?>
