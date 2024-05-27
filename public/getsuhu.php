<?php
header('Content-Type: application/json');

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "aims";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the current day
$sql = "SELECT waktu, suhu FROM suhu WHERE waktu >= NOW() - INTERVAL 1 DAY ORDER BY waktu ASC";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo json_encode([]);
}

$conn->close();

echo json_encode($data);
