<?php

// Include the necessary functions and database connection
include 'archives/db_connect.php';
include 'archives/functions.php';

// START SESSION
if(session_id() == "")
	session_start();

include 'archives/variables.php';

// CURRENT SECTION
$section = $_GET["section"];
switch($section){
  default:
  // TEMPLATE: Dashboard
  include("pages/home.php");
  break;

  /* STAFF Modules Here */
  case "customers":
  // TEMPLATE: Customers
  // Role: 1,2,3
  include("pages/staff/customers.php");
  break;

  case "sellers":
  // TEMPLATE: Minutes
  // Role: 1
  include("pages/staff/sellers.php");
  break;

  case "roles":
  // TEMPLATE: Minutes
  // Role: 1
  include("pages/staff/roles.php");
  break;

  case "finances":
  // TEMPLATE: Minutes
  // Role: 1
  include("pages/staff/finances.php");
  break;
  /* ENDS Here */

  /* USER Here */
  case "bill":
  // TEMPLATE: Bill
  // Role: 4
  include("pages/user/bill.php");
  break;

  case "profile":
  // TEMPLATE: Profile
  // Role: 4
  include("pages/user/profile.php");
  break;

  // TEMPLATE: Logout
  case "logout":
  include("pages/user/logout.php");
  break;
  /* ENDS Here */

  /* Auth Here */
  case "login":
  // TEMPLATE: Login
  include("pages/auth/login.php");
  break;

  /* ENDS Here */

}
?>
