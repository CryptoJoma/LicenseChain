<?php
// Include the necessary functions and database connection
include '../archives/db_connect.php';
include '../archives/functions.php';
// START SESSION
if(session_id() == "")
	session_start();
// Constants
define('NOWPAYMENTS_API_KEY', 'YOUR_NOWPAYMENTS_API_KEY'); // Updated API key
define('MAX_RETRIES', 3); // Number of retries for payment creation

// Handle request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['amount']) || !isset($input['currency'])) {
        sendResponse('error', 'Invalid input data');
    }

    $amount = $input['amount'];
    $currency = $input['currency'];

    $response = createNowPayment($amount, $currency, $_SESSION["user_id"]);
    sendResponse($response['status'], $response['message'], $response['data']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['payment_id'])) {
        sendResponse('error', 'Payment ID is required');
    }

    $paymentId = $_GET['payment_id'];
    $status = getPaymentStatus($paymentId);

		// If success, update Balance
		if($status === "finished"){
			// USER ID
			$user = UserInfo($_SESSION['user_id']);
			$current_id = $user["id"];
			$payment = PaymentInfo($paymentId);
			$payment_balance =  $user["balance"]+$payment["amount"];

			UpdateBalance($current_id, $payment_balance);
		}

    sendResponse('success', 'Payment status retrieved successfully', ['payment_status' => $status]);
} else {
    sendResponse('error', 'Invalid request method');
}
