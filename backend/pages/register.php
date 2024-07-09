<?php

if (isset($_SESSION["islogged"])) {
    header('Location: /');
    exit();
}

if ($_POST) {
    // USER DATA
    $user = $_POST["user"];
    $pass = $_POST["password"];
    $pass_confirm = $_POST["password_confirm"];
    $email = $_POST["email"];

    // Check if user already exists
    $stmt = $db->prepare("SELECT user FROM users_login WHERE user = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if (empty($user)) {
        $error = '<p class="msg-d"><i class="fa-times"></i> No haz ingresado el usuario</p>';
    } elseif (empty($pass)) {
        $error = '<p class="msg-d"><i class="fa-times"></i> No haz ingresado tu contraseña</p>';
    } elseif ($pass !== $pass_confirm) {
        $error = '<p class="msg-d"><i class="fa-times"></i> Las contraseñas no coinciden</p>';
    } elseif ($result->num_rows > 0) {
        $error = '<p class="msg-d"><i class="fa-times"></i> El usuario ya existe</p>';
    } else {
        // Hash the password
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // Insert user into the database
        $insert_stmt = $db->prepare("INSERT INTO users_login (user, password, email) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("sss", $user, $hashed_pass, $email);
        $insert_stmt->execute();
        $insert_stmt->close();

        // Registration successful, redirect to login
        header('Location: /login');
        exit();
    }
}

// TEMPLATE: Header
include("./template/header.php");
?>
<div class="bd cont">
  <section class="section login">
    <div class="user-login">
      <div class="user-form">
        <header class="section-header">
          <h3 class="section-title">
          Register <span><a href="/login">Login</a></span>
          </h3>
        </header>
        <?php echo isset($error) ? $error : ''; ?>
        <form method="post" action="/register">
          <p>
            <label for="user">User</label>
            <input id="user" name="user" type="text" placeholder="User">
          </p>
          <p>
            <label for="email">Email</label>
            <input id="email" name="email" type="text" placeholder="Email">
          </p>
          <p>
            <label for="pass">Password</label>
            <input id="password" name="password" type="password" placeholder="Password">
          </p>
          <p>
            <label for="pass_confirm">Confirm Password</label>
            <input id="password_confirm" name="password_confirm" type="password" placeholder="Confirm Password">
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

// Close the database connection here
$db->close();
?>
