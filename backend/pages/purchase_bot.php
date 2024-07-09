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

// Assume the bot costs $100
$bot_cost = 100;

// Fetch balance
$sql_balance = "SELECT balance FROM usuarios WHERE id = ?";
$stmt_balance = $conn->prepare($sql_balance);
$stmt_balance->bind_param("i", $actualuser);
$stmt_balance->execute();
$result_balance = $stmt_balance->get_result();

if ($result_balance->num_rows > 0) {
    $row = $result_balance->fetch_assoc();
    $balance = $row['balance'];

    if ($balance >= $bot_cost) {
        // Deduct bot cost from balance
        $new_balance = $balance - $bot_cost;
        $sql_update_balance = "UPDATE usuarios SET balance = ? WHERE id = ?";
        $stmt_update_balance = $conn->prepare($sql_update_balance);
        $stmt_update_balance->bind_param("di", $new_balance, $actualuser);
        $stmt_update_balance->execute();

        // Insert new bot license
        $new_license_key = uniqid();
        $sql_insert_license = "INSERT INTO licencias (`key`, script, issued, expiry, status, UserID_FK) VALUES (?, 'CRYPTO', NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), 1, $actualuser)";
        $stmt_insert_license = $conn->prepare($sql_insert_license);
        $stmt_insert_license->bind_param("s", $new_license_key);
        $stmt_insert_license->execute();

        echo "Bot purchased successfully.";
    } else {
        echo "Insufficient funds.";
    }
} else {
    echo "Failed to fetch balance.";
}

$stmt_balance->close();
$conn->close();
?>
