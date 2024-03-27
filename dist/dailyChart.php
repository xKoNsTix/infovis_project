<?php
// Include your database configuration file
include '../config.php';

// Connect to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming 'datetime' contains the date and time, 'energy_total' the total energy,
// and 'energy_current' the current energy usage
// Fetch today's entries from energy_total_hourly
$query = "SELECT HOUR(datetime) AS hour, energy_total FROM energy_total_hourly WHERE DATE(datetime) = CURDATE()";
$result = $conn->query($query);

$hours = [];
$energy_totals = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $hours[] = $row["hour"];
        $energy_totals[] = $row["energy_total"];
    }
} else {
    echo "0 results";
}
echo '<pre>';
print_r($hours);
print_r($energy_totals);
echo '</pre>';
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Energy Data Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<canvas id="energyChart" width="400" height="200"></canvas>
<script>
    var ctx = document.getElementById('energyChart').getContext('2d');
    var energyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($hours); ?>,
            datasets: [{
                label: 'Hourly Energy Total',
                data: <?php echo json_encode($energy_totals); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
