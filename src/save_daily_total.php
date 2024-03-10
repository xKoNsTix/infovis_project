<?php
// this file saves the end value of each day into the online db.

require_once '../config.php';
require_once './fetch_sensors.php';

// Fetch the total value from the sensor
$energy_total_data = fetchSensorData($sensor_urls['energy_total']);

// Check if the fetched data is not null and the 'state' key is set
if ($energy_total_data !== null && isset($energy_total_data['state'])) {
    // Connect to the database
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the total value into the database
    $sql = "INSERT INTO daily_energy_totals (date, energy_total) VALUES (CURDATE(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $energy_total_data['state']);
    $stmt->execute();
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Output success message
    echo "Successfully fetched and inserted energy_total value: " . $energy_total_data['state'] . PHP_EOL;
} else {
    // Output error message
    echo "Error: No valid 'energy_total' value fetched from the sensor." . PHP_EOL;
}
