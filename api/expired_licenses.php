<?php

// Include the necessary functions and database connection
include '../archives/db_connect.php';
include '../archives/functions.php';

// Call the function to remove expired licenses
removeExpiredLicenses();
echo "Expired licenses have been removed successfully.";

?>
