<?php
session_start();
session_destroy();
header("Location: ./login");
exit(); // Add exit to stop further execution
?>
