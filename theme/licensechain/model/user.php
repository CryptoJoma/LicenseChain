<?php

//HACK ATTEMPT
if(!defined('PAGE_ACCESS'))
	header("location: https://$_SERVER[HTTP_HOST]?error=hack_attempt");

// Action
switch($action){

	case "bill":
		$roles = array(4, 5);
		if(!in_array($role, $roles)){
			header("Location: /home");
		}

		template(view("user/bill"), "Wallet");
	break;

	case "licenses":
		$roles = array(4);
		if(!in_array($role, $roles)){
			header("Location: /home");
		}

		template(view("user/licenses"), "Licenses");
	break;

  case "profile":
		$roles = array(4, 5);
		if(!in_array($role, $roles)){
			header("Location: /home");
		}

		template(view("user/profile"), "Profile");
	break;

}

?>
