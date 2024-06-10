<?php
// db_connect.php
$host = 'YOUR_HOST';
$username = 'YOUR_DB_USER';
$password = 'YOUR_DB_PASS';
$database = 'YOUR_DB_NAME';

$db = new mysqli($host, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
