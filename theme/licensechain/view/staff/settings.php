<div class="bd cont">
  <section class="section login">
    <div class="user-login">
      <div class="user-form">
        <header class="section-header">
          <h3 class="section-title">
          Wallets
          </h3>
        </header>
        <? echo ($cont != 1) ? $cont : ''; ?>
        <form method="post" action="/login">
          <p>
            <label for="user">USDT(TRC20)</label>
            <input id="USDT" name="USDT" type="text" value="">
          </p>
          <p>
            <label for="user">USDC(BASE)</label>
            <input id="USDC" name="USDC" type="text" value="">
          </p>
          <p>
            <label for="user">ETH</label>
            <input id="ETH" name="ETH" type="text" value="">
          </p>
          <p>
            <label for="user">BTC</label>
            <input id="BTC" name="BTC" type="text" value="">
          </p>
          <p>
            <label for="user">LTC</label>
            <input id="LTC" name="LTC" type="text" value="">
          </p>
          <p class="forget">
            <button type="submit" class="btn send-btn">Submit</button>
          </p>
        </form>
      </div>
      <div class="user-why">
      <figure class="bg"><img src="https://licensechain.app/assets/bg.webp" alt="bg"></figure>
      <header class="section-header">
        <h3 class="section-title">FAQs?</h3>
      </header>
      <p class="fa-check-b">When are deposits made?<br>Deposits are made on the 7th day of every month.</p>
<p class="fa-check-b">What currency do you use to pay?<br>Depending on network congestion, payment is sent via the network with the lowest cost that you have set up in your wallet.</p>
<p class="fa-check-b">What happens if I have the wrong address?<br>We are sorry to hear that. However, there is nothing we can do on our end. Once the payment has been sent, it cannot be canceled within the network.</p>
      </div>
    </div>
  </section>
</div>
