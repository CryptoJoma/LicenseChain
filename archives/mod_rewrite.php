<?php
$urlin = array(
  "'\?section=images&path=([a-zA-Z0-9\-_&+]*)'",

  "'\?section=files&path=([a-zA-Z0-9\-_&+]*)'",

  "'\?section=logout'",
  "'\?section=login'",
);

$urlout = array(
  "img/\\1",

  "files/\\1",

  "logout",
  "login"
);

?>
