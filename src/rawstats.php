<?php require 'global.php' ?>
<div class="rawstats">

    <div class="left">
        <div class="slide-in-text-right">
            <div id="energy-total" class="sensor-value">Total Energy Used: <span>Loading...</span></div>
        </div>
        <div class="slide-in-text-bottom">
            <div id="energy-current" class="sensor-value">Current Energy Consumption: <span>Loading...</span></div>
        </div>
    </div>
    <div class="right">
        <div class="slide-in-text-right">
            <div id="temperature-value" class="sensor-value">Current Temperature: <?php echo $currentTemperature; ?> °C</div>
        </div>
        <div class="slide-in-text-right">
            <div id="light-intensity-value" class="sensor-value">Current Light Intensity: <?php echo $currentLightIntensity; ?>  ?> lx<br>
            </div>
            <div class="description"><?php
                                        if ($global_light_2_data === 'N/A') {
                                            echo "Light data is not available at the moment.";
                                        } else if ($global_light_2_data <= 50) {
                                            echo "Nighttime, Baby 🌚";
                                        } else if ($global_light_2_data > 2 && $global_light_2_data <= 5000) {
                                            echo "Dawn or Sunset 🌇";
                                        } else if ($global_light_2_data > 5001 && $global_light_2_data <= 10000) {
                                            echo "Daylight! Let's go outside! 🌞";
                                        } else if ($global_light_2_data > 10001 && $global_light_2_data <= 15000) {
                                            echo "Bloody Hell, use Sunscreen! 🌞";
                                        } else if ($global_light_2_data > 15000 && $global_light_2_data <= 30000) {
                                            echo "Peak Brightness -> Sunglasses! 🌞";
                                        }
                                         else {
                                            echo "Sensor is not working anymore, broke down 23.04.2024 🙈";
                                        }
                                        ?>
            </div>
        </div>
    </div>
</div>
