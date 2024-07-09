<?php

  // Verify if the user is logged
  if (!isset($_SESSION["islogged"])) {
    header("location: ./login");
  }
  
  // TEMPLATE: Header
  include("./template/header.php");
?>
<!-- Main Content -->
<div class="flex flex-col md:flex-row">
    <!-- Main Content Area -->
    <div class="w-full md:w-3/4 p-3 bg-dark rounded-xl shadow-lg">
        <!-- Badges and Stats -->
        <!-- <div class="mb-8 flex flex-wrap justify-center md:space-x-4">
            <span class="p-4 bg-dark text-green-neon rounded-lg shadow text-center m-2">
                <p class="text-xl md:text-2xl font-bold">150</p>
                <p>📞 Calls Created</p>
            </span>
            <span class="p-4 bg-dark text-blue-neon rounded-lg shadow text-center m-2">
                <p class="text-xl md:text-2xl font-bold">120</p>
                <p>📲 Calls Answered</p>
            </span>
            <span class="p-4 bg-dark text-purple-neon rounded-lg shadow text-center m-2">
                <p class="text-xl md:text-2xl font-bold">100</p>
                <p>✅ Calls Confirmed</p>
            </span>
            <span class="p-4 bg-dark text-red-neon rounded-lg shadow text-center m-2">
                <p class="text-xl md:text-2xl font-bold">80</p>
                <p>🔑 Calls OTP</p>
            </span>
        </div> -->
        <!-- Buttons for Actions -->
        <div class="my-4 flex justify-center md:space-x-4 flex-wrap">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-2">Download Launcher GUI</button>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded m-2">Download Console CLI</button>
        </div>
        <!-- Calls Hourly Table -->
        <div class="my-8">
            <h2 class="text-2xl font-bold mb-4">Calls Hourly</h2>
            <div class="overflow-x-auto">
                <table class="w-full rounded-lg shadow-lg table-auto bg-dark">
                    <thead class="text-white">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Hour</th>
                            <th class="px-4 py-2 hidden sm:table-cell">Calls Created</th>
                            <th class="px-4 py-2 hidden sm:table-cell">Calls Answered</th>
                            <th class="px-4 py-2 hidden sm:table-cell">Calls Confirmed</th>
                            <th class="px-4 py-2">Calls OTP</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-200">
                        <tr>
                            <td class="border px-4 py-2 text-center text-white">7</td>
                            <td class="border px-4 py-2 text-center text-white">17:00</td>
                            <td class="border px-4 py-2 text-center text-white hidden sm:table-cell">150</td>
                            <td class="border px-4 py-2 text-center text-white hidden sm:table-cell">120</td>
                            <td class="border px-4 py-2 text-center text-white hidden sm:table-cell">100</td>
                            <td class="border px-4 py-2 text-center text-green-500">80</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="w-full md:w-1/4 p-3 bg-dark rounded-xl shadow-lg mb-4 md:mb-4 md:mr-4 px-4 md:mx-4">
        <div class="mt-4">
            <h2 class="text-xl font-bold mb-4 text-white">Your Stats</h2>
            <h3 class="text-lg font-bold mb-2 text-white" id="balance">Balance: $</h3>

            <p id="minutes" class="text-white">Loading minutes...</p>
            <p class="text-white">703/2000 Minutes</p>
            <div class="bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-4">
                <div id="minutesProgressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: 35%"></div>
            </div>

            <h3 class="text-lg font-bold mb-2 text-white">New Licenses</h3>
            <p class="text-white">Bot: Basic - 1/7 Days</p>
            <div class="bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-4">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 14.29%"></div>
            </div>
            <p class="text-white">Bot: Medium - 3/7 Days</p>
            <div class="bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-4">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 42.86%"></div>
            </div>
            <h3 class="text-lg font-bold mb-2 text-white">Licenses Soon to Expire</h3>
            <ul id="soonToExpireLicenses" class="text-white"></ul>
        </div>
    </div>
</div>
<?php
  // TEMPLATE: Footer
  include("./template/footer.php");
?>
