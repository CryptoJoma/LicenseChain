<?php

// Database Configuration
define('DBUSER', 'YOUR_USER');
define('DBPWD', 'YOUR_PASS');
define('DBHOST', 'YOUR_HOST');
define('DBNAME', 'YOUR_DB');
// Telegram Bot Token
define('TELEGRAM_BOT_TOKEN', 'YOUR_BOT_TOKEN');
// Place username of your bot here
define('BOT_USERNAME', 'YOUR_BOT_USER');
// Place username of your channel here
define('CHANNEL_ID', '@YOUR_CHNNALE_ID');

// Include DB, Functions, Classes, and Texts
include("archives/db.php");
//include_once("archives/language.php");
include("archives/functions.php");
include("archives/variables.php");

// Include Special Theme Functions if the file exists
$themeFunctionsPath = 'theme/' . (isset($configs['theme']) ? $configs['theme'] : '') . '/functions.php';
if (file_exists($themeFunctionsPath)) {
    include($themeFunctionsPath);
} else {
    // Log or handle the error if the theme functions file does not exist
    error_log("Theme functions file not found: $themeFunctionsPath");
}

// Start Session
if (session_id() == "")
  session_start();

?>
