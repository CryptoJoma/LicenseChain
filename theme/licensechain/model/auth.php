<?php

//HACK ATTEMPT
if(!defined('PAGE_ACCESS'))
	header("location: https://$_SERVER[HTTP_HOST]?error=hack_attempt");

// Action
switch($action){

	//LOGIN DESIGN
	case 'login':
	if ($is_user === 0) {
		if (!$_GET["username"]) {
			$error = 1;
		} else {
			// Check if Telegram callback parameters are set
			if (isset($_GET['auth_date'], $_GET['id'], $_GET['first_name'], $_GET['username'], $_GET['hash'])) {
				try {
					// Validation Data from Telegram
					$auth_data = checkTelegramAuthorization($_GET);
					if ($auth_data) {
						// Data is valid, proceed with registration
						$tg_id = $_GET['id'];
						$username = $auth_data['username'];
						$first_name = $auth_data['first_name'];

						// Fetch user from database
						$is_user = count_rows("users_login", "tg_id = '$tg_id'"); // Return string
						//var_dump($tg_id);
						//var_dump($username);
						//var_dump($first_name);
						//die("Your ID: $tg_id and User: $username and name: $first_name");

						if ($is_user == 0) {
							// Insert user into the database
							$insert_stmt = $db->prepare("INSERT INTO users_login (tg_id, user, full_name) VALUES (?, ?, ?)");
							if (!$insert_stmt) {
								$msg = htmlspecialchars($db->error);
								$error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Prepare failed: $msg</p>";
							} else {
								$insert_stmt->bind_param("sss", $tg_id, $username, $first_name);
								if (!$insert_stmt->execute()) {
									$msg = htmlspecialchars($insert_stmt->error);
									$error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Execute failed: $msg</p>";
								} else {
									// Send a welcome message
									sendTelegramMessage($tg_id, "Welcome to our service, $first_name!", $configs["url"].'assets/tg_image.webp');

									// Add user to channel
									// Note: This typically requires admin privileges or direct user interaction
									// AddUserToChannel($tg_id);

									// Update last_login
									UserLastLogin($tg_id);

									// SET $_SESSION TO NAVIGATE
									$_SESSION['user_id'] = $tg_id;
									$_SESSION["islogged"] = 1;
									header('Location: /home');
									exit(); // Ensure no further code is executed
								}
								$insert_stmt->close();
							}
						}
					} else {
						$error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Error: Invalid Data</p>";
					}
				} catch (Exception $e) {
					$error_msg = $e->getMessage();
					$error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Error: $error_msg</p>";
				}
			} else {
				$error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Error: Invalid User Data</p>";
			}
		}

		if ($error) {
			template(view('auth/login', $error), 'Login');
		} else {

			// Update last_login
			UserLastLogin($tg_id);

			// SET $_SESSION TO NAVIGATE
			$_SESSION['user_id'] = $tg_id;
			$_SESSION["islogged"] = 1;
			header('Location: /home');
			exit(); // Ensure no further code is executed
		}
	} else {
		header('Location: /home');
		exit(); // Ensure no further code is executed
	}
	break;

	//LOGOUT FUNCTION
	case "logout":

    logout();

    // Redirect to the login page
    header("Location: /login");
	break;

}

?>
