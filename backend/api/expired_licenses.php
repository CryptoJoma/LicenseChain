<?php
include '../archives/functions.php';

// Call the function to remove expired licenses
removeExpiredLicenses();
echo "Expired licenses have been removed successfully.";

check_minutes();
echo "Minutes balance have been updated successfully for all the users.";
?>
