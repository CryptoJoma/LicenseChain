<?php

// Database connection
require_once '../archives/db_connect.php';
require_once '../archives/functions.php';

// Constants
define('TIME_LIMIT', 15 * 60); // 15 minutes in seconds

// Find expired payments
$currentTime = time();
$expiredTime = $currentTime - TIME_LIMIT;

$sql = "SELECT payment_id FROM payments WHERE created_at < FROM_UNIXTIME(?) AND status = 'pending'";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $expiredTime);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $paymentId = $row['payment_id'];

    $status = getPaymentStatus($paymentId);
		// If finished or confirming, update Balance
		if($status === "finished" || $status === "confirmed"){
      // USER ID
			$user = UserInfo($_SESSION['user_id']);
			$current_id = $user["id"];
			$payment = PaymentInfo($paymentId);
			$payment_balance =  $user["balance"]+$payment["amount"];

			UpdateBalance($current_id, $payment_balance);

      // Update payment status to 'cancelled' in the database
      $updateStmt = $db->prepare("UPDATE payments SET status = 'completed' WHERE payment_id = ?");
		} else {
      // Update payment status to 'cancelled' in the database
      $updateStmt = $db->prepare("UPDATE payments SET status = 'cancelled' WHERE payment_id = ?");
    }
}
$updateStmt->bind_param('i', $paymentId);
$updateStmt->execute();
$updateStmt->close();
$stmt->close();
$db->close();
?>
