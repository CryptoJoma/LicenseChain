<?php

// Include once to return explicity data which user can't modify
include_once("functions.php");

if (isset($_SESSION["islogged"])) {

  $user = UserInfo($_SESSION["user_id"]);
}
?>
