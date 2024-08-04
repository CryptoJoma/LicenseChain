<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS: Tailwind, Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono&display=swap" rel="stylesheet">

    <title>Bot Dashboard</title>
    <style>
        body {
            background-color: #121212;
            color: #0DFF92; /* Neon Green */
            font-family: 'IBM Plex Mono', monospace;
        }

        .bg-dark {
            background-color: #1A1A1A; /* Slightly Lighter Black */
        }

        /* Neon colors for text */
        .text-blue-neon {
            color: #0DB8DE; /* Neon Blue */
        }

        .text-green-neon {
            color: #0DFF92; /* Neon Green */
        }

        .text-red-neon {
            color: #FF2C55; /* Neon Red */
        }

        .text-purple-neon {
            color: #9400D3; /* Neon Purple */
        }

        /* Hover styles */
        a:hover,
        button:hover {
            color: #0DFF92; /* Neon Green */
        }

        /* Updated styles for the table */
        table {
            background-color: #1A1A1A;
            color: #0DFF92;
        }

        thead {
            background-color: #121212;
        }

        tbody tr {
            background-color: #1A1A1A;
        }

        tbody tr:nth-child(odd) {
            background-color: #2A2A2A;
        }

        th,
        td {
            padding: 8px 4px;
        }

        /* Updated styles for the form */
        .form-dark {
            background-color: #1A1A1A;
            color: #0DFF92;
        }

        .form-dark input,
        .form-dark textarea {
            background-color: #2A2A2A;
            color: #0DFF92;
        }
    </style>
</head>

