<div class="bd cont">
  <section class="section login">
    <div class="user-login">
      <div class="user-form">
        <header class="section-header">
          <h3 class="section-title">
          Login
          </h3>
        </header>
        <? echo ($cont != 1) ? $cont : ''; ?>
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
