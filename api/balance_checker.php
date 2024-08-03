<?php

// Include the necessary functions and database connection
include '../archives/db_connect.php';
include '../archives/functions.php';

// Only handle $_POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['license'])) {
  // Get the POST data
  $license_key = $_POST['license'];

  // Check balance
  $result = balance_checker($license_key);

  if ($result === null) {
      echo json_encode(['status' => 'error', 'message' => 'Invalid license key']);
  } else {
      $balance = $result['balance'];
      $trunk = $result['trunk'];  // Ajuste aquí

      if ($balance > 0) {
          echo json_encode(['status' => 'success', 'minutes' => "$balance", 'trunk' => $trunk["trunk_name"], 'trunk_role' => $trunk["trunk_role"]]);  // Ajuste aquí
      } elseif ($balance == 0) {
          echo json_encode(['status' => 'error', 'message' => 'You need to deposit to start calling. Go to the website and buy balance']);  // Ajuste aquí
      } elseif ($balance < 0) {
          echo json_encode(['status' => 'success', 'message' => 'You have a negative balance. Contact support', 'minutes' => "$balance", 'trunk' => $trunk["trunk_name"], 'trunk_role' => $trunk["trunk_role"]]);  // Ajuste aquí
      } elseif($balance && !$trunk) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid License Key']);  // Ajuste aquí
      } else {
          echo json_encode(['status' => 'error', 'message' => 'There was an error retrieving your current balance']);  // Ajuste aquí
      }
  }
} else {
  header("Location: ../");
}
?>
