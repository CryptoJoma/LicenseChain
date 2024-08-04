<?php

####################
# General Functions
####################

// Function to declare and show the global design with classes
function template($content, $title = NULL, $description = NULL, $extra = NULL) {
    global $configs, $extra_header, $extra_footer, $section, $is_user, $role, $uinfo, $text, $ads, $nobder, $title_section, $global_title;

    // Ensure $global_title and $title are set
    $title = $global_title ? $global_title : $title;
    $title = $title ? "$title | $configs[title]" : "$configs[title_web] | $configs[title]";

    $extra_head = $extra_header['css'] . $extra_header['js'] . $extra_header['js2'] . $extra_header['custom'];
    $extra_foot = $extra_footer['css'] . $extra_footer['js'] . $extra_footer['js2'] . $extra_footer['custom'];
    $meta_extra = $extra_header['meta'];

    // Determine which template file to include
    $archive = file_exists('./theme/' . $configs['theme'] . '/view/' . $section . '/template.php')
        ? './theme/' . $configs['theme'] . '/view/' . $section . '/template.php'
        : './theme/' . $configs['theme'] . '/view/template.php';

    if (file_exists($archive)) {
        ob_start(); // Start output buffering
        include_once($archive);
        $show = ob_get_clean(); // Get buffered content and clean buffer
    } else {
        $show = 'Template file not found!';
    }

    // Handle URL rewriting
    if ($configs['mod_rewrite'] == 1) {
        $show = change_rewrite($show);
    }

    echo $show;
}

// Function for the section design
function view($type, $cont = NULL, $pass = 0) {
    global $configs, $uinfo, $is_user, $role, $section, $text, $ads, $nobder, $title_section;

    // Determine which view file to include
    $archive = defined('ADMIN_ACCESS')
        ? (file_exists('./theme/' . $configs['theme'] . '/view/admin/' . $section . '/' . $type . '.php')
            ? './theme/' . $configs['theme'] . '/view/admin/' . $section . '/' . $type . '.php'
            : (file_exists('./theme/' . $configs['theme'] . '/view/admin/' . $type . '.php')
                ? './theme/' . $configs['theme'] . '/view/admin/' . $type . '.php'
                : './theme/' . $configs['theme'] . '/view/' . $type . '.php'))
        : (file_exists('./theme/' . $configs['theme'] . '/view/' . $section . '/' . $type . '.php')
            ? './theme/' . $configs['theme'] . '/view/' . $section . '/' . $type . '.php'
            : './theme/' . $configs['theme'] . '/view/' . $type . '.php');

    if (file_exists($archive)) {
        ob_start(); // Start output buffering
        include_once($archive);
        $print = ob_get_clean(); // Get buffered content and clean buffer
    } else {
        $print = 'View file not found!';
    }

    // Handle URL rewriting
    if ($configs['mod_rewrite'] == 1) {
        $print = change_rewrite($print);
    }

    return $print;
}

//Function for add extra data
function extra_head($archive, $type){
	global $extra_header;
	if($type == "js"){
		$extra_header['js'] .= "\n <script type=\"text/javascript\" src=\"$archive\"></script>";
	} elseif($type == "javascript"){
		$extra_header['js2'] .= "\n <script type=\"text/javascript\">$archive</script>";
	} elseif($type == "keywords"){
		$extra_header['keywords'] .= $archive;
	} elseif($type == "meta"){
		$extra_header['meta'] .= $archive;
	} elseif($type == "custom"){
		$extra_header['custom'] .= $archive;
	} else {
		$extra_header['css'] .= "\n <link rel=\"stylesheet\" type=\"text/css\" href=\"$archive\" />";
	}
}

//Function for add extra data
function extra_foot($archive, $type){
	global $extra_footer;
	if($type == "js"){
		$extra_footer['js'] .= "\n <script type=\"text/javascript\" src=\"$archive\"></script>";
	} elseif($type == "javascript"){
		$extra_footer['js2'] .= "\n <script type=\"text/javascript\">$archive</script>";
	} elseif($type == "custom"){
		$extra_footer['custom'] .= $archive;
	} else {
		$extra_footer['css'] .= "\n <link rel=\"stylesheet\" type=\"text/css\" href=\"$archive\" />";
	}

	return $extra_footer;
}

//Function to change some characters of the url
function mod_url($url){
	global $configs, $urlin, $urlout;

	if($configs['mod_rewrite'] == 1){
		$url = str_replace('./', '/', $url);
		return(preg_replace($urlin, $urlout, $url));
	}else
		return($url);
}

//Function to change our conditionals on GET
function change_rewrite($string){
	global $urlin, $urlout;
	$string = str_replace('./?section', '/?section', $string);
	$string = str_replace('./staff', '/staff', $string);
   	$string = preg_replace($urlin, $urlout, $string);
	return $string;
}

