<?php $sensor_urls = [
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
?>
