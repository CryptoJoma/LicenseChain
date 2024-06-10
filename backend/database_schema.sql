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