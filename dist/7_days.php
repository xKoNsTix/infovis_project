
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
