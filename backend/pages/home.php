<?php

  // Verify if the user is logged
  if (!isset($_SESSION["islogged"])) {
    header("location: ./login");
  }

  // TEMPLATE: Header
  include("./template/header.php");

  if($user["role"] == 69)
    include("dashboard/master.php");
  elseif($user["role"] == 2)
    include("dashboard/seller.php");
  elseif($user["role"] == 3)
    include("dashboard/support.php");
  else
    include("dashboard/user.php");

  // TEMPLATE: Footer
  include("./template/footer.php");

  // Close the database connection here
  if (isset($db)) {
      $db->close();
  }
?>
