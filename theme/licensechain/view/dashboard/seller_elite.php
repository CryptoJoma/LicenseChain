<?php
// Verify if the user is logged
if (!isset($_SESSION["islogged"])) {
    header("Location: ./login");
    exit();
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
            <!-- Calls Hourly Table -->
            <div class="my-8" id="membership-details">

                <div class="bg-dark overflow-hidden shadow-xl rounded-lg px-4 py-6 mx-auto mt-8 text-center border border-gray-700">
                  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex justify-between"><input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-none shadow-none px-2 text-sm" placeholder="Buscar..." style="background-color: rgb(192, 192, 192); border: 1px solid black; font-family: &quot;Courier New&quot;, monospace;">
                      <button type="submit" class="inline-flex items-center px-4 bg-light hover:bg-light-dark rounded-sm">Invitar</button>
                    </div>
                    <table class="w-full">
                      <thead class="bg-primary-dark text-gray-200">
                          <tr>
                              <td class="py-4 px-4 uppercase">Name</td>
                              <td class="py-4 px-4 uppercase">Type</td>
                              <td class="py-4 px-4 text-center uppercase"></td>
                          </tr>
                      </thead>
                      <tbody class="divide-y divide-gray-200 text-gray-200">
                        <tr>
                          <td class="py-4 px-4 uppercase">lexi</td>
                          <td class="py-4 px-4 uppercase">sip</td>
                          <td class="text-center">
                            <button aria-label="Close" class="mr-2 hover:cursor-pointer hover:text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" viewBox="512 512 512 512" fill="currentColor"><!-- Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc. --><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"></path></svg></button>
                            <button class="mr-2 hover:cursor-pointer hover:text-gray-400"><svg class="svg-inline--fa fa-phone-volume fa-lg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="phone-volume" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="" fill="currentColor" d="M280 0C408.1 0 512 103.9 512 232c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-101.6-82.4-184-184-184c-13.3 0-24-10.7-24-24s10.7-24 24-24zm8 192a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm-32-72c0-13.3 10.7-24 24-24c75.1 0 136 60.9 136 136c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-48.6-39.4-88-88-88c-13.3 0-24-10.7-24-24zM117.5 1.4c19.4-5.3 39.7 4.6 47.4 23.2l40 96c6.8 16.3 2.1 35.2-11.6 46.3L144 207.3c33.3 70.4 90.3 127.4 160.7 160.7L345 318.7c11.2-13.7 30-18.4 46.3-11.6l96 40c18.6 7.7 28.5 28 23.2 47.4l-24 88C481.8 499.9 466 512 448 512C200.6 512 0 311.4 0 64C0 46 12.1 30.2 29.5 25.4l88-24z"></path></svg></button>
                            <button class="mr-2 hover:cursor-pointer hover:text-gray-400"><svg class="svg-inline--fa fa-trash fa-lg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path class="" fill="currentColor" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path></svg></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="my-4 flex justify-center md:space-x-4 flex-wrap">
                      <button class="bg-gray-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded m-2" id="open-modal">Add Route</button>
                  </div>
                </div>
            </div>
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

<?php
// Footer function
?>
