<?php

// Include once to return explicity data which user can't modify
include_once("functions.php");

//SELECT ALL THE INFORMATION
$stmt = $db->prepare("SELECT * FROM configurations WHERE ID = 1");
$stmt->execute();
$result = $stmt->get_result();
$configs = $result->fetch_assoc();
$stmt->close(); // Close statement after fetching result

// VERIFY if is user or guest
if($_SESSION["islogged"]){
	$user = UserInfo($_SESSION["user_id"]);
	if($user){
		$is_user = 1;
		$role = $user['role'];

	}else{
		$is_user = 0;
		$role = 0;
	}
}else{
	$is_user = 0;
}

//WE MODIFY OUR URLS WITH FRIENDLY URLS
if($configs['mod_rewrite'] == 1) {
	include_once("archives/mod_rewrite.php");
}
?>
