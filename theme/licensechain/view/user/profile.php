<?php

  // Verify if the user is logged
  if ($is_user === 0) {
    header("Location: /login");
  }

  // USER Id
  $row = $user;

  // TEMPLATE: Header
  include("./template/header.php");
?>
<div class="bd cont">
  <section class="section login">
    <div class="user-login">
      <div class="user-form">
        <header class="section-header">
          <h3 class="section-title">
          Hello <? echo $row['user']; ?>,
          </h3>
        </header>
                <!-- Balance and Progress Bars -->
                <div class="mt-4">
                    <h2 class="text-xl font-bold mb-4 text-white">Your Stats</h2>
                    <?

                        // Fetch balance
                        $balance = number_format($row["balance"], 2);
                        $user_id = $row['id'];

                        // Fetch licenses soon to expire
                        $sql_licenses = "SELECT `license_key` FROM licenses WHERE uid='$user_id' AND expiration_date >= NOW() + INTERVAL 0 DAY";
                        $result_licenses = $db->query($sql_licenses);
                    ?>
                    <p id="balance" class="text-white">Balance: $<?php echo $balance; ?></p>

                    <!-- Licenses Soon to Expire -->
                    <h2 class="text-xl font-bold mb-4 text-white">Licenses Soon to Expire</h2>
                    <ul id="soonToExpireLicenses" class="text-white">
                        <?php
                            if ($result_licenses->num_rows > 0) {
                                while($row = $result_licenses->fetch_assoc()) {
                                    echo "<li>License Key: " . $row['license_key'] . "</li>";
                                }
                            } else {
                                echo "<li>No licenses soon to expire</li>";
                            }
                        ?>
                    </ul>
                </div>
              </div>
              <div class="user-why">
              <figure class="bg"><img src="https://licensechain.app/assets/bg.webp" alt="bg"></figure>
              <header class="section-header">
                <h3 class="section-title">How to buy?</h3>
              </header>
              <p class="fa-check-b">By contacting our team, they will provide you a license.</p>
              <p class="fa-check-b">We accept USDT / USDC (TRC-20)</p>
              <p class="fa-check-b">We will update your license as soon as the payment is accredited into our account.</p>
              </div>
            </div>
          </section>
        </div>
<?php
  // TEMPLATE: Footer
  include("./template/footer.php");

  // Close the database connection here
  $db->close();
?>
