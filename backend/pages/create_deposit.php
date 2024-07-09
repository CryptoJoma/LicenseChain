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
        a:hover, button:hover {
            color: #0DFF92; /* Neon Green */
        }

       

        /* Updated styles for the table */
        table {
            background-color: #1A1A1A;
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

        th, td {
            color: #0DFF92;
        }

        /* Updated styles for the form */
        .form-dark {
            background-color: #1A1A1A;
            color: #0DFF92;
        }

        .form-dark input, .form-dark textarea {
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
    <form action="" method="post">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="date">Date:</label>
        <input type="datetime-local" id="date" name="date" required><br><br>

        <label for="method">Method:</label>
        <select id="method" name="method" required>
            <option value="cash">Cash</option>
            <option value="credit">Credit</option>
            <!-- Add more options as needed -->
        </select><br><br>

        <label for="userID_FK">User ID:</label>
        <input type="number" id="userID_FK" name="userID_FK" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $amount = $_POST['amount'];
        $date = $_POST['date'];
        $method = $_POST['method'];
        $userID_FK = $_POST['userID_FK'];

        // Create JSON payload
        $data = array(
            'id' => 0,
            'amount' => $amount,
            'date' => $date,
            'method' => $method,
            'userID_FK' => $userID_FK
        );

        // Convert data to JSON format
        $json_data = json_encode($data);

        // URL of the API endpoint
        $api_url = 'http://localhost:5236/api/Depositos/';

        // Initialize cURL session
        $ch = curl_init($api_url);

        // Set the request method to POST
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the POST data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

        // Set the Content-Type header
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        // Check if the request was successful
        if ($response === false) {
            echo "Error: Unable to create deposit.";
        } else {
            echo "Minutes created successfully.";
        }
    }
    ?>
</body>

</html>
