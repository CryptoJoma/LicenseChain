# Overview
This repository contains a robust licensing system implemented in PHP, with Python integration for license validation. It provides functionalities to generate unique licenses, manage license usage, and validate licenses based on IP, MAC Addresses and Hardware Settings. The system is designed to be easy to use and customizable for various licensing needs.

# Features
- License Generation: Generate unique license keys for users.
- License Validation: Validate licenses based on IP, MAC Addresses and Hardware Settings.
- Usage Tracking: Track license usage to prevent overuse.
- Python Integration: Validate licenses via Python scripts.
- Customizable: Easily configurable for different licensing requirements.
- Database Management: Utilizes MySQL database for storing license data.

# Installation
- Prerequisites:
- PHP 7.4 or higher
- MySQL database
- Python 3.6 or higher
- Required Python libraries: requests, psutil

# How to Use:
1. Setup Database: Create a MySQL database and import the provided SQL schema.
```rb
-- database_schema.sql

-- Create the 'licenses' table to store license information
CREATE TABLE licenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    license_key VARCHAR(32) NOT NULL UNIQUE,
    expiration_date DATE NOT NULL,
    used_macs VARCHAR(255) DEFAULT '',
    used_ips VARCHAR(255) DEFAULT ''
);

-- Create the 'license_usage' table to track license usage
CREATE TABLE license_usage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    license_key VARCHAR(32) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    mac_address VARCHAR(17) NOT NULL,
    license_type int(11) NOT NULL,
    processor VARCHAR(255) NOT NULL,
    ram_amount VARCHAR(11) NOT NULL,
    disk_amount int(11) NOT NULL,
    hdd_id VARCHAR(16) NOT NULL,
    FOREIGN KEY (license_key) REFERENCES licenses(license_key)
);
```
2. Configure Settings: Update database connection details in db_connect.php.
3. Generate License: Use issueLicense() function in functions.php to generate licenses.
```rb
include 'functions.php';

$email = 'user@example.com';
$expiration_date = '2024-12-31';
$license_key = issueLicense($email, $expiration_date);
```
4. Validate License: Utilize validateLicense() function for license validation.
```rb
include 'functions.php';

$license_key = 'YOUR_LICENSE_KEY_HERE';
$ip = $_SERVER['REMOTE_ADDR'];
$mac_address = '00:00:00:00:00:00';
$validation_result = validateLicense($license_key, $ip, $mac_address);
echo $validation_result ? 'License valid' : 'License invalid';
```
5. Python Integration: Use validate.py script for Python-based license validation.
```rb
pip install -r requirements.txt
python validate.py
```
6. Customization: Modify scripts as needed to fit specific licensing needs. Handle errors and exceptions appropriately for robustness.

This script will remove expired licenses from the database when executed.

# How to Configure a Cron Job on cPanel:
1. Log in to your cPanel account.
2. Navigate to the "Advanced" or "Cron Jobs" section.
3. Under "Add New Cron Job", specify the frequency (e.g., daily) and the command to execute the PHP script:
```rb
php /path/to/your/expired_licenses.php
```
Replace /path/to/your/script.php with the actual path to your PHP script containing the removeExpiredLicenses() function.
4. Click "Add Cron Job" to save your configuration.

This cron job will run at the specified frequency and execute the PHP script, which in turn will remove expired licenses from the database. Ensure that the PHP script has the appropriate permissions to execute and access the database.
