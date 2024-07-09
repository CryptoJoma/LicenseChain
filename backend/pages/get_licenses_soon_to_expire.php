<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guagua";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

$sql = "SELECT `key` FROM licencias WHERE expiry >= NOW() + INTERVAL 0 DAY";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

$conn->close();
echo json_encode($response);
?>
