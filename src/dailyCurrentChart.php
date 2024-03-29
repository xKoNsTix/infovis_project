<?php
// Include your database configuration file
include_once '../config.php';

// Connect to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT HOUR(datetime) AS hour, energy_current FROM energy_total_hourly WHERE DATE(datetime) = CURDATE()";
$result = $conn->query($query);

$hours = [];
$energy_currents = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $hours[] = $row["hour"];
        $energy_currents[] = $row["energy_current"];
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Energy Data Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h2>Today`s Snapshots</h2>
    <canvas id="energyChartDailyCurrent" width="400" height="200"></canvas>
    <script>
        var ctx = document.getElementById('energyChartDailyCurrent').getContext('2d');
        var energyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($hours); ?>,
                datasets: [{
                    label: 'Hourly Energy Current',
                    data: <?php echo json_encode($energy_currents); ?>,
                    backgroundColor: [
                        'rgba(35, 35, 35, 0.2)',
                    ],
                    borderColor: [
                        'rgba(0, 255, 255, 1)',
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'white', // Set grid lines to white
                        },
                        ticks: {
                            color: 'white', // Set y-axis tick labels to white
                            font: {
                                family: "'Oswald', sans-serif", // Set font family
                                size: 14 // Set font size
                            },
                            // Custom callback function to append 'kW' to the tick values
                            callback: function(value, index, values) {
                                return value + 'w';
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'white', // Set grid lines to white
                        },
                        ticks: {
                            color: 'white', // Set x-axis tick labels to white
                            font: {
                                family: "'Oswald', sans-serif", // Set font family
                                size: 14 // Set font size
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' // Set legend text to white
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
