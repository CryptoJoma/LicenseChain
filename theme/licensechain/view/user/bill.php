<?php

// Verify if the user is logged
if ($is_user === 0) {
    header("Location: ./login");
    exit();
}

// TEMPLATE: Header
include("./template/header.php");
?>
<script>
    let checkInterval = 15000; // 15 seconds
    let intervalId = null;

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const amount = document.getElementById('amount').value;
            const currency = document.getElementById('currency').value;

            fetch('/api/payments_hook.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ amount, currency })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('payAmount').textContent = data.data.pay_amount;
                    document.getElementById('payAddress').textContent = data.data.pay_address;
                    document.getElementById('qrCode').src = data.data.qr_code;
                    document.getElementById('paymentDetails').style.display = 'block';

                    if (intervalId) {
                        clearInterval(intervalId);
                    }
                    checkPaymentStatus(data.data.payment_id);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    function checkPaymentStatus(paymentId) {
        intervalId = setInterval(() => {
            fetch(`/api/payments_hook.php?payment_id=${paymentId}`, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('paymentStatus').textContent = data.data.payment_status;
                    if (data.data.payment_status === 'finished' || data.data.payment_status === 'failed') {
                        clearInterval(intervalId); // Stop checking if payment is complete or failed
                    }
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }, checkInterval); // Check every 15 seconds
    }
</script>
<div class="bd cont">
  <section class="section login">
    <div class="user-login">
      <div class="user-form">
        <header class="section-header">
          <h3 class="section-title">
          Buy Balance
          </h3>
        </header>
                <!-- Balance and Progress Bars -->
                <div class="mt-4">
                  <form id="paymentForm">
                      <p class="msg-w"><i class="fa-heart"></i> Remember: Minimum deposit is <span style="color: white;">$10 USDt</span></p>
                      <label for="amount">Amount (USD):</label>
                      <p class="text-white" style="margin-bottom: 10px;">The final amount includes the network fee.</p>
                      <input type="number" id="amount" name="amount" min="10" style="min-width: 15rem;" required>
                      <label for="currency">Pay Currency:</label>
                      <select id="currency" name="currency" style="width: auto;min-width: 15rem;" required>
                        <option value="USDTTRC20">USDT (TRC20)</option>
                        <option value="TRX">Tron</option>
                        <option value="USDC">USDC (ERC20)</option>
                        <option value="ETH">ETH</option>
                        <option value="BTC">BTC</option>
                        <option value="LTC">LTC</option>
                        <option value="BRETTBASE">BRETT (Based Chain)</option>
                        <option value="DOGE">DOGECOIN</option>
                        <option value="SHIB">Shib Inu</option>
                      </select>
                      <br>
                      <button type="submit">Get Payment Details</button>
                  </form>
                </div>
              </div>
              <div class="user-why">
                <header class="section-header">
                  <h3 class="section-title">
                  Payment Details
                  </h3>
                </header>
                <div class="mt-4" id="paymentDetails" style="display:none;">
                    <img id="qrCode" alt="QR Code" style="margin-left: auto;margin-right: auto;margin-bottom: 25px;margin-top: 25px;">
                    <p class="fa-check-b">Payment Amount: <span id="payAmount"></span></p>
                    <p class="fa-check-b">Pay Address: <span id="payAddress"></span></p>
                    <p class="fa-check-b">Status: <span id="paymentStatus">Pending</span></p>
                </div>
              </div>
            </div>
          </section>
        </div>

<?php
// TEMPLATE: Footer
include("./template/footer.php");

// Close the database connection here
if (isset($db)) {
    $db->close();
}
?>