// Function to get the site settings
function settings($site) {
  global $db;
  $stmt = $db->prepare("SELECT value FROM settings WHERE meta = ?");
  $stmt->bind_param("s", $site);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
      $stmt->close(); // Close statement if no results
      return false;
  } else {
    $value = $result->fetch_assoc();
    $stmt->close(); // Close statement after fetching result

    return $value["value"];
  }
}

function show_message($message, $type = 1){
	global $configs;

	if($type == 1)
		$type = 's';
	if($type == 2)
		$type = 'd';
	if($type == 3)
		$type = 'w';
	if($type == 4)
		$type = 'i';

	include('./theme/'.$configs['theme'].'/view/messages.php');

	return($return);
}

//Call classes
function call_class($class){
	if(file_exists('archives/class/'.$class.'.php')){
		include_once('archives/class/'.$class.'.php');
	} elseif(file_exists('archives/class/class.'.$class.'.php')){
		include_once('archives/class/class.'.$class.'.php');
	}
}

function convertToHighestNumber($number) {
    return ceil($number);
}

function addDays($daysToAdd) {
    // Get the current date and time
    $currentDateTime = new DateTime();

    // Add the specified number of days
    $currentDateTime->modify("+$daysToAdd days");

    // Format the new date and time
    return $currentDateTime->format('Y-m-d H:i:s');
}

//Function to count rows on a table with or without a "where"
function count_rows($table, $variables = null) {
  global $db;

  // Construct the SQL query
    if ($variables === null) {
        $query = "SELECT COUNT(*) AS count FROM " . $table;
    } else {
        $query = "SELECT COUNT(*) AS count FROM " . $table . " WHERE " . $variables;
    }

    // Execute the query
    $result = $db->query($query);

    // Fetch the result
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        // Handle query error
        return 0;
    }
}

####################
# User Functions
####################

function logout(){
	// Unset all session variables
	$_SESSION = array();

	// If there is a session cookie, delete it
	if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	// Destroy the session
	session_destroy();
}

function UserInfo($user){
  global $db;
  $stmt = $db->prepare("SELECT * FROM users_login WHERE tg_id = ?");
  $stmt->bind_param("s", $user);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
      return false;
  } else {
    $user = $result->fetch_assoc();
    $stmt->close(); // Close statement after fetching result
    return $user;
  }
}

function UserLastLogin($user){
  global $db;

  $update_stmt = $db->prepare("UPDATE users_login SET last_login = ? WHERE tg_id = ?");
  $last_login_time = time();
  $update_stmt->bind_param("is", $last_login_time, $user);
  $update_stmt->execute();
  $update_stmt->close();

}

function check_code($code){
  global $db;
  $stmt = $db->prepare("SELECT * FROM verification_codes WHERE code = ?");
  $stmt->bind_param("s", $code);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
      return false;
  } else {
    return true;
  }
}

function remove_code($code) {
  global $db;

  if (!check_code($code)) {
      return false;
  } else {
    $delete_stmt = $db->prepare("DELETE FROM verification_codes WHERE code = ?");
    $delete_stmt->bind_param("i", $code); // Assuming mid is integer (i)
    $delete_stmt->execute();
    $delete_stmt->close();
    return true;
  }
}

// Check Telegram Authorization: Login/Register
function checkTelegramAuthorization($auth_data) {
    $check_hash = $auth_data['hash'];
    unset($auth_data['hash'], $auth_data['section']);
    $data_check_arr = [];
    foreach ($auth_data as $key => $value) {
        $data_check_arr[] = $key . '=' . $value;
    }
    sort($data_check_arr);
    $data_check_string = implode("\n", $data_check_arr);
    $secret_key = hash('sha256', TELEGRAM_BOT_TOKEN, true);

    $hash = hash_hmac('sha256', $data_check_string, $secret_key);
    if (strcmp($hash, $check_hash) !== 0) {
        throw new Exception('Data is NOT from Telegram');
    }
    if ((time() - $auth_data['auth_date']) > 86400) {
        throw new Exception('Data is outdated');
    }
    return $auth_data;
}

####################
# Telegram Functions
####################

// Function to send a Telegram message with an inline button
function sendTelegramMessage($chat_id, $message, $image) {
    $url = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendPhoto";

    $str = ltrim(CHANNEL_ID, '@');
    $msg_button = "https://t.me/$str";
    // Create an inline keyboard with a button linking to the channel
    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => '🔗 Join our channel', 'url' => $msg_button]
            ]
        ]
    ];

    $params = [
        'chat_id' => $chat_id,
        'photo' => $image,
        'caption' => $message,
        'reply_markup' => json_encode($keyboard) // Encode the keyboard in JSON format
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
