<?php function getDbConnection()
{
    echo "TEST";
    // Create connection using the constants from config.php
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "<h2>DB - CONNECT SUCCESS</h2>";
    }
    return $conn;
}
