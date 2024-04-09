<?php include_once '../config.php'; ?>

<div class="first fade-in">
    <p> Okay lets see ... </p>
    <p> Today you used <?php echo $global_energy_total_data; ?> KWH of energy. </p>
    <div style="text-align: center;"> <!-- Center align the content -->
        <p> This means you got <span class="euro-value" style="color:#01ff00;"><?php echo number_format((float)$global_energy_total_data * 0.3, 2, '.', ''); ?> €</span> from the government!<br><br></p>
        <iframe src="https://giphy.com/embed/3o751XDbTvZw958ZYk" width="240" height="180" frameBorder="0" class="giphy-embed" allowFullScreen style="display: inline-block; margin: 0 auto;"></iframe> <!-- Inline-block display and auto margin for centering -->
        <p style="text-align: center;"><a href="https://giphy.com/gifs/timanderic-money-cryptocurrency-3o751XDbTvZw958ZYk">via GIPHY</a></p> <!-- Center align the link -->
    </div>
</div>
<?php
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch highest temperature recorded for today
$dateToday = date('Y-m-d');
$sql = "SELECT MAX(temperature) AS max_temperature FROM weather WHERE DATE(datetime) = '$dateToday'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $highestTempToday = $row["max_temperature"];
    echo "Highest temperature recorded today: " . $highestTempToday;
} else {
    echo "No temperature records found for today";
}

// Close connection
$conn->close();
?>



<div class="second fade-in">
    <p> Okay lets see ... </p>
    <p> Today's max-temperature was: <?php echo $highestTempToday; ?> °C. </p>
    <div style="text-align: center;"> <!-- Center align the content -->
        <p> This means you got <span class="euro-value" style="color:#01ff00;"><?php echo number_format((float)$global_energy_total_data * 0.3, 2, '.', ''); ?> €</span> from the government!<br><br></p>
        <iframe src="https://giphy.com/embed/XreQmk7ETCak0" width="240" height="180" frameBorder="0" class="giphy-embed" allowFullScreen style="display: inline-block; margin: 0 auto;"></iframe> <!-- Inline-block display and auto margin for centering -->
        <p style="text-align: center;"><a href="https://giphy.com/gifs/timanderic-money-cryptocurrency-3o751XDbTvZw958ZYk">via GIPHY</a></p> <!-- Center align the link -->
    </div>
</div>


<div class="third fade-in">
    <p> This will be the third text </p>
</div>
<div class="fourth fade-in">
    <p> Thank you very much for checking out my private data!</p>
</div>

<!-- fancy fade ins -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const elementsToFade = document.querySelectorAll(".fade-in");

        function fadeInElementsOnScroll() {
            elementsToFade.forEach(element => {
                if (isElementInViewport(element)) {
                    element.classList.add("active");
                } else {
                    element.classList.remove("active");
                }
            });
        }

        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        fadeInElementsOnScroll();

        document.addEventListener("scroll", fadeInElementsOnScroll);
    });
</script>


