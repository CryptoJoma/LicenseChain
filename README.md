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
Prerequisites:
- PHP 7.4 or higher
- MySQL database
- Python 3.6 or higher
- Required Python libraries: requests, psutil

# How to Use:
1. Setup Database: Create a MySQL database and import the provided SQL schema.
```rb
-- database_schema.sql

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE `licenses` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `license_type` enum('1','69') NOT NULL DEFAULT '1',
  `license_key` varchar(255) NOT NULL,
  `expiration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `used_ips` mediumtext DEFAULT NULL,
  `ips_limit` int(11) NOT NULL DEFAULT 4,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `used_macs` mediumtext DEFAULT '',
  `macs_limit` int(11) NOT NULL DEFAULT 4
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `license_usage`
--

CREATE TABLE `license_usage` (
  `id` int(11) NOT NULL,
  `license_key` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `mac_address` varchar(255) NOT NULL,
  `license_type` int(11) NOT NULL DEFAULT 1,
  `processor` varchar(255) NOT NULL,
  `ram_amount` int(11) NOT NULL,
  `disk_amount` int(11) NOT NULL,
  `hdd_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```
2. Configure Settings: Update database connection details in db_connect.php.
3. Generate License: Use issueLicense() function in functions.php to generate licenses.
```rb
include 'functions.php';

$userID = '12345';
$expiration_date = '2024-12-31';
$license_key = issueLicense($userID, $expiration_date);
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
```
- 5.5 main.py (Example)
  ```
  from validate import check_license

  if __name__ == "__main__":
    validation_result = check_license()

    if validation_result.get('status') == 'success':
        print(validation_result['message'])
        asyncio.run(example_function())
    else:
        print("Invalid License. Script will not start.")
  ```
6. Customization: Modify scripts as needed to fit specific licensing needs. Handle errors and exceptions appropriately for robustness.

This script will remove expired licenses from the database when executed.

# How to Configure a Cron Job on cPanel:
1. Log in to your cPanel account.
2. Navigate to the "Advanced" or "Cron Jobs" section.
3. Under "Add New Cron Job", specify the frequency (e.g., daily) and the command to execute the PHP script:
```rb
# Replace /path/to/your/script.php with the path to your PHP script containing the removeExpiredLicenses() function.
# Example
php /path/to/your/expired_licenses.php
```
4. Click "Add Cron Job" to save your configuration.

This cron job will run at the specified frequency and execute the PHP script, which in turn will remove expired licenses from the database. This will ensure the PHP script has the appropriate permissions to execute and access the database.
