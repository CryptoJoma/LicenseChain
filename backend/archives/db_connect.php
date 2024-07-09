<?php
// db_connect.php
$host = 'localhost';
$username = 'bjqgjlck_joma';
$password = 'tDl=RDT7!JbN';
$database = 'bjqgjlck_joma_portfolio';

$db = new mysqli($host, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
