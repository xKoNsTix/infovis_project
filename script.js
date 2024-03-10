//gauge current consumption

document.addEventListener('DOMContentLoaded', function() {
    // Initialize the gauge
    var energyCurrentGauge = new JustGage({
        id: "energy-current-gauge",
        value: 0,
        min: 0,
        max: 500,
        title: "Aktueller Stromverbrauch",
        label: "Watt pro Stunde"
    });

    function fetchAndUpdateSensorData() {
        fetch('fetch_sensors.php')
            .then(response => response.json())
            .then(data => {
                console.log("Received data:", data); // Debugging line to see what's received

                // Attempt to parse the energy current value as a float
                var energyCurrentValue = parseFloat(data.energy_current);
                console.log("Parsed energy current value:", energyCurrentValue); // Check the parsed value

                // Update the gauge only if the parsed value is a number
                if (!isNaN(energyCurrentValue)) {
                    energyCurrentGauge.refresh(energyCurrentValue);
                } else {
                    console.error("Invalid energy current value:", data.energy_current);
                }

                // Update other elements as before
                document.getElementById('energy-total').innerHTML = "Heute im Office verbraucht: " + data.energy_total + " KW";
                document.getElementById('energy-current').innerHTML = "Aktueller Stromverbrauch im Office: " + data.energy_current + " Watt pro Stunde";
            })
            .catch(error => console.error('Error fetching sensor data:', error));
    }

    setInterval(fetchAndUpdateSensorData, 1000);
    fetchAndUpdateSensorData();
});


