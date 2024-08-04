<?php

//HACK ATTEMPT
if(!defined('PAGE_ACCESS'))
	header("location: https://$_SERVER[HTTP_HOST]?error=hack_attempt");

// Action
switch($action){

	case 69:
		template(view("dashboard/master"), "Home");
	break;

	case 2:
		template(view("dashboard/seller"), "Home");
	break;

	case 3:
		template(view("dashboard/support"), "Home");
	break;

	case 4:
		template(view("dashboard/user"), "Home");
	break;

	// ELITE MODULE //
	case 5:
		template(view("dashboard/elite"), "Home");
	break;

	case 6:
		template(view("dashboard/seller_elite"), "Home");
	break;
	// ENDS HERE //
	
	default:
		header('Location: ' . mod_url('./?section=login'));
		exit();

}

?>
