<?php include_once '../config.php';
$global_energy_total_data = str_replace(',', '.', $global_energy_total_data); // conversion for calculation
?>

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
$sql = "SELECT MAX(CAST(temperature AS DECIMAL(10, 2))) AS max_temperature FROM weather WHERE DATE(datetime) = '$dateToday'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $highestTempToday = $row["max_temperature"];
    // echo "Highest temperature recorded today: " . $highestTempToday;
} else {
    // echo "No temperature records found for today";
}

// Close connection
$conn->close();
?>

<!-- Calculate duration of work -->
<?php
// Sample value of $global_energy_total_data

// Define the thresholds with baseline power consumption


$current_hour = date('H');
$reference_hour = 1;
$hour_difference = ($current_hour - $reference_hour + 24) % 24;
$baseline = 0.050 + $hour_difference * 0.050;

$lowest_threshold = $baseline + 0.150; // just in the office to get stuff
$low_threshold = $baseline + 0.800; // around 4h of work
$medium_threshold = $baseline + 1.600; // around 8h of work
$high_threshold = $baseline + 1.650; //more than 8h of work


// Check the range of $global_energy_total_data
if ($global_energy_total_data <= $lowest_threshold) {
    $result = "no";
} else if ($global_energy_total_data >= $lowest_threshold && $global_energy_total_data <= $low_threshold) {
    $result = "a small";
} elseif ($global_energy_total_data > $low_threshold && $global_energy_total_data <= $medium_threshold) {
    $result = "a medium";
} elseif ($global_energy_total_data > $medium_threshold && $global_energy_total_data <= $high_threshold) {
    $result = " a high";
} elseif ($global_energy_total_data > $high_threshold) {
    $result = "an exceptional";
} else {
    $result = "Invalid value"; // In case the value is negative or not numeric
}

?> <p><?php echo "Result: $result + $baseline + $global_energy_total_data";
        ?> </p>



<div class="second fade-in">
    <p> Your work to Temperature Evaluation: </p>
    <p> Today's max-temperature was: <?php echo $highestTempToday; ?> °C and you did <?php echo $result ?> amount of work! <br><br></p>
    <div style="text-align: center;">
        <iframe src="https://giphy.com/embed/XreQmk7ETCak0" width="240" height="180" frameBorder="0" class="giphy-embed" allowFullScreen style="display: inline-block; margin: 0 auto;"></iframe> <!-- Inline-block display and auto margin for centering -->
        <p style="text-align: center;"><a href="https://giphy.com/gifs/timanderic-money-cryptocurrency-3o751XDbTvZw958ZYk"></a></p>
        <br><br>
        <?php
        date_default_timezone_set('Europe/Vienna');
        $current_time = strtotime(date("H:i"));
        if ($current_time < strtotime('13:30')) {
            echo "<p> The day is still young, nothing to see here yet on your evalutation</p>";
        } else {
            if ($result == "zero" && $highestTempToday < 18) {
                echo "<p> Weather wasn't that good and no work is logged, u ok bro? Keep hustlin' ! </p>";
            } else if ($result == "a medium" && $highestTempToday < 18) {
                echo " <p> Weather wasn't so perfect today, glad you kept it inside, man! </p>";
            } else if ($result == "an exceptional" && $highestTempToday < 18) {
                echo "Perfect usage of time bro, weather wasn't so good anyways";
            } else if ($result == "zero" && $highestTempToday > 18) {
                echo "<p> Enjoyed your day off, didn't ya?";
            } else if ($result == "a medium" && $highestTempToday > 18) {
                echo " <p> Weather wasn't so perfect today, but still good, maybe next time go for a walk or somethin'? </p>";
            } else if ($result == "an exceptional" && $highestTempToday > 18) {
                echo "Always working, busy bee... Maybe enjoy the 🌞 once in a while";
            }
        }
        ?>


    </div>

</div>

<div class="fourth fade-in">
    <p style="font-size: 36px"> Thank you very much for checking out my very private data!</p>
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