<body>
    <div class="container mx-auto mt-10 p-5">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-3">🤖 LaGuagua 2.0</h1>
            <p class="text-lg text-white">Navigating the old money lanes, we master the game. Let's expand the empire.</p>
        </div>
        <!-- Top Navigation -->
        <div class="bg-dark p-3 rounded-xl shadow-lg mb-4">
            <ul class="flex justify-between items-center">
                <li><a class="text-xl px-6 py-2 leading-normal bg-dark hover:text-blue-neon rounded" href="main.php">🔧 Dashboard</a></li>
                <li><a class="text-xl px-6 py-2 leading-normal bg-dark hover:text-blue-neon rounded" href="licenses.php">🔑 Bots & Deposits</a></li>
                <li><a class="text-xl px-6 py-2 leading-normal bg-dark hover:text-blue-neon rounded" href="minutes.php">⏱️ Minutes</a></li>
                <li><a class="text-xl px-6 py-2 leading-normal bg-dark hover:text-blue-neon rounded" href="https://t.me/Kurogani" target="_blank">🤝 Support</a></li>
                <li><a class="text-xl px-6 py-2 leading-normal bg-dark hover:text-blue-neon rounded" href="profile.php">👤 Profile</a></li>
            </ul>
        </div>
        <!-- Main Dashboard Layout -->
        <div class="flex">
            <!-- Sidebar with Navigation and Balance/Progress Bars -->
            <div class="w-1/4 p-3 bg-dark rounded-xl shadow-lg mr-4">
                <!-- Balance and Progress Bars -->
                <div class="mt-4">
                    <h2 class="text-xl font-bold mb-4 text-white">Your Stats</h2>
                    <h2 class="text-xl font-bold mb-4 text-white" id="Balance">Balance: Loading...</h2>

                    <p id="minutes" class="text-white">Loading minutes...</p>
                    <p class="text-white">703/2000 Minutes</p>
                    <div class="bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-4">
                        <div id="minutesProgressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: 35%"></div>
                    </div>

                    <h2 class="text-xl font-bold mb-4 text-white">New Licenses</h2>
                    <!-- Bot: Basic -->
                    <p class="text-white">Bot: Basic</p>
                    <p class="text-white">1/7 Days</p>
                    <div class="bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 14.29%"></div>
                    </div>

                    <!-- Bot: Medium -->
                    <p class="text-white">Bot: Medium</p>
                    <p class="text-white">3/7 Days</p>
                    <div class="bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 42.86%"></div>
                    </div>

                    <!-- Licenses Soon to Expire -->
                    <h2 class="text-xl font-bold mb-4 text-white">Licenses Soon to Expire</h2>
                    <ul id="soonToExpireLicenses" class="text-white"></ul>
                </div>
            </div>
            <!-- Main Content -->
            <div class="w-3/4 p-3 bg-dark rounded-xl shadow-lg">

                <!-- Botones -->
                <div class="my-4 flex justify-center md:space-x-4 flex-wrap">
                    <!-- Modified Purchase Bot button -->
                    <button id="purchaseBotBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-2">Purchase Bot</button>
                    <!-- <a class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded m-2" href="create_deposit.php">Deposit</a> -->
                    <a class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded m-2" href="https://nowpayments.io/pos-terminal/guaguapos" target="_blank" rel="noopener noreferrer">Deposit</a>


                </div>
                <!-- Licenses Table -->
                <div class="my-8">
                    <h2 class="text-2xl font-bold mb-4">Licenses List</h2>
                    <table class="w-full rounded-lg shadow-lg table-auto bg-dark">
                        <thead class="text-white">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">KEY</th>
                                <th class="px-4 py-2">METHOD</th>
                                <th class="px-4 py-2">DATE</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-200">
                            <!-- Ejemplo de fila -->
                            <?php
                            // Database connection
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "guagua";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Fetch licenses data
                            $sql = "SELECT id, `key`, script, issued FROM licencias WHERE expiry > NOW()";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>{$row['id']}</td>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>{$row['key']}</td>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>{$row['script']}</td>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>{$row['issued']}</td>";
                                    echo "<td class='border px-4 py-2 text-center text-blue-500 hover:text-blue-700 cursor-pointer'>Reset</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='border px-4 py-2 text-center text-white'>No licenses found</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Fetch balance and minutes data from the PHP server
    fetch('get_balance_and_minutes.php')
        .then(response => response.json())
        .then(data => {
            const balance = data.Balance;
            const minutesBalance = data.amount;

            // Update the balance section with the received balance amount
            document.getElementById('Balance').textContent = `Balance: $${balance}`;

            // Update the DOM with the minutes balance
            document.getElementById('amount').textContent = `Minutos: ${minutesBalance}`;

            // Calculate and update the progress bar width based on the minutes balance
            const progressBarWidth = (minutesBalance / 2000) * 100; // Assuming 2000 is the total minutes
            document.getElementById('minutesProgressBar').style.width = `${progressBarWidth}%`;
        })
        .catch(error => {
            console.error('Error fetching balance and minutes data:', error);
        });

    // Fetch licenses soon to expire
    fetch('get_licenses_soon_to_expire.php')
        .then(response => response.json())
        .then(data => {
            const licensesList = document.getElementById('soonToExpireLicenses');
            licensesList.innerHTML = ''; // Clear existing list
            data.forEach(license => {
                const listItem = document.createElement('li');
                listItem.textContent = `License Key: ${license.key}`;
                licensesList.appendChild(listItem);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });

    // Add an event listener to the Purchase Bot button
    document.getElementById('purchaseBotBtn').addEventListener('click', function() {
        // Fetch balance from the DOM
        const balanceText = document.getElementById('Balance').textContent;
        const balance = parseFloat(balanceText.replace('Balance: $', ''));

        // Check if balance is less than 100
        if (balance < 100) {
            // Alert insufficient funds
            alert('Fondos insuficientes');
            return; // Exit function
        }

        // Send a POST request to purchase a bot
        fetch('purchase_bot.php', {
            method: 'POST',
        })
        .then(response => {
            // Check if the response is successful
            if (response.ok) {
                // Handle successful response
                console.log('Bot purchased successfully.');
                // Refresh the page
                window.location.reload();
            } else {
                // Handle unsuccessful response
                console.error('Failed to purchase bot:', response.statusText);
                window.location.reload();
            }
        })
        .catch(error => {
            // Handle network errors
            console.error('Error purchasing bot:', error);
            window.location.reload();
        });
    });
    </script>
</body>
</html>
