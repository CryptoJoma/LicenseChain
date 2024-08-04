<?php

// USER Id
$current_id = $user["id"];

// License
$license = LicenseInfo($current_id, 69);
if($license) {
  $status_license = true;
  $license_key = $license["license_key"];
  $min_pcs = $license["macs_limit"];
} else {
  $status_license = false;
  $min_pcs = 1;
}
?>
<style>
  /* Modal Background */
  #membership-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
  }

  /* Modal Content */
  #membership-modal .modal-content {
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      max-width: 500px;
      margin: auto;
      position: relative;
  }
</style>

<div class="bd cont">
  <section class="section login">
    <!-- Main Content -->
    <div class="flex flex-col md:flex-row">
        <!-- Main Content Area -->
        <div class="w-full p-3 bg-dark rounded-xl shadow-lg">
          <div class="flex items-center justify-center"><header class="section-header">
            <h3 class="section-title">Balance: $<span id="totalBalance" style="font-size: 1.5rem;color: var(--link);margin-bottom: 0;line-height: 2rem;clear: both;padding: .25rem 0;margin-right: 1rem;"><? echo number_format($user["balance"], 2); ?></span></h3>
            <? if(!$status_license){ ?>
              <button class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded m-2" id="open-modal">Activate Membership</button>
            <? } ?>
          </header></div>
            <? if($status_license){ ?>
            <!-- Calls Hourly Table -->
            <div class="my-8" id="membership-details">

                <div class="bg-dark overflow-hidden shadow-xl rounded-lg px-4 py-6 mx-auto mt-8 text-center border border-gray-700">
                  <h2 class="text-green-neon font-bold text-4xl mb-4">Membership Details</h2>
                  <div class="flex justify-center">
                      <table class="w-full max-w-4xl rounded-lg shadow-lg table-auto bg-dark">
                          <tbody class="text-gray-200">
                              <tr>
                                  <td class="border px-4 py-2 text-center text-white">Token License</td>
                                  <td class="border px-4 py-2 text-center text-white"><? echo $license["license_key"]; ?></td>
                              </tr>
                              <tr>
                                  <td class="border px-4 py-2 text-center text-white">Total PCs</td>
                                  <td class="border px-4 py-2 text-center text-white"><? echo count_rows("license_usage", "license_key='$license_key'"); ?>/<? echo $license["macs_limit"]; ?></td>
                              </tr>
                              <tr>
                                  <td class="border px-4 py-2 text-center text-white">Expiration Date</td>
                                  <td class="border px-4 py-2 text-center text-white"><? echo $license["expiration_date"]; ?> (UTC Time)</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
                  <div class="my-4 flex justify-center md:space-x-4 flex-wrap">
                      <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded m-2">Download Console CLI</button>
                      <button class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded m-2" id="open-modal">Update Membership</button>
                  </div>
                </div>
            </div>
            <? } else { ?>
              <!-- Buttons for Actions -->
              <div class="my-4 flex justify-center md:space-x-4 flex-wrap">
                <p class="msg-w"><i class="fa-heart"></i> Remember: Activate your <span style="color: white;">membership</span> to access to the <span style="color: white;">BOT</span></p>
              </div>
            <? } ?>
        </div>
    </div>
  </section>
</div>

<!-- Modal activate membership -->
<div id="membership-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50 hidden">
    <div class="bg-dark rounded-lg shadow-lg w-11/12 max-w-lg p-6">
        <div class="flex justify-end">
            <button id="close-modal" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <h2 class="text-xl font-bold mb-4">Activate Membership</h2>
        <form id="activation-form" class="space-y-4">
            <!-- Days Dropdown -->
            <div>
                <label for="days" class="block text-sm font-medium text-gray-300 mb-1">Days?</label>
                <select id="days" name="days" class="block w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-green-500">
                    <option value="15">15 days - $100 (1 PC)</option>
                    <option value="30">30 days - $200 (1 PC)</option>
                </select>
            </div>
            <!-- Number of PCs and Total Amount to Pay -->
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="pcs" class="block text-sm font-medium text-gray-300 mb-1">How many PCs?</label>
                    <input id="pcs" name="pcs" type="number" min="<? echo $min_pcs; ?>" class="block w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-green-500" style="width: 13.5rem;" required>
                </div>
                <div class="flex-1">
                    <label for="total-amount" class="block text-sm font-medium text-gray-300 mb-1">Total Amount to Pay</label>
                    <input id="total-amount" name="total-amount" type="text" class="block w-full bg-gray-700 text-white border border-gray-600 rounded py-2 px-3 focus:outline-none focus:border-green-500" readonly>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mt-4">
                <button id="confirm-activation" type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Confirm</button>
                <button id="cancel-activation" type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Script for modal functionality and form handling -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get modal element
        var modal = document.getElementById('membership-modal');
        var openModalButton = document.getElementById('open-modal');
        var closeModalButton = document.getElementById('close-modal');
        var cancelButton = document.getElementById('cancel-activation');
        var membershipDetails = document.getElementById('membership-details');
        var daysSelect = document.getElementById('days');
        var pcsInput = document.getElementById('pcs');
        var totalAmountInput = document.getElementById('total-amount');
        var confirmButton = document.getElementById('confirm-activation');

        // Function to update the total amount to pay
        function updateTotalAmount() {
            var days = parseInt(daysSelect.value);
            var pcs = parseInt(pcsInput.value);
            var totalAmount = 0;

            if (days === 15) {
                totalAmount = 100 + (pcs - 1) * 50; // Base price + extra PCs
            } else if (days === 30) {
                totalAmount = 200 + (pcs - 1) * 75; // Base price + extra PCs
            }

            totalAmountInput.value = '$' + totalAmount;
        }

        // Open modal event
        openModalButton.addEventListener('click', function() {
            modal.classList.remove('hidden');
        });

        // Close modal event
        closeModalButton.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        cancelButton.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Update total amount on input change
        daysSelect.addEventListener('change', updateTotalAmount);
        pcsInput.addEventListener('input', updateTotalAmount);

        // Confirm button event
        confirmButton.addEventListener('click', function(event) {
            event.preventDefault();

            // Make an API call to update the license
            fetch('/api/update_elite_license.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    days: daysSelect.value,
                    pcs: pcsInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show the membership details
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(() => {
                alert('Try again later, or contact support');
            });
        });
    });
</script>
