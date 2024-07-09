<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono&display=swap" rel="stylesheet">
    <link href="https://licenses.joma.dev/assets/css/style.css" rel="stylesheet">
    <link href="https://licenses.joma.dev/assets/css/extra.css" rel="stylesheet">
    <title>License Chain</title>
</head>
<body>
  <div id="aa-wp">
    <header id="hd" class="hd">
        <div class="top">
          <div class="cont">
          <button id="menu-btn" class="btn menu-btn lnk"><i class="menu-icon" aria-hidden="true">menu</i></button>
          <figure class="logo"><a href="/"><img src="https://licenses.joma.dev/assets/logo.png" alt="License Chain" width="120" height="49"></a></figure>
          <nav>
            <ul class="menu">
              <li><a href="/" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔧 Dashboard</a></li>
              <li><a href="/licenses" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🔑 Bots &amp; Deposits</a></li>
              <? if($_SESSION['role'] != 4 && !is_null($_SESSION['role'])) { ?>
                <li><a href="/minutes" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">⏱️ Minutes</a></li>
              <? } ?>
              <li><a href="https://t.me/JomaDev" target="_blank" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">🤝 Support</a></li>

            </ul>
          </nav>
          <div class="mode" style="display: none;">
            <button type="button" class="btn btn-mode lnk npd">
            <i class="fa-sun"><span aria-hidden="true" hidden>dia</span></i>
            <i class="fa-moon"><span aria-hidden="true" hidden>noche</span></i>
            </button>
          </div>
          <div class="user-box aa-drp left">
            <a href="/profile" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">👤 Profile</a>
            <a href="/logout" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">Logout</a>
          </div>
        </div>
      </div>
    </header>
