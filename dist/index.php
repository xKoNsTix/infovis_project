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
                <h2>Information Visualisation<br><span>Project: Power Consumption</span></h2>
            </div>
            <div id="line_r" class="line"></div>
            <div id="line_l" class="line"></div>
        </div>
        <div id="energy-total" class="sensor-value"></div>
        <div id="energy-current" class="sensor-value"></div>
        <div id="energy-current-gauge" class="gauge-container fade-in"></div>


        <!-- 7 VALUES -->

        <!-- 7 VALUES -->
        <?php
        $dbConnection = getDbConnection();
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

        // Close the database connection
        $dbConnection->close();
        ?>

        <!-- CHART -->
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
                type: 'line', // or 'bar' for a bar chart
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Daily Energy Total (KWH)',
                        data: energyTotals,
                        backgroundColor: 'rgba(128, 0, 128, 0.2)', // Light purple fill
                        borderColor: 'rgba(128, 0, 128, 1)', // Purple line
                        borderWidth: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'white', // White grid lines
                                borderWidth: 0.5, // Adjust for y-axis grid lines

                            }
                        },
                        x: {
                            grid: {
                                color: 'white', // White grid lines
                                borderWidth: 0.5, // Adjust for y-axis grid lines

                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 50, // Left margin
                            right: 50, // Right margin
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                // This more specific font color setting will apply
                                color: 'white', // White text for legend
                                size: 20, // Increase font size
                                family: "'Oswald', sans-serif" // Set font family
                            }
                        }
                    }
                }
            });
        </script>

        <script src="script.js"></script>
    </body>

</html>
