<?php
// Include the necessary functions and database connection
include '../archives/db_connect.php';
include '../archives/functions.php';

// Get the POST data
$license_key = $_POST['license_key'];
$license_type = $_POST['license_type'];
$ip_address = $_SERVER['REMOTE_ADDR'];
$mac_address = $_POST['mac_address'];
$processor = $_POST['processor'];
$ram_amount = $_POST['ram_amount'];
$disk_amount = $_POST['disk_amount'];
$hdd_id = $_POST['hdd_id'];

// Validate the license
$validation_result = validateLicense($license_key, $ip_address, $mac_address);

if (!$validation_result) {
    error_log("Validation failed for license key: $license_key, IP: $ip_address, MAC: $mac_address");
    echo json_encode(['status' => 'error', 'message' => 'Invalid or expired license, or too many devices']);
    exit();
}

// Update used IPs
updateUsedIPs($license_key, $ip_address);

// Save the IP and Hardware Settings to the database if not already saved
$stmt = $db->prepare("SELECT * FROM license_usage WHERE license_key = ? AND license_type = ? AND mac_address = ? AND processor = ? AND ram_amount = ? AND disk_amount = ? AND hdd_id = ?");
$stmt->bind_param("sssssss", $license_key, $license_type, $mac_address, $processor, $ram_amount, $disk_amount, $hdd_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt = $db->prepare("INSERT INTO license_usage (license_key, license_type, ip_address, mac_address, processor, ram_amount, disk_amount, hdd_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $license_key, $license_type, $ip_address, $mac_address, $processor, $ram_amount, $disk_amount, $hdd_id);
    $stmt->execute();
    $stmt->close();
}

$db->close();

echo json_encode(['status' => 'success', 'message' => 'License validated successfully']);
?>
