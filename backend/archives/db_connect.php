<?php
// db_connect.php
$host = 'localhost';
$username = 'YOUR_USER';
$password = 'YOUR_PASS';
$database = 'YOUR_DB';

$db = new mysqli($host, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
