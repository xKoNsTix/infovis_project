
<?php
require_once '../config.php';
require_once 'fetch_sensor_data.php';
header('Content-Type: application/json');
$sensor_urls = [
    'energy_total' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_total",
    'energy_current' => "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_current",


    // Add more sensors here
];
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to fetch sensor data

// Fetch and store sensor data individually
$energy_total_data = fetchSensorData($sensor_urls['energy_total']);
if ($energy_total_data) {
    // Reformat the 'state' value for energy_total_data
    $energy_total_data['state'] = str_replace('.', ',', $energy_total_data['state']);
}

$energy_current_data = fetchSensorData($sensor_urls['energy_current']);
if ($energy_current_data) {
    // Reformat the 'state' value for energy_current_data
    $energy_current_data['state'] = str_replace('.', ',', $energy_current_data['state']);
}


// Repeat for other sensors




// Output the sensor data as JSON
header('Content-Type: application/json');
echo json_encode([
    'energy_total' => $energy_total_data['state'] ?? 'N/A',
    'energy_current' => $energy_current_data['state'] ?? 'N/A',
    // Add more sensor outputs here if needed
]);


