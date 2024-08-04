<?php

include("config.php");
date_default_timezone_set($configs['timezone']);

// Retrieve and sanitize user input
$section = isset($_GET['section']) ? htmlspecialchars($_GET['section']) : '';
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';

// Handle errors
if ($error && !$section) {
    header("HTTP/1.0 404 Not Found");
    include(view('error_404')); // Display 404 error
    exit(); // Ensure no further code execution
}

// Check system status and role (ensure $role is defined and initialized)
if ($configs['status'] == 0 && $role != 69) {
    template(view('development_mode'), $text['DEVELOPMENT_MODE']);
    exit(); // Ensure no further code execution
}

// Handle section-based routing
$urls = explode('/', trim($section, '/'));
switch ($urls[0]) {
  case 'staff':
  case 'settings':
    $section = 'staff';
    $action = $urls[0];
    //$urls[1] ?? '';
  break;

  case 'home':
    $section = 'principal';
    $action = $role;
  break;

  case 'p':
    if (PageInfo($urls[1]) !== FALSE) {
      $section = 'page';
      $section = $urls[1];
    } else {
      header('Location: ' . mod_url('./?error=404')); // Redirect if FALSE
      exit(); // Ensure no further code execution
    }
  break;

  case 'login':
  case 'logout':
    $section = 'auth';
    $action = $urls[0];
  break;

  case 'bill':
  case 'licenses':
  case 'profile':
    $section = 'user';
    $action = $urls[0];
  break;

  default:
    header('Location: ' . mod_url('./?section=login'));
    exit(); // Ensure no further code execution
}

// Security check for section
if (preg_match("%https\:\/\/%", $section) || preg_match("%\.\.%", $section)) {
    header('Location: ' . mod_url('./?error=hack_attempt'));
    exit(); // Ensure no further code execution
}

if (!$section) {
    $section = 'principal';
}

// Include the appropriate file
$path = "theme/" . $configs['theme'] . "/model/$section.php";
if (file_exists($path)) {
    define("PAGE_ACCESS", 1);
    include($path);
} else {
    header('Location: ' . mod_url('./?error=404'));
    exit(); // Ensure no further code execution
}
