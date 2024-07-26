<?php

if (!isset($_SESSION["islogged"])) {
  if (!$_GET["username"]) {
    $error = 1;
  } else {
    // Check if Telegram callback parameters are set
    if (isset($_GET['auth_date'], $_GET['id'], $_GET['first_name'], $_GET['username'], $_GET['hash'])) {
        try {
            // Validation Data from Telegram
            $auth_data = checkTelegramAuthorization($_GET);

            if ($auth_data) {
                // Data is valid, proceed with registration
                $tg_id = $_GET['id'];
                $username = $auth_data['username'];
                $first_name = $auth_data['first_name'];

                // Fetch user from database
                $is_user = count_rows("users_login", "tg_id = '$tg_id'");

                if ($is_user === 0) {
                  // Insert user into the database
                  $insert_stmt = $db->prepare("INSERT INTO users_login (tg_id, user, full_name) VALUES (?, ?, ?)");
                  if (!$insert_stmt) {
                      $msg = htmlspecialchars($db->error);
                      $error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Prepare failed: $msg</p>";
                  } else {
                      $insert_stmt->bind_param("sss", $tg_id, $username, $first_name);
                      if (!$insert_stmt->execute()) {
                          $msg = htmlspecialchars($insert_stmt->error);
                          $error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Execute failed: $msg</p>";
                      } else {
                        // Send a welcome message
                        sendTelegramMessage($tg_id, "Welcome to our service, $first_name!", 'https://licensechain.app/assets/tg_image.webp');

                        // Add user to channel
                        // Note: This typically requires admin privileges or direct user interaction
                        // AddUserToChannel($tg_id);

                        // Update last_login
                        UserLastLogin($tg_id);

                        // SET $_SESSION TO NAVIGATE
                        $_SESSION['user_id'] = $tg_id;
                        $_SESSION["islogged"] = 1;
                        header('Location: /');
                        exit(); // Ensure no further code is executed

                      }
                      $insert_stmt->close();
                  }
                }

            } else {
                $error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Error: Invalid Data</p>";
            }
        } catch (Exception $e) {
            $error_msg = $e->getMessage();
            $error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Error: $error_msg</p>";
        }
    } else {
      $error = "<p class=\"msg-d\"><i class=\"fa-times\"></i> Error: Invalid User Data</p>";
    }
  }

  if ($error) {
    // TEMPLATE: Header
    include("./template/header.php");
    // Insert Login here
?>
<div class="bd cont">
  <section class="section login">
    <div class="user-login">
      <div class="user-form">
        <header class="section-header">
          <h3 class="section-title">
          Login
          </h3>
        </header>
        <? echo ($error != 1) ? $error : ''; ?>
        <form method="post" action="/login">
          <p class="msg-s" style="color: #0de383;"><i class="fa-heart"></i> Remember: You need to start a chat with our <a href="https://t.me/LicenseChainBot" target="_blank" style="color: white;">bot</a> first.</p>
          <p class="forget">
            <script async src="https://telegram.org/js/telegram-widget.js" data-telegram-login="<?= BOT_USERNAME ?>" data-size="large" data-auth-url="/login"></script>
          </p>
        </form>
      </div>
      <div class="user-why">
      <figure class="bg"><img src="https://licensechain.app/assets/bg.webp" alt="bg"></figure>
      <header class="section-header">
        <h3 class="section-title">Why register?</h3>
      </header>
      <p class="fa-check-b">By registering you will be able to purchase a license and manage it.</p>
      <p class="fa-check-b">You can get licenses of any type and for as long as you need!</p>
      <p class="fa-check-b">We will know you exist and that will help us to know your needs and support you in the right way.</p>
      </div>
    </div>
  </section>
</div>
<?php
  // TEMPLATE: Footer
  include("./template/footer.php");
  } else {
    // Update last_login
    UserLastLogin($tg_id);

    // SET $_SESSION TO NAVIGATE
    $_SESSION['user_id'] = $tg_id;
    $_SESSION["islogged"] = 1;
    header('Location: ./home');
    exit(); // Ensure no further code is executed
  }
} else {
  header('Location: ./home');
  exit(); // Ensure no further code is executed
}

// Close the database connection here
$db->close();
?>
