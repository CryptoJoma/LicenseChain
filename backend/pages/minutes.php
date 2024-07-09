<?php

  // Verify if the user is logged
  if (!isset($_SESSION["islogged"])) {
    header("location: ./login");
  }

  // USER Id
  $current_id = $_SESSION['user_id'];

  // Get data
  $stmt = $db->prepare("SELECT balance, minutes, user FROM users_login WHERE id = ?");
  $stmt->bind_param("s", $current_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  // TEMPLATE: Header
  include("./template/header.php");
?>

<div class="bd cont">
  <section class="section login">
    <div class="user-login">
      <div class="user-form">
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
              <div class="user-why">

                <div class="bg-dark overflow-hidden shadow-xl rounded-lg px-4 py-6 mx-auto max-w-md mt-8 text-center border border-gray-700">
                    <h2 class="text-green-neon font-bold text-4xl mb-4">Passage Details</h2>
                    <div class="grid grid-cols-2 gap-4">
<table class="w-full rounded-lg shadow-lg table-auto bg-dark">

                    <tbody class="text-gray-200">
                        <tr>
                            <td class="border px-4 py-2 text-center text-white">Minutes Price</td>
                            <td class="border px-4 py-2 text-center text-white">0.0010</td>




                        </tr><tr>
                            <td class="border px-4 py-2 text-center text-white">Balance Remaining</td>
                            <td class="border px-4 py-2 text-center text-white">114.134</td>




                        </tr><tr>
                            <td class="border px-4 py-2 text-center text-white">Minutes Remaining</td>
                            <td class="border px-4 py-2 text-center text-white">114134</td>




                        </tr>
                    </tbody>
                </table>
                    </div>
                    <div class="mt-4">
                        <span class="text-gray-400 text-sm"> The rate is charged per full minute, not per second, if you make a call of 6 seconds you are charged the full minute, if the call lasts 61 seconds you are charged 2 minutes. </span>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="my-4 flex justify-center space-x-4">
                    <a class="text-xl px-6 py-2 leading-normal bg-dark hover:text-blue-neon rounded" href="create_minutes.php">Buy Minutes</a>
                    <!-- <a class="text-xl px-6 py-2 leading-normal bg-dark hover:text-blue-neon rounded" href="https://nowpayments.io/pos-terminal/guaguapos" target="_blank" rel="noopener noreferrer">Buy Minutes</a> -->
                </div>

                <!-- Deposit Table -->
                <div class="my-8">
                    <h2 class="text-2xl font-bold mb-4">Deposit History</h2>

                    <table class="w-full rounded-lg shadow-lg table-auto bg-dark">
                        <thead class="text-white">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">AMOUNT</th>
                                <th class="px-4 py-2">METHOD</th>
                                <th class="px-4 py-2">DATE</th>
                                <th class="px-4 py-2">USER ID</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-200">
                            <?php
                            // Database connection settings
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

                            // SQL query to fetch data from the minutos table
                            $sql = "SELECT id, amount, date, method, userid_fk FROM minutos";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>" . $row["id"] . "</td>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>" . $row["amount"] . "</td>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>" . $row["method"] . "</td>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>" . $row["date"] . "</td>";
                                    echo "<td class='border px-4 py-2 text-center text-white'>" . $row["userid_fk"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='border px-4 py-2 text-center text-white'>No data found</td></tr>";
                            }

                            // Close the database connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table></div></div>
            </div>
          </section>
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
<?php
  // TEMPLATE: Footer
  include("./template/footer.php");

  // Close the database connection here
  $db->close();
?>
