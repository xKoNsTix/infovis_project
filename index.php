<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My PHP Project</title>
    <!-- Link to CSS files, JS, and other assets if needed -->
</head>

<body>
    <h1>Welcome to My PHP Project</h1>
    <p>This is a basic PHP project structure.</p>

    <!-- You can insert PHP anywhere in your HTML to dynamically generate content -->
    <?php
    echo '<p>Current Time: ' . date('Y-m-d H:i:s') . '</p>';
    ?>
    <?php
    // Home Assistant API URL for a specific sensor
    $ha_url = "https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/sensor.energy_total";

    // Setup curl
    $ch = curl_init($ha_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiIzMjZlMDAxMzkzZTg0NmZmOTJiNDRhNjQ0MzBiNDQwNCIsImlhdCI6MTcxMDA4ODI0MywiZXhwIjoyMDI1NDQ4MjQzfQ.M7NzoyedG2_tnHC3KlRdTVY2mbVFz8fC4ByzVrJAZV4
    ',
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        // Handle error; for example:
        echo 'Error:' . curl_error($ch);
    } else {
        // Decode the JSON response
        $sensor_data = json_decode($response, true);


        // Display the sensor value
        // Adjust 'state' or other keys based on your sensor data
        echo "Sensor Value: " . $sensor_data['state'];
    }

    // Close curl
    curl_close($ch);
    ?>

</body>

</html>

