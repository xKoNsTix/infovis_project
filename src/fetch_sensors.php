<?php
require_once '../config.php';
header('Content-Type: application/json');
$sensor_urls = [
    'energy_total' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_total",
    'energy_current' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_current",
    'temperature_15' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.cotech_367959_104_temperature",
    'light_2' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.light_2",
    // Add more sensors here
];
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to fetch sensor data
function fetchSensorData($sensorUrl)
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

// Fetch and store sensor data individually
global $energy_total_data, $energy_current_data, $temperature_15_data, $light_2_data;
$energy_total_data = fetchSensorData($sensor_urls['energy_total']);
$energy_current_data = fetchSensorData($sensor_urls['energy_current']);
$temperature_15_data = fetchSensorData($sensor_urls['temperature_15']);
$light_2_data = fetchSensorData($sensor_urls['light_2']);

// Reformatting the 'state' values for all sensors
$energy_total_data['state'] = $energy_total_data ? str_replace('.', ',', $energy_total_data['state']) : 'N/A';
$energy_current_data['state'] = $energy_current_data ? str_replace('.', ',', $energy_current_data['state']) : 'N/A';
$temperature_15_data['state'] = $temperature_15_data ? str_replace('.', ',', $temperature_15_data['state']) : 'N/A';
$light_2_data['state'] = $light_2_data ? str_replace('.', ',', $light_2_data['state']) : 'N/A';

// Output the sensor data as JSON
echo json_encode([
    'energy_total' => $energy_total_data['state'],
    'energy_current' => $energy_current_data['state'],
    'temperature_15' => $temperature_15_data['state'],
    'light_2' => $light_2_data['state'],
    // Add more sensor outputs here if needed
]);
