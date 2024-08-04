<?php
// Ensure the session is started
session_start();
// Include once to return explicitly data which user can't modify
include_once("archives/functions.php");

// Check if database connection is available
if (!isset($db)) {
    die('Database connection not established.');
}

// SELECT ALL THE INFORMATION
$configs["title"] = settings("title");
$configs["title_web"] = settings("title_web");
$configs["slogan"] = settings("slogan");
$configs["theme"] = settings("theme");
$configs["url"] = settings("url");
$configs["email_web"] = settings("email_web");
$configs["email_admin"] = settings("email_admin");
$configs["timezone"] = settings("timezone");
$configs["status"] = settings("status");
$configs["mod_rewrite"] = settings("mod_rewrite");
$configs["smtp_server"] = settings("smtp_server");
$configs["smtp_port"] = settings("smtp_port");
$configs["smtp_user"] = settings("smtp_user");
$configs["smtp_password"] = settings("smtp_password");
$configs["session_time"] = settings("session_time");

// METADATA
$configs["meta_google"] = settings("meta_google");
$configs["meta_bing"] = settings("meta_bing");
$configs["meta_yandex"] = settings("meta_yandex");
$configs["meta_analytics"] = settings("meta_analytics");

// VERIFY if user is logged in
if (isset($_SESSION["islogged"])) {
    $uinfo = UserInfo($_SESSION["user_id"]);
    if ($uinfo) {
        $is_user = 1;
        $role = $uinfo['role'];
    } else {
        logout();
        $is_user = 0;
        $role = 0;
    }
} else {
    $is_user = 0;
    $role = 0;
}

// REGISTER THE IP OF OUR USERS
if ($is_user) { // Only register IP if the user is logged in
    $uinfo['ip'] = $_SERVER['REMOTE_ADDR'];
    $uinfo['ip_long'] = ip2long($_SERVER['REMOTE_ADDR']);
}

// WE MODIFY OUR URLS WITH FRIENDLY URLS
if (isset($configs['mod_rewrite']) && $configs['mod_rewrite'] == 1) {
    include_once("archives/mod_rewrite.php");
}
