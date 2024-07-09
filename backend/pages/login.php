<?php

if (!isset($_SESSION["islogged"])) {
  if (!$_POST) {
    $error = 1;
  } else {
    // USER DATA
    $user = $_POST["user"];
    $pass = $_POST["password"];
    // Fetch user from database
    $stmt = $db->prepare("SELECT password, id, role FROM users_login WHERE user = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if (empty($user)) {
      $error = '<p class="msg-d"><i class="fa-times"></i> No haz ingresado el usuario</p>';
    } elseif (empty($pass)) {
      $error = '<p class="msg-d"><i class="fa-times"></i> No haz ingresado tu contraseña</p>';
    } elseif ($result->num_rows === 0) {
      $error = '<p class="msg-d"><i class="fa-times"></i> Esta cuenta no existe</p>';
    } else {
      $row = $result->fetch_assoc();
      $pass_user = $row['password'];
      if (password_verify($pass, $pass_user)) {
        $user_id = $row['id'];
        $user_role = $row['role'];
        $error = NULL;
      } else {
        $error = '<p class="msg-d"><i class="fa-times"></i> La contraseña es incorrecta</p>';
      }
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
          Login <span><a href="/register">Register</a></span>
          </h3>
        </header>
        <? echo ($error != 1) ? $error : ''; ?>
        <form method="post" action="/login">
          <p>
            <label for="user">User</label>
            <input id="user" name="user" type="text" placeholder="User">
          </p>
          <p>
            <label for="pass">Password</label>
            <input id="password" name="password" type="password" placeholder="Password">
          </p>
          <p class="forget">
            <a href="/forgot">Forgot Password</a>
            <button type="submit" class="btn send-btn">Submit</button>
          </p>
        </form>
      </div>
      <div class="user-why">
      <figure class="bg"><img src="https://licenses.joma.dev/assets/bg.webp" alt="bg"></figure>
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
    $update_stmt = $db->prepare("UPDATE users_login SET last_login = ? WHERE user = ?");
    $last_login_time = time();
    $update_stmt->bind_param("is", $last_login_time, $user);
    $update_stmt->execute();
    $update_stmt->close();

    // SET $_SESSION TO NAVIGATE
    $_SESSION['user_id'] = $user_id;
    $_SESSION['role'] = $user_role;
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
