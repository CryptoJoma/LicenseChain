<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono&display=swap" rel="stylesheet">
    <link href="https://licensechain.app/assets/css/style.css" rel="stylesheet">
    <link href="https://licensechain.app/assets/css/extra.css" rel="stylesheet">
    <title>License Chain</title>
</head>
<body>
  <div id="aa-wp">
    <header id="hd" class="hd">
        <div class="top">
          <div class="cont">
          <button id="menu-btn" class="btn menu-btn lnk"><i class="menu-icon" aria-hidden="true">menu</i></button>
          <figure class="logo"><a href="/"><img src="https://licensechain.app/assets/logo.png" alt="License Chain" width="120" height="49"></a></figure>
          <? if ($is_user === 1) { ?>

          <nav>
            <ul class="menu">
              <? include("navbar.php"); ?>

            </ul>
          </nav>
          <div class="mode" style="display: none;">
            <button type="button" class="btn btn-mode lnk npd">
            <i class="fa-sun"><span aria-hidden="true" hidden>dia</span></i>
            <i class="fa-moon"><span aria-hidden="true" hidden>noche</span></i>
            </button>
          </div>
          <div class="user-box aa-drp left">
            <? if ($user["role"] == 4 || $user["role"] == 5) { ?>
              <a href="/profile" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">👤 Profile</a>
            <? } ?>
            <a href="/logout" class="text-sm md:text-base lg:text-lg px-4 sm:px-6 py-2 rounded hover:text-blue-300">Logout</a>
          </div>

          <? } ?>
        </div>
      </div>
    </header>
