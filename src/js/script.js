/** @format */

document.addEventListener("DOMContentLoaded", function () {
  // Initialize the gauge
  var energyCurrentGauge = new JustGage({
    id: "energy-current-gauge",
    value: 0,
    min: 0,
    max: 400,
    title: "Aktueller Stromverbrauch",
    label: "Watts/Hour",
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
        // document.getElementById("energy-total").innerHTML =
        // "Total Consumption Today:  " + data.energy_total + " KW";

        document.getElementById("energy-total").innerHTML = (function () {
          var energyTotalElement = document.getElementById("energy-total");
          if (energyTotalElement) {
              // Ensure data.energy_total is a number, replacing comma with dot for proper parsing
              var energyTotalValue = parseFloat(data.energy_total.replace(',', '.'));
              if (isNaN(energyTotalValue)) {
                  console.error("Energy total value is not a valid number.");
                  return "Total Consumption Today: Invalid data";
              }
              // Assuming the energy total value is in kilowatts and we need it in watts for the calculation
              energyTotalValue *= 1000; // Convert kW to Watts if necessary
              // Ensure the display value is always shown with two decimal places and uses a comma as the decimal separator
              var formattedEnergyTotalValue = (energyTotalValue / 1000).toFixed(2).replace('.', ',');
              // Calculate euro cent value assuming the same rate of 0.3 euro cents per watt-hour
              var euroCentValueTotal = ((energyTotalValue * 0.3) / 1000).toFixed(2).replace('.', ',');
              return (
                  "Total Consumption Today: " +
                  formattedEnergyTotalValue +
                  " KW<br> = " +
                  '<span class="euro-cent-value" style="color: #00ff00; font-size:24px;">(' +
                  euroCentValueTotal +
                  " €)</span>"
              );
          } else {
              console.error("Element with id 'energy-total' not found.");
              return ""; // Return an empty string or any appropriate fallback message
          }
      })();




        // Update the current energy consumption
        var energyCurrentElement = document.getElementById("energy-current");
        if (energyCurrentElement) {
          var euroCentValue = ((energyCurrentValue * 0.3) / 1000).toFixed(2); // Calculate euro cent value
          energyCurrentElement.innerHTML =
            "Current Consumption Office: " +
            energyCurrentValue +
            " Watts/Hour = " +
            '<span class="euro-cent-value" style="color: #00ff00; font-size:24px;">(' +
            euroCentValue +
            " €/h)</span>";
        } else {
          console.error("Element with id 'energy-current' not found.");
        }

        // Update the temperature display
        document.getElementById("temperature-value").innerHTML =
          "Temperature Outside: " + data.temperature_15 + " °C";

        // Update the light intensity display
        document.getElementById("light-intensity-value").innerHTML =
          "Light intensity outside: " + data.light_2 + " lx <br>";
      })
      .catch((error) => console.error("Error fetching sensor data:", error));
  }

  setInterval(fetchAndUpdateSensorData, 1000); // Refresh data every second
  fetchAndUpdateSensorData(); // Initial fetch of sensor data
});
