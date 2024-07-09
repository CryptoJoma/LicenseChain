<script>
// Fetch data from the API for balance
fetch('http://localhost:5236/api/Depositos/2')
    .then(response => response.json())
    .then(data => {
        // Extract balance from the response
        const balance = data.balance;

        // Update the balance section with the received balance amount
        document.getElementById('balance').textContent = `Balance: $${balance}`;
    })
    .catch(error => {
        console.error('Error:', error);
    });


    fetch('http://localhost:5236/api/Minutos/2')
    .then(response => response.json())
    .then(data => {
        // Extract the minutes balance from the response
        const minutesBalance = data;

        // Update the DOM with the minutes balance
        document.getElementById('minutes').textContent = `Minutos: $${minutesBalance}`;

        // Calculate and update the progress bar width based on the minutes balance
                  // Calculate and update the progress bar width based on the minutes balance
                  const progressBarWidth = (minutesBalance / 2000) * 100; // Assuming 2000 is the total minutes
        document.getElementById('minutesProgressBar').style.width = `${progressBarWidth}%`;

    })
    .catch(error => {
        console.error('Error fetching minutes data:', error);
    });



// Fetch licenses soon to expire
fetch('http://localhost:5236/api/Licencias/SoontoExpire')
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
    const balanceText = document.getElementById('balance').textContent;
    const balance = parseFloat(balanceText.replace('Balance: $', ''));

    // Check if balance is less than 100
    if (balance < 100) {
        // Alert insufficient funds
        alert('Fondos insuficientes');
        return; // Exit function
    }

    // Send a POST request to http://localhost:5236/api/Licencias
    fetch('http://localhost:5236/api/Licencias', {
        method: 'POST',
    })
    .then(response => {
        // Check if the response is successful
        if (response.ok) {
            // Handle successful response
            console.log('Bot purchased successfully.');
            // You can perform additional actions here if needed
        } else {
            // Handle unsuccessful response
            console.error('Failed to purchase bot:', response.statusText);
        }
    })
    .catch(error => {
        // Handle network errors
        console.error('Error purchasing bot:', error);
    });
});
</script>
