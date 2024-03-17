/** @format */

// document.addEventListener("DOMContentLoaded", function () {
//   // Initialize the gauge
//   var energyCurrentGauge = new JustGage({
//     id: "energy-current-gauge",
//     value: 0,
//     min: 0,
//     max: 400,
//     title: "Aktueller Stromverbrauch",
//     label: "Watts/Hour",
//     valueFontColor: "White",
//     // levelColors: ['#03E0FE', '#800080']
//   });
document.addEventListener("DOMContentLoaded", function () {
  // Initialize the gauge
  var energyCurrentGauge = new JustGage({
    id: "energy-current-gauge",
    value: 0,
    min: 0,
    max: 400,
    title: "Current Power Consumption",
    label: "Watts/Hour",
    valueFontColor: "#fff",
    gaugeColor: "#6f42c1",
    levelColors: ['#00b8d4', '#ffec99', '#ff9900'],
    customSectors: [{
      color: "#ff2e63",
      lo: 0,
      hi: 100
    }, {
      color: "#ff6b6b",
      lo: 101,
      hi: 200
    }, {
      color: "#ffa500",
      lo: 201,
      hi: 300
    }, {
      color: "#20c997",
      lo: 301,
      hi: 400
    }]
  });
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
          "Total Consumption Today:  " + data.energy_total + " KW";

        // Update the current energy consumption
        document.getElementById("energy-current").innerHTML =
          "Current Consumption Office: " + data.energy_current + " Watts/Hour";

        // Update the temperature display
        document.getElementById("temperature-value").innerHTML = "Temperature Outside: " + data.temperature_15 + " °C";

        // Update the light intensity display
        document.getElementById("light-intensity-value").innerHTML = "Light intensity outside: " + data.light_2 + " lx";
      })
      .catch((error) => console.error("Error fetching sensor data:", error));
  }

  setInterval(fetchAndUpdateSensorData, 1000); // Refresh data every second
  fetchAndUpdateSensorData(); // Initial fetch of sensor data
});
