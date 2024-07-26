<?php
// Telegram Bot Token
define('TELEGRAM_BOT_TOKEN', 'BOT_TOKEN');
// Place username of your bot here
define('BOT_USERNAME', 'BOT_USERNAME');
// Place username of your channel here
define('CHANNEL_ID', '@CHANNEL_ID');

####################
# General Functions
####################

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
# Payment Functions
####################

function PaymentInfo($paymentid){
  global $db;
  $stmt = $db->prepare("SELECT * FROM payments WHERE payment_id = ?");
  $stmt->bind_param("i", $paymentid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
      return false;
  } else {
    $payment = $result->fetch_assoc();
    $stmt->close(); // Close statement after fetching result
    return $payment;
  }
}

function UpdateBalance($user, $amount){
  global $db;

  $update_stmt = $db->prepare("UPDATE users_login SET balance = ? WHERE id = ?");
  $update_stmt->bind_param("si", $amount, $user);
  $update_stmt->execute();
  $update_stmt->close();

}

function sendResponse($status, $message, $data = [])
{
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

function logError($error)
{
    // Log errors to a file or a logging service
    error_log($error, 3, 'payment_errors.log'); // Adjust path as needed
}

function createNowPayment($amount, $currency, $user_id, $retries = 0)
{
  global $db;

    $url = 'https://api.nowpayments.io/v1/payment';
    $data = [
        'price_amount' => $amount,
        'is_fee_paid_by_user' => true,
        'price_currency' => 'USD',
        'pay_currency' => $currency,
        'ipn_callback_url' => 'https://licensechain.app/bill',
        'order_id' => uniqid(),
        'order_description' => 'Payment for order ' . uniqid(),
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'x-api-key: ' . NOWPAYMENTS_API_KEY,
            'Content-Type: application/json'
        ],
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
    ]);

    $result = curl_exec($ch);

    if ($result === false) {
        $errorMsg = 'cURL Error: ' . curl_error($ch);
        logError($errorMsg);
        curl_close($ch);
        if ($retries < MAX_RETRIES) {
            return createNowPayment($amount, $currency, $retries + 1);
        } else {
            return ['status' => 'error', 'message' => 'Failed to create payment after multiple attempts. Please try again later.'];
        }
    }

    curl_close($ch);

    $paymentResponse = json_decode($result, true);

    if ($paymentResponse === false || !isset($paymentResponse['payment_id'])) {
        $errorMsg = 'API Response Error: ' . json_last_error_msg();
        logError($errorMsg);
        return ['status' => 'error', 'message' => 'Failed to decode API response. Please try again later.'];
    }

    if (isset($paymentResponse['statusCode']) && $paymentResponse['statusCode'] == 403) {
        logError('API Key Error: ' . $paymentResponse['message']);
        return ['status' => 'error', 'message' => 'API key is invalid or permissions are incorrect.'];
    }

    $paymentId = $paymentResponse['payment_id'];
    $payAddress = $paymentResponse['pay_address'];
    $payAmount = $paymentResponse['pay_amount'];
    $qrCodeUrl = generateQRCodeURL($payAddress, '150x150'); // Adjust size as needed
    $stmt = $db->prepare("INSERT INTO payments (user_id, payment_id, amount, currency, pay_address, qr_code, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    if (!$stmt) {
        error_log("Prepare failed: " . htmlspecialchars($db->error), 3, 'functions.log');
        die("Prepare failed: " . htmlspecialchars($db->error));
    }

    // Bind parameters
    $stmt->bind_param('isssss', $user_id, $paymentId, $amount, $currency, $payAddress, $qrCodeUrl);

    if (!$stmt->execute()) {
        error_log("Execute failed: " . htmlspecialchars($stmt->error), 3, 'functions.log');
        die("Execute failed: " . htmlspecialchars($stmt->error));
    }

    $stmt->close();

    return [
        'status' => 'success',
        'data' => [
            'payment_id' => $paymentId,
            'pay_amount' => $payAmount,
            'pay_address' => $payAddress,
            'qr_code' => $qrCodeUrl,
            'status' => 'created',
        ]
    ];
}

function checkPaymentStatus($paymentId)
{
    $url = "https://api.nowpayments.io/v1/payment/$paymentId";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'x-api-key: ' . NOWPAYMENTS_API_KEY
        ],
    ]);

    $result = curl_exec($ch);

    if ($result === false) {
        $errorMsg = 'cURL Error: ' . curl_error($ch);
        logError($errorMsg);
        curl_close($ch);
        return ['status' => 'error', 'message' => 'Failed to check payment status. Please try again later.'];
    }

    curl_close($ch);

    $status = json_decode($result, true);

    if ($status === false) {
        $errorMsg = 'API Response Error: ' . json_last_error_msg();
        logError($errorMsg);
        return ['status' => 'error', 'message' => 'Failed to decode API response. Please try again later.'];
    }

    return ['status' => 'success', 'data' => $status];
}

