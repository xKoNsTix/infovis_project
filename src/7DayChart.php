<div class="left">
    <h2> Power Consumption Last 7 Days</h2>
    <div class="chart">
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
        <canvas id="energyChart7Days" width="400" height="200"></canvas>
        <script>
            var ctx = document.getElementById('energyChart7Days').getContext('2d');
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
    </div>
</div>
