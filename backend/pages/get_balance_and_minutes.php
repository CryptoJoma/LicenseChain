<?php
session_start(); // Start the session

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

// Assume the user ID is stored in the session
$actualuser = $_SESSION['user_id'];

$response = array();

// Fetch balance
$sql_balance = "SELECT Balance FROM Usuarios WHERE id = ?";
$stmt_balance = $conn->prepare($sql_balance);
$stmt_balance->bind_param("i", $actualuser);
$stmt_balance->execute();
$result_balance = $stmt_balance->get_result();
if ($result_balance->num_rows > 0) {
    $row = $result_balance->fetch_assoc();
    $response['Balance'] = $row['Balance'];
} else {
    $response['Balance'] = 0;
}
$stmt_balance->close();

// Fetch minutes
$sql_minutes = "SELECT amount FROM minutos WHERE userid_fk = ?";
$stmt_minutes = $conn->prepare($sql_minutes);
$stmt_minutes->bind_param("i", $actualuser);
$stmt_minutes->execute();
$result_minutes = $stmt_minutes->get_result();
if ($result_minutes->num_rows > 0) {
    $row = $result_minutes->fetch_assoc();
    $response['amount'] = $row['amount'];
} else {
    $response['amount'] = 0;
}
$stmt_minutes->close();

$conn->close();
echo json_encode($response);
?>
