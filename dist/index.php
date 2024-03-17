<?php
require_once '../config.php';
require_once 'functions.php';
$dbConnection = getDbConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infovis Project</title>
    <link rel="stylesheet" href="style.css">
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/justgage/1.4.0/justgage.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <link href="https://fonts.googleapis.com/css?family=Oswald:600,700" rel="stylesheet">
    </head>

    <body>
        <div id="section">
            <div id="text">
                <h2>Information Visualisation1<br><span>Project: Power Consumption</span></h2>
            </div>
            <div id="line_r" class="line"></div>
            <div id="line_l" class="line"></div>
        </div>

        <div class="slide-in-text-left">
            <h1>Hi Konsti!</h1>
        </div>
        <div class="slide-in-text-right">
            <div id="energy-total" class="sensor-value">Total Energy Used: <span>Loading...</span></div>
        </div>
        <div class="slide-in-text-right">
            <div id="temperature-value" class="sensor-value">Current Temperature: <?php echo $currentTemperature; ?> °C</div>
        </div>
        <div class="slide-in-text-right">
            <div id="light-intensity-value" class="sensor-value">Current Light Intensity: <?php echo $currentLightIntensity; ?> lx</div>
        </div>
        <div class="slide-in-text-bottom">
            <div id="energy-current" class="sensor-value">Current Energy Consumption: <span>Loading...</span></div>
        </div>
        <div id="energy-current-gauge" class="gauge-container fade-in"></div>


        <!-- 7 VALUES -->
        <div class="sevendays">
            <?php

            // Fetch the latest 7 values from the daily_energy_totals table
            $query = "SELECT DATE_FORMAT(date, '%d/%m/%Y') AS formatted_date, energy_total FROM daily_energy_totals ORDER BY date DESC LIMIT 7";
            $result = $dbConnection->query($query);

            // Check if there are any results
            if ($result && $result->num_rows > 0) {
                echo '<div id="energy-current-gauge" class="gauge-container fade-in">';

                // Loop through the fetched data
                while ($row = $result->fetch_assoc()) {
                    // Display each energy total value with custom font color and size
                    echo '<div class="energy-value" style="color: #ffffff; font-size: 24px; margin-top:20px;">' . $row['formatted_date'] . ': ' . $row['energy_total'] . ' KWH </div>';
                }

                echo '</div>'; // Close gauge-container div
            } else {
                echo "No data available.";
            }
            $dbConnection->close();
            ?>
        </div>
        <!-- CHART Energy Consumption 7 Days -->
        <script>
            var dates = [];
            var energyTotals = [];
            <?php
            // Move the result pointer to the beginning
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                echo "dates.push('" . $row['formatted_date'] . "');\n";
                // Ensure the energy total is correctly formatted as a number
                echo "energyTotals.push(" . floatval(str_replace(',', '.', $row['energy_total'])) . ");\n";
            }
            ?>
            dates.reverse(); // Make sure oldest dates are on the left
            energyTotals.reverse(); // Ensure the energy totals match the dates order
        </script>
        <canvas id="energyChart" width="400" height="200"></canvas>
        <script>
            var ctx = document.getElementById('energyChart').getContext('2d');
            var energyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Daily Energy Total (KWH)',
                        data: energyTotals,
                        backgroundColor: 'rgba(128, 0, 128, 0.2)',
                        borderColor: 'rgba(3, 224, 254, 1)',
                        borderWidth: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'white',
                                borderWidth: 0.5,
                            },
                            ticks: {
                                color: 'white', // Change font color of y-axis labels
                                font: {
                                    family: "'Oswald', sans-serif", // Set font family
                                    size: 14 // Set font size
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'white',
                                borderWidth: 0.5,
                            },
                            ticks: {
                                color: 'white', // Change font color of x-axis labels
                                font: {
                                    family: "'Oswald', sans-serif", // Set font family
                                    size: 14 // Set font size
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 50,
                            right: 50,
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white',
                                size: 20,
                                family: "'Oswald', sans-serif"
                            }
                        }
                    }
                }
            });
        </script>
        <script>
    var dates = [];
    var energyTotals = [];
    var energyCurrents = [];
    <?php
    // Assuming $result is already fetched with data including both energy_total and energy_current
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
        echo "dates.push('" . $row['datetime'] . "');\n"; // Use the correct column name for datetime
        // Ensure the energy values are correctly formatted as numbers
        echo "energyTotals.push(" . floatval(str_replace(',', '.', $row['energy_total'])) . ");\n";
        echo "energyCurrents.push(" . floatval(str_replace(',', '.', $row['energy_current'])) . ");\n";
    }
    ?>
    dates.reverse(); // Ensure the oldest dates are on the left
    energyTotals.reverse(); // Match the energy totals with the dates order
    energyCurrents.reverse(); // Match the energy currents with the dates order
</script>
<canvas id="energyChart" width="400" height="200"></canvas>
<script>
    var ctx = document.getElementById('energyChart').getContext('2d');
    var energyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Daily Energy Total (KWH)',
                data: energyTotals,
                backgroundColor: 'rgba(128, 0, 128, 0.2)',
                borderColor: 'rgba(3, 224, 254, 1)',
                borderWidth: 4
            }, {
                label: 'Daily Energy Current (W)',
                data: energyCurrents,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'white',
                        borderWidth: 0.5,
                    },
                    ticks: {
                        color: 'white',
                        font: {
                            family: "'Oswald', sans-serif",
                            size: 14
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'white',
                        borderWidth: 0.5,
                    },
                    ticks: {
                        color: 'white',
                        font: {
                            family: "'Oswald', sans-serif",
                            size: 14
                        }
                    }
                }
            },
            layout: {
                padding: {
                    left: 50,
                    right: 50,
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'white',
                        size: 20,
                        family: "'Oswald', sans-serif"
                    }
                }
            }
        }
    });
</script>
        <script src="script.js"></script>
    </body>

</html>
