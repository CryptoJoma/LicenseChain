<?php
// functions.php
include 'db_connect.php';

function generateLicenseKey() {
    return strtoupper(substr(base64_encode(uniqid(mt_rand(), true)), 0, 32));
}

function issueLicense($email, $expiration_date) {
    global $db;
    $license_key = generateLicenseKey();
    $stmt = $db->prepare("INSERT INTO licenses (email, license_key, expiration_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $license_key, $expiration_date);
    $stmt->execute();
    $stmt->close();
    return $license_key;
}

function validateLicense($license_key, $ip, $mac_address) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM licenses WHERE license_key = ?");
    $stmt->bind_param("s", $license_key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        error_log("License key not found: $license_key");
        return false;
    }

    $license = $result->fetch_assoc();
    $expiration_date = strtotime($license['expiration_date']);

    if (time() > $expiration_date) {
        error_log("License expired for key: $license_key");
        return false;
    }

    $used_macs = explode(',', $license['used_macs']);
    if (!empty($license['used_macs']) && !in_array($mac_address, $used_macs)) {
        if (count($used_macs) >= 4) {
            error_log("Too many MAC addresses for license key: $license_key");
            return false;
        }
    }

    if (empty($license['used_macs']) || !in_array($mac_address, $used_macs)) {
        $used_macs[] = $mac_address;
        $used_macs_str = implode(',', $used_macs);
        $update_stmt = $db->prepare("UPDATE licenses SET used_macs = ? WHERE license_key = ?");
        $update_stmt->bind_param("ss", $used_macs_str, $license_key);
        $update_stmt->execute();
        $update_stmt->close();
    }

    $used_ips = explode(',', $license['used_ips']);
    if (count($used_ips) >= 4 && !in_array($ip, $used_ips)) {
        error_log("Too many IP addresses for license key: $license_key");
        return false;
    }

    $stmt->close();
    return true;
}

function updateUsedIPs($license_key, $ip) {
    global $db;
    $stmt = $db->prepare("SELECT used_ips FROM licenses WHERE license_key = ?");
    $stmt->bind_param("s", $license_key);
    $stmt->execute();
    $result = $stmt->get_result();
    $license = $result->fetch_assoc();
    $used_ips = explode(',', $license['used_ips']);

    if (!in_array($ip, $used_ips)) {
        if (count($used_ips) >= 4) {
            array_shift($used_ips);
        }
        $used_ips[] = $ip;
        $used_ips_str = implode(',', $used_ips);
        $update_stmt = $db->prepare("UPDATE licenses SET used_ips = ? WHERE license_key = ?");
        $update_stmt->bind_param("ss", $used_ips_str, $license_key);
        $update_stmt->execute();
        $update_stmt->close();
    }

    $stmt->close();
}

function removeExpiredLicenses() {
    global $db;
    $stmt = $db->prepare("DELETE FROM licenses WHERE expiration_date < NOW()");
    $stmt->execute();
    $stmt->close();
}
?>
