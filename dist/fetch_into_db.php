<?php function getDbConnection() {
    $servername = "your_server_hostname";
    $username = "your_username";
    $password = "your_password";
    $dbname = "energy_data";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
