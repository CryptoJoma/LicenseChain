<?php
define('NOWPAYMENTS_API_KEY', 'YOUR_NOWPAYMENTS_API_KEY');

function updatePaymentStatus($paymentId, $status)
{
    $servername = "your_servername";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE payments SET status = :status WHERE payment_id = :payment_id";
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':status' => $status,
            ':payment_id' => $paymentId
        ]);

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function checkPaymentStatus($paymentId)
{
    $url = "https://api.nowpayments.io/v1/payment/$paymentId";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'x-api-key: ' . NOWPAYMENTS_API_KEY
    ]);

    $result = curl_exec($ch);
    curl_close($ch);

    if ($result === FALSE) {
        return false;
    }

    return json_decode($result, true);
}

function checkAllPayments()
{
    $servername = "your_servername";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT payment_id FROM payments WHERE status = 'created' OR status = 'pending'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($payments as $payment) {
            $paymentId = $payment['payment_id'];
            $paymentStatus = checkPaymentStatus($paymentId);

            if ($paymentStatus !== false && isset($paymentStatus['payment_status'])) {
                updatePaymentStatus($paymentId, $paymentStatus['payment_status']);
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

checkAllPayments();
?>