function getPaymentStatus($paymentId)
{
    $status = checkPaymentStatus($paymentId);

    if ($status['status'] === 'error') {
        return 'error';
    }

    return $status['data']['payment_status'] ?? 'unknown';
}

function generateQRCodeURL($data, $size = '100x100')
{
    return "https://api.qrserver.com/v1/create-qr-code/?size=$size&data=" . urlencode($data);
}

####################
# User Functions
####################

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

####################
# License Functions
####################

function LicenseInfo($current_id, $type = 1) {
  global $db;

  // Prepare statement
  $stmt = $db->prepare("SELECT * FROM licenses WHERE license_type = ? AND uid = ?");
  if (!$stmt) {
      return $db->error; // Handle get result error
  }

  // Bind parameters
  $stmt->bind_param("si", $type, $current_id);
  if (!$stmt->execute()) {
      return $stmt->error; // Handle get result error
  }

  // Get result
  $result = $stmt->get_result();
  if (!$result) {
      return $stmt->error; // Handle get result error
  }

  if ($result->num_rows === 0) {
      $stmt->close();
      return false;
  } else {
    $license = $result->fetch_assoc();
    $stmt->close(); // Close statement after fetching result
    return $license;
  }
}

function generateLicenseKey() {
    return strtoupper(substr(base64_encode(uniqid(mt_rand(), true)), 0, 32)); // Define "KEY" and total chracters
}

function issueLicense($user_id, $expiration_date, $type = 1, $macs_limit = 1, $ips_limit = 1) {
    global $db;
    $license_key = generateLicenseKey();
    $stmt = $db->prepare("INSERT INTO licenses (uid, license_key, expiration_date, license_type, macs_limit, ips_limit) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssii", $user_id, $license_key, $expiration_date, $type, $macs_limit, $ips_limit);
    $stmt->execute();
    $stmt->close();
    return $license_key;
}

function validateLicense($license_key, $ip, $mac_address) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM licenses WHERE license_key = ?");
    $stmt->bind_param("s", $license_key);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        error_log("License key not found: $license_key");
        return false;
    }

    $license = $result->fetch_assoc();
    $expiration_date = strtotime($license['expiration_date']);

    if (time() > $expiration_date) {
        error_log("License expired for key: $license_key");
        return false;
    }

    $used_macs = explode(',', $license['used_macs']);
    if (!empty($license['used_macs']) && !in_array($mac_address, $used_macs)) {
        if (count($used_macs) >= $license['macs_limit']) {
            error_log("Too many MAC addresses for license key: $license_key");
            return false;
        }
    }

    if (empty($license['used_macs']) || !in_array($mac_address, $used_macs)) {
        $used_macs[] = $mac_address;
        $used_macs_str = implode(',', $used_macs);
        $update_stmt = $db->prepare("UPDATE licenses SET used_macs = ? WHERE license_key = ?");
        $update_stmt->bind_param("ss", $used_macs_str, $license_key);
        $update_stmt->execute();
        $update_stmt->close();
    }

    $used_ips = explode(',', $license['used_ips']);
    if (count($used_ips) >= $license['ips_limit'] && !in_array($ip, $used_ips)) {
        error_log("Too many IP addresses for license key: $license_key");
        return false;
    }

    $stmt->close();
    return true;
}

function removeExpiredLicenses() {
    global $db;
    $stmt = $db->prepare("DELETE FROM licenses WHERE expiration_date < NOW()");
    $stmt->execute();
    $stmt->close();
}

####################
# IPs and Hardware Settings
####################
function updateUsedIPs($license_key, $ip) {
    global $db;

    // Prepare and execute the select statement
    $stmt = $db->prepare("SELECT used_ips, ips_limit FROM licenses WHERE license_key = ?");
    if (!$stmt) {
        die('Prepare failed: ' . $db->error);
    }

    $stmt->bind_param("s", $license_key);
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    $license = $result->fetch_assoc();
    $stmt->close();

    // Check if the license exists
    if (!$license) {
        die('License not found');
    }

    $used_ips = explode(',', $license['used_ips']);

    if (!in_array($ip, $used_ips)) {
        if (count($used_ips) >= $license['ips_limit']) {
            array_shift($used_ips);
        }
        $used_ips[] = $ip;
        $used_ips_str = implode(',', $used_ips);

        // Prepare and execute the update statement
        $update_stmt = $db->prepare("UPDATE licenses SET used_ips = ? WHERE license_key = ?");
        if (!$update_stmt) {
            die('Prepare failed: ' . $db->error);
        }

        $update_stmt->bind_param("ss", $used_ips_str, $license_key);
        if (!$update_stmt->execute()) {
            die('Execute failed: ' . $update_stmt->error);
        }
        $update_stmt->close();
    }
}

?>
