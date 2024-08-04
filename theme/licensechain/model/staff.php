<?php

//HACK ATTEMPT
if(!defined('PAGE_ACCESS'))
	header("location: https://$_SERVER[HTTP_HOST]?error=hack_attempt");

// Action
switch($action){

	case "settings":
		$roles = array(2, 6);
		if(!in_array($role, $roles)){
			header("Location: /home");
		}

		template(view("staff/settings"), "Settings");
	break;

	case "finances":
		$roles = array(2, 6, 69);
		if(!in_array($role, $roles)){
			header("Location: /home");
		}

		template(view("staff/finances"), "Finances");
	break;

	case "roles":
		$roles = array(69);
		if(!in_array($role, $roles)){
			header("Location: /home");
		}

		template(view("staff/settings"), "Roles");
	break;

	case "sellers":
		$roles = array(69);
		if(!in_array($role, $roles)){
			header("Location: /home");
		}

		template(view("staff/settings"), "Sellers");
	break;

}

?>
