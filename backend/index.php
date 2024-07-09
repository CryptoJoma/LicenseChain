<?php
session_start();

// Include the necessary functions and database connection
include 'archives/db_connect.php';
include 'archives/functions.php';

// CURRENT SECTION
$section = $_GET["section"];
switch($section){
  default:
  // TEMPLATE: Content
  include("pages/home.php");
  break;

  /* USER Here */
  case "minutes":
  // TEMPLATE: Content
  include("pages/minutes.php");
  break;

  case "profile":
  // TEMPLATE: Content
  include("pages/profile.php");
  break;
  /* ENDS Here */

  /* Auth Here */
  case "login":
  // TEMPLATE: Content
  include("pages/login.php");
  break;

  case "register":
  // TEMPLATE: Content
  include("pages/register.php");
  break;

  case "logout":
  include("pages/logout.php");
  break;
  /* ENDS Here */

}
?>
