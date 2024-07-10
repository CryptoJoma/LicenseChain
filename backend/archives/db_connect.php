<?php
// db_connect.php
$host = 'localhost';
$username = 'DB_USER';
$password = 'DB_PASS';
$database = 'DATABASE';

$db = new mysqli($host, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
