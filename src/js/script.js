/** @format */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize the gauge
  var energyCurrentGauge = new JustGage({
    id: "energy-current-gauge",
    value: 0,
    min: 0,
    max: 400,
    title: "Aktueller Stromverbrauch",
    label: "Watt pro Stunde",
    valueFontColor: "White",
    // levelColors: ['#03E0FE', '#800080']
  });

  function fetchAndUpdateSensorData() {
    fetch("fetch_sensors.php")
      .then((response) => response.json())
      .then((data) => {
        console.log("Received data:", data); // Debugging line to see what's received

        // Update the gauge for energy current
        var energyCurrentValue = parseFloat(data.energy_current);
        if (!isNaN(energyCurrentValue)) {
          energyCurrentGauge.refresh(energyCurrentValue);
        } else {
          console.error("Invalid energy current value:", data.energy_current);
        }

        // Update the total energy consumption
        document.getElementById("energy-total").innerHTML =
          "Heute im Office verbraucht: " + data.energy_total + " KW";

        // Update the current energy consumption
        document.getElementById("energy-current").innerHTML =
          "Aktueller Stromverbrauch im Office: " + data.energy_current + " Watt pro Stunde";

        // Update the temperature display
        document.getElementById("temperature-value").innerHTML = data.temperature_15 + " °C";

        // Update the light intensity display
        document.getElementById("light-intensity-value").innerHTML = data.light_2 + " lx";
      })
      .catch((error) => console.error("Error fetching sensor data:", error));
  }

  setInterval(fetchAndUpdateSensorData, 1000); // Refresh data every second
  fetchAndUpdateSensorData(); // Initial fetch of sensor data
});
