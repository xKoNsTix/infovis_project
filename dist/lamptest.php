<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Lamp</title>
    <style>
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<?php
require_once '../config.php'; // Assuming this file contains the HOME_ASSISTANT_TOKEN

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get current state of the light
    $url_current_state = 'https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/states/light.routerregal';
    $ch_current_state = curl_init($url_current_state);
    curl_setopt($ch_current_state, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_current_state, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . HOME_ASSISTANT_TOKEN // Add a space after 'Bearer'
    ));
    $current_state_json = curl_exec($ch_current_state);
    curl_close($ch_current_state);

    $current_state = json_decode($current_state_json, true);
    $current_color = isset($current_state['attributes']['rgb_color']) ? $current_state['attributes']['rgb_color'] : [255, 255, 255]; // Default to white if color info is not available

    // Turn on the light and set it to purple
    $url_purple = 'https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/services/light/turn_on';
    $data_purple = array("entity_id" => "light.routerregal", "rgb_color" => [128, 0, 128]); // Purple color
    $data_string_purple = json_encode($data_purple);

    $ch_purple = curl_init($url_purple);
    curl_setopt($ch_purple, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch_purple, CURLOPT_POSTFIELDS, $data_string_purple);
    curl_setopt($ch_purple, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_purple, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string_purple),
        'Authorization: Bearer ' . HOME_ASSISTANT_TOKEN
    ));

    $result_purple = curl_exec($ch_purple);
    curl_close($ch_purple);

    // Delay for 1 second before blinking
    sleep(1);

    // Make the light blink twice
    $url_blink = 'https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/services/light/turn_on';
    $data_blink = array("entity_id" => "light.routerregal", "flash" => "short");
    $data_string_blink = json_encode($data_blink);

    $ch_blink = curl_init($url_blink);
    curl_setopt($ch_blink, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch_blink, CURLOPT_POSTFIELDS, $data_string_blink);
    curl_setopt($ch_blink, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_blink, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string_blink),
        'Authorization: Bearer ' . HOME_ASSISTANT_TOKEN // Add a space after 'Bearer'
    ));

    $result_blink = curl_exec($ch_blink);
    curl_close($ch_blink);

    // Delay for 2 seconds before turning off
    sleep(2);

    // Turn off the light
    $url_return_color = 'https://33d73ipserxnyyj9weae3lcmpoxx8omm.ui.nabu.casa/api/services/light/turn_on';
    $data_return_color = array("entity_id" => "light.routerregal", "rgb_color" => $current_color);
    $data_string_return_color = json_encode($data_return_color);

    $ch_return_color = curl_init($url_return_color);
    curl_setopt($ch_return_color, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch_return_color, CURLOPT_POSTFIELDS, $data_string_return_color);
    curl_setopt($ch_return_color, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_return_color, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string_return_color),
        'Authorization: Bearer ' . HOME_ASSISTANT_TOKEN 
    ));

    $result_return_color = curl_exec($ch_return_color);
    curl_close($ch_return_color);

    echo "<p>Lamp turned purple and blinked twice, then returned to its original color.</p>";
}

?>

<form method="post">
    <button class="button" type="submit">Turn Lamp Purple & Blink Twice</button>
</form>

</body>
</html>
